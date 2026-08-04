@extends('layouts.app')

@section('title', 'Hasil Pesanan — Aderose Glowing Salon')
@section('meta_description', 'Konfirmasi pesanan layanan di Aderose Glowing Salon.')

@section('content')
<section class="section-padding" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @if ($transaction)
                <div class="text-center mb-4 reveal">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%;">
                        <i class="bi bi-check-lg text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h2 class="section-title">Pesanan Berhasil!</h2>
                    <p class="section-text">Terima kasih, pesanan Anda telah tercatat di sistem kami.</p>
                </div>

                <div class="card border-0 shadow-sm reveal" style="border-radius: 1.5rem; overflow: hidden;">
                    <div class="card-header py-3 px-4" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-white fw-semibold">
                                <i class="bi bi-receipt me-2"></i>Detail Transaksi
                            </span>
                            <span class="badge bg-success bg-opacity-25 text-white px-3 py-2" style="border-radius: 2rem;">
                                {{ $transaction['status'] ?? 'COMPLETED' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">No. Transaksi</small>
                                <strong style="color: #b8860b;">{{ $transaction['receiptId'] ?? '-' }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Tanggal</small>
                                <strong>{{ isset($transaction['createdAt']) ? \Carbon\Carbon::parse($transaction['createdAt'])->format('d M Y, H:i') : now()->format('d M Y, H:i') }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <strong>{{ $transaction['paymentMethod'] ?? '-' }}</strong>
                            </div>
                            @if (!empty($transaction['customer']))
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Pelanggan</small>
                                <strong>{{ $transaction['customer']['name'] ?? '-' }}</strong>
                            </div>
                            @endif
                        </div>

                        @if (!empty($transaction['items']))
                        <h6 class="fw-bold mb-3" style="color: #1a1a2e;">Layanan yang Dipesan</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr style="border-bottom: 2px solid #f0f0f0;">
                                        <th class="text-muted small">Layanan</th>
                                        <th class="text-muted small text-center">Qty</th>
                                        <th class="text-muted small text-end">Harga</th>
                                        <th class="text-muted small text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction['items'] as $item)
                                    <tr>
                                        <td class="fw-semibold">{{ $item['product']['name'] ?? 'Layanan' }}</td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-end">Rp{{ number_format($item['unitPrice'], 0, ',', '.') }}</td>
                                        <td class="text-end">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <hr class="my-3">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span>Rp{{ number_format($transaction['subtotal'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if (($transaction['tax'] ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pajak</span>
                            <span>Rp{{ number_format($transaction['tax'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between pt-2" style="border-top: 2px solid #1a1a2e;">
                            <strong class="fs-5">Total</strong>
                            <strong class="fs-5" style="color: #b8860b;">Rp{{ number_format($transaction['total'] ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4 reveal">
                    <p class="text-muted mb-3">
                        <i class="bi bi-whatsapp me-1"></i>
                        Tim kami akan menghubungi Anda untuk konfirmasi jadwal treatment.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-luxury btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>

                @else
                <div class="text-center reveal">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%;">
                        <i class="bi bi-exclamation-lg text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h2 class="section-title">Tidak Ada Data Transaksi</h2>
                    <p class="section-text">Halaman ini hanya dapat diakses setelah melakukan pemesanan.</p>
                    <a href="{{ route('home') }}" class="btn btn-luxury btn-lg mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
