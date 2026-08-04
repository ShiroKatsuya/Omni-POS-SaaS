<?php

namespace App\Http\Controllers;

use App\Services\KasirApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private KasirApiService $kasirApi;

    public function __construct(KasirApiService $kasirApi)
    {
        $this->kasirApi = $kasirApi;
    }

    /**
     * Process checkout from landing page.
     * Sends order data to the Sistem Kasir via API.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.productId' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'paymentMethod' => 'required|string',
            'customerName' => 'nullable|string|max:255',
            'customerPhone' => 'nullable|string|max:20',
            'customerEmail' => 'nullable|email|max:255',
            'note' => 'nullable|string|max:500',
        ]);

        $items = collect($validated['items'])->map(fn($item) => [
            'productId' => $item['productId'],
            'quantity' => (int) $item['quantity'],
        ])->toArray();

        $customer = array_filter([
            'name' => $validated['customerName'] ?? null,
            'phone' => $validated['customerPhone'] ?? null,
            'email' => $validated['customerEmail'] ?? null,
        ]);

        $result = $this->kasirApi->checkout(
            $items,
            $validated['paymentMethod'],
            $customer,
            $validated['note'] ?? null
        );

        // For AJAX requests, return JSON
        if ($request->expectsJson()) {
            return response()->json($result);
        }

        // For form submissions, redirect to result page
        if (!empty($result['success']) && !empty($result['transaction'])) {
            return redirect()->route('checkout.result')
                ->with('transaction', $result['transaction']);
        }

        return back()->with('error', $result['error'] ?? 'Terjadi kesalahan saat memproses pesanan.');
    }

    /**
     * Display checkout result page.
     */
    public function result(): View
    {
        $transaction = session('transaction');

        if (!$transaction) {
            return view('checkout-result', ['transaction' => null]);
        }

        return view('checkout-result', ['transaction' => $transaction]);
    }
}
