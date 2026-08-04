<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * HTTP client service for communicating with the Sistem Kasir (NestJS) REST API.
 * 
 * The Landing Page acts as a client/consumer only — all business logic
 * (transactions, pricing, stock, etc.) is handled by the Sistem Kasir.
 */
class KasirApiService
{
    private string $baseUrl;
    private string $tenantSlug;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('kasir.api_url');
        $this->tenantSlug = config('kasir.tenant_slug');
        $this->timeout = config('kasir.timeout', 10);
    }

    /**
     * Get public store information.
     */
    public function getStoreInfo(): ?array
    {
        return $this->cachedGet("kasir:store_info:{$this->tenantSlug}", 10, "/landing/{$this->tenantSlug}/info");
    }

    /**
     * Get all active products/services from the POS system.
     */
    public function getProducts(?string $categoryId = null, ?string $search = null): array
    {
        $query = array_filter([
            'categoryId' => $categoryId,
            'search' => $search,
        ]);

        $cacheKey = "kasir:products:{$this->tenantSlug}:" . md5(serialize($query));

        return $this->cachedGet($cacheKey, 5, "/landing/{$this->tenantSlug}/products", $query) ?? [];
    }

    /**
     * Get all categories from the POS system.
     */
    public function getCategories(): array
    {
        return $this->cachedGet("kasir:categories:{$this->tenantSlug}", 5, "/landing/{$this->tenantSlug}/categories") ?? [];
    }

    /**
     * Submit a checkout to the POS system.
     * This is NOT cached — it's a write operation.
     */
    public function checkout(array $items, string $paymentMethod, array $customer = [], ?string $note = null): array
    {
        $payload = [
            'items' => $items,
            'paymentMethod' => $paymentMethod,
        ];

        if (!empty($customer['name'])) {
            $payload['customerName'] = $customer['name'];
        }
        if (!empty($customer['phone'])) {
            $payload['customerPhone'] = $customer['phone'];
        }
        if (!empty($customer['email'])) {
            $payload['customerEmail'] = $customer['email'];
        }
        if ($note) {
            $payload['note'] = $note;
        }

        try {
            $response = Http::timeout($this->timeout)
                ->acceptJson()
                ->post("{$this->baseUrl}/landing/{$this->tenantSlug}/checkout", $payload);

            if ($response->successful()) {
                // Clear product cache after successful checkout (stock may have changed)
                $this->clearProductCache();
                return $response->json();
            }

            Log::warning('Kasir API checkout failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'error' => $response->json('message', 'Checkout failed'),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Kasir API checkout error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Tidak dapat terhubung ke sistem kasir. Silakan coba lagi.',
            ];
        }
    }

    /**
     * Helper: GET request with caching.
     */
    private function cachedGet(string $cacheKey, int $minutes, string $endpoint, array $query = []): ?array
    {
        return Cache::remember($cacheKey, now()->addMinutes($minutes), function () use ($endpoint, $query) {
            try {
                $response = Http::timeout($this->timeout)
                    ->acceptJson()
                    ->get("{$this->baseUrl}{$endpoint}", $query);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning('Kasir API request failed', [
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                ]);

                return null;
            } catch (\Exception $e) {
                Log::error('Kasir API connection error', [
                    'endpoint' => $endpoint,
                    'message' => $e->getMessage(),
                ]);

                return null;
            }
        });
    }

    /**
     * Clear cached product/category data.
     */
    public function clearProductCache(): void
    {
        Cache::forget("kasir:products:{$this->tenantSlug}:" . md5(serialize([])));
        Cache::forget("kasir:categories:{$this->tenantSlug}");
    }
}
