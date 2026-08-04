{{-- Checkout Modal — integrated with Sistem Kasir API --}}
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 1.5rem; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border: none; padding: 1.5rem 2rem;">
                <h5 class="modal-title text-white" id="checkoutModalLabel">
                    <i class="bi bi-bag-heart me-2"></i>Pesan Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                {{-- Selected Service Summary --}}
                <div id="selectedServiceSummary" class="mb-4 p-3 rounded-4" style="background: linear-gradient(135deg, #f8f4f0 0%, #fdf6ee 100%);">
                    <div class="d-flex align-items-center gap-3">
                        <div id="serviceIcon" class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: linear-gradient(135deg, #b8860b, #d4a574); border-radius: 12px; color: white; font-size: 1.2rem;">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <h6 id="serviceName" class="mb-0 fw-bold" style="color: #1a1a2e;">Layanan</h6>
                            <small id="servicePrice" class="text-muted">Rp0</small>
                        </div>
                    </div>
                </div>

                <form id="checkoutForm">
                    @csrf
                    <input type="hidden" id="checkout_productId" name="productId">
                    <input type="hidden" id="checkout_price" name="price">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="checkout_name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input id="checkout_name" type="text" class="form-control" placeholder="Nama Anda" required
                                   style="border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="checkout_phone" class="form-label fw-semibold">Nomor HP</label>
                            <input id="checkout_phone" type="tel" class="form-control" placeholder="08xxxxxxxxxx" required
                                   style="border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="checkout_email" class="form-label fw-semibold">Email <small class="text-muted">(opsional)</small></label>
                            <input id="checkout_email" type="email" class="form-control" placeholder="nama@email.com"
                                   style="border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="checkout_qty" class="form-label fw-semibold">Jumlah</label>
                            <input id="checkout_qty" type="number" class="form-control" value="1" min="1" max="10"
                                   style="border-radius: 0.75rem; padding: 0.75rem 1rem;">
                        </div>
                        <div class="col-md-6">
                            <label for="checkout_payment" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select id="checkout_payment" class="form-select" required
                                    style="border-radius: 0.75rem; padding: 0.75rem 1rem;">
                                <option value="Cash">Cash</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Total Estimasi</label>
                            <div id="checkout_total" class="form-control-plaintext fw-bold fs-5" style="color: #b8860b;">
                                Rp0
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="checkout_note" class="form-label fw-semibold">Catatan <small class="text-muted">(opsional)</small></label>
                            <textarea id="checkout_note" class="form-control" rows="2" placeholder="Contoh: Saya ingin booking jam 14:00"
                                      style="border-radius: 0.75rem; padding: 0.75rem 1rem;"></textarea>
                        </div>
                    </div>

                    {{-- Error/Success Messages --}}
                    <div id="checkoutAlert" class="mt-3 d-none"></div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" id="checkoutSubmitBtn" class="btn btn-luxury btn-lg flex-grow-1">
                            <i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('checkoutModal');
    const form = document.getElementById('checkoutForm');
    const qtyInput = document.getElementById('checkout_qty');
    const totalEl = document.getElementById('checkout_total');
    const priceInput = document.getElementById('checkout_price');
    const alertEl = document.getElementById('checkoutAlert');
    const submitBtn = document.getElementById('checkoutSubmitBtn');

    let currentPrice = 0;

    // Format currency
    function formatRupiah(num) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(num);
    }

    // Update total when quantity changes
    if (qtyInput) {
        qtyInput.addEventListener('input', function () {
            const qty = parseInt(this.value) || 1;
            totalEl.textContent = formatRupiah(currentPrice * qty);
        });
    }

    // Listen for modal show event to populate data
    if (modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const productId = trigger.getAttribute('data-product-id');
            const productName = trigger.getAttribute('data-product-name');
            const productPrice = parseFloat(trigger.getAttribute('data-product-price')) || 0;
            const productIcon = trigger.getAttribute('data-product-icon') || 'bi-stars';

            document.getElementById('checkout_productId').value = productId;
            document.getElementById('serviceName').textContent = productName;
            document.getElementById('servicePrice').textContent = formatRupiah(productPrice);
            document.getElementById('serviceIcon').innerHTML = '<i class="bi ' + productIcon + '"></i>';
            priceInput.value = productPrice;
            currentPrice = productPrice;
            qtyInput.value = 1;
            totalEl.textContent = formatRupiah(productPrice);

            // Reset form state
            alertEl.className = 'mt-3 d-none';
            alertEl.textContent = '';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan';
        });
    }

    // Handle form submit
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const productId = document.getElementById('checkout_productId').value;
            const quantity = parseInt(qtyInput.value) || 1;

            if (!productId) {
                showAlert('danger', 'Layanan tidak valid. Silakan pilih ulang.');
                return;
            }

            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            alertEl.className = 'mt-3 d-none';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    || document.querySelector('input[name="_token"]')?.value;

                const response = await fetch('{{ route("checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        items: [{ productId: productId, quantity: quantity }],
                        paymentMethod: document.getElementById('checkout_payment').value,
                        customerName: document.getElementById('checkout_name').value,
                        customerPhone: document.getElementById('checkout_phone').value,
                        customerEmail: document.getElementById('checkout_email').value || null,
                        note: document.getElementById('checkout_note').value || null,
                    }),
                });

                const data = await response.json();

                if (data.success && data.transaction) {
                    showAlert('success',
                        '<i class="bi bi-check-circle me-2"></i>' +
                        '<strong>Pesanan berhasil!</strong><br>' +
                        'No. Transaksi: <strong>' + data.transaction.receiptId + '</strong><br>' +
                        'Total: <strong>' + formatRupiah(data.transaction.total) + '</strong><br>' +
                        '<small class="text-muted">Tim kami akan menghubungi Anda untuk konfirmasi jadwal.</small>'
                    );
                    submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Pesanan Terkirim';
                    // Reset form fields but keep the success message
                    document.getElementById('checkout_name').value = '';
                    document.getElementById('checkout_phone').value = '';
                    document.getElementById('checkout_email').value = '';
                    document.getElementById('checkout_note').value = '';
                    qtyInput.value = 1;
                } else {
                    showAlert('danger', '<i class="bi bi-exclamation-triangle me-2"></i>' + (data.error || 'Terjadi kesalahan. Silakan coba lagi.'));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan';
                }
            } catch (error) {
                showAlert('danger', '<i class="bi bi-wifi-off me-2"></i>Tidak dapat terhubung ke server. Silakan coba lagi.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-bag-check me-2"></i>Konfirmasi Pesanan';
            }
        });
    }

    function showAlert(type, message) {
        alertEl.className = 'mt-3 alert alert-' + type;
        alertEl.innerHTML = message;
    }
});
</script>
