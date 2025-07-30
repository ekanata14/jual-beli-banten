@extends('layouts.landing')
@section('content')
    <div class="flex flex-col main_content pt-40 pb-20 px-4 md:px-36 gap-10" data-aos="fade-up">
        <h3 class="mb-5" data-aos="zoom-in" data-aos-delay="700">
            Riwayat Transaksi
        </h3>
        <div class="bg-white py-6 px-5 w-full rounded-md">
            <!-- Search & Filter -->
            <form id="history-search-form" class="mb-6 flex flex-col md:flex-row gap-4 items-center">
            <input type="text" name="invoice" id="invoice-input" placeholder="Cari Invoice..."
                class="border rounded px-3 py-2 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <select name="status" id="status-select"
                class="border rounded px-3 py-2 w-full md:w-40 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
            </form>

            <!-- Transaction History Card -->
            <div id="history-list">
            <div class="text-gray-500 text-center py-8" data-aos="fade-up" data-aos-delay="400">Memuat data...</div>
            </div>
            <div class="mt-6 flex justify-center" id="pagination-container"></div>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Data dari blade ke JS
            const histories = @json($datas);

            function filterHistories(invoice, status) {
            return histories.filter(item => {
                let matchInvoice = !invoice || (item.invoice_number && item.invoice_number.toLowerCase().includes(invoice.toLowerCase()));
                let matchStatus = !status || item.status === status;
                return matchInvoice && matchStatus;
            });
            }

            function paginate(array, page_size, page_number) {
            // page_number starts from 1
            return array.slice((page_number - 1) * page_size, page_number * page_size);
            }

            function renderHistory(datas, currentPage, lastPage) {
            let html = '';
            if (datas.length === 0) {
                html = `<div class="text-gray-500 text-center py-8" data-aos="fade-up" data-aos-delay="400">Belum ada riwayat transaksi.</div>`;
            } else {
                datas.forEach(function(item, index) {
                let statusHtml = '';
                if (item.status === 'pending') {
                    statusHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">Pending</span>`;
                } else if (item.status === 'denied') {
                    statusHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded bg-red-100 text-red-800 text-xs font-medium">Denied</span>`;
                } else if (item.status === 'waiting') {
                    statusHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-medium">Waiting</span>`;
                } else if (item.status === 'paid') {
                    statusHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded bg-green-100 text-green-800 text-xs font-medium">Paid</span>`;
                } else {
                    statusHtml = `<span class="inline-flex items-center px-2.5 py-0.5 rounded bg-gray-100 text-gray-800 text-xs font-medium">${item.status_pembayaran ? item.status_pembayaran.charAt(0).toUpperCase() + item.status_pembayaran.slice(1) : 'Unknown'}</span>`;
                }

                let actionsHtml = '';
                if (item.status === 'paid') {
                    actionsHtml = `
                    <a href="/transaction/success/${item.id}" class="inline-block px-4 py-2 border border-green-400 text-green-700 text-sm rounded-lg hover:bg-green-50">Lihat Bukti</a>
                    <a href="/history/detail/${item.id}" class="inline-block px-4 py-2 border border-gray-300 text-sm rounded-lg hover:bg-gray-100">Detail</a>
                    `;
                } else if (item.step == 1) {
                    actionsHtml = `<a href="/checkout/${item.id}" class="inline-block px-4 py-2 border border-blue-400 text-blue-700 text-sm rounded-lg hover:bg-blue-50">Lanjut Checkout</a>`;
                } else if (item.step == 2) {
                    actionsHtml = `<a href="/checkout/second/${item.id}" class="inline-block px-4 py-2 border border-blue-400 text-blue-700 text-sm rounded-lg hover:bg-blue-50">Lanjut Checkout</a>`;
                } else if (item.step == 3) {
                    actionsHtml = `<a href="/checkout/third/${item.id}" class="inline-block px-4 py-2 border border-blue-400 text-blue-700 text-sm rounded-lg hover:bg-blue-50">Lanjut Checkout</a>`;
                } else if (item.step == 4) {
                    actionsHtml = `<a href="/checkout/fourth/${item.id}" class="inline-block px-4 py-2 border border-blue-400 text-blue-700 text-sm rounded-lg hover:bg-blue-50">Lanjut Checkout</a>`;
                } else if (item.step == 5) {
                    actionsHtml = `
                    <form action="/checkout/store" method="POST" id="checkout-form-${item.id}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_transaksi" value="${item.id}">
                        <input type="hidden" name="id_order" value="${item.orders && item.orders[0] ? item.orders[0].id : ''}">
                        ${(item.orders || []).map(kirim => `<input type="hidden" name="id_pengiriman[]" value="${kirim.pengiriman.id}">`).join('')}
                        <input type="hidden" name="total_harga" value="${parseInt(item.total_harga)}">
                        <button type="button" class="inline-block px-4 py-2 border border-blue-400 text-blue-700 text-sm rounded-lg hover:bg-blue-50" onclick="confirmPayment(${item.id})">Lanjut Ke Pembayaran</button>
                    </form>
                    `;
                }

                html += `
                    <div class="p-6 bg-white rounded-lg flex flex-col md:flex-row md:items-center md:justify-between history_card" data-aos="fade-up" data-aos-delay="${400 + index * 100}">
                    <div class="flex flex-col gap-1" data-aos="fade-up" data-aos-delay="${450 + index * 100}">
                        <a href="/history/detail/${item.id}" class="text-lg font-semibold text-blue-600 hover:underline">${item.invoice_number ?? '-'}</a>
                        <span class="text-sm text-gray-500">${item.created_at ? item.created_at : '-'}</span>
                    </div>
                    <div class="mt-4 md:mt-0 md:text-center" data-aos="fade-up" data-aos-delay="${500 + index * 100}">
                        <p class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">${item.orders ? item.orders.reduce((a, b) => a + (b.jumlah || 0), 0) : '-'}</span> items
                        </p>
                        <p class="text-sm text-gray-500">
                        <span class="font-medium text-gray-900">IDR ${item.total_harga ? Number(item.total_harga).toLocaleString('id-ID') : '0'}</span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0" data-aos="fade-up" data-aos-delay="${550 + index * 100}">
                        ${statusHtml}
                    </div>
                    <div class="mt-4 md:mt-0 flex gap-2" data-aos="fade-up" data-aos-delay="${600 + index * 100}">
                        ${actionsHtml}
                    </div>
                    </div>
                `;
                });
            }
            document.getElementById('history-list').innerHTML = html;
            }

            function renderPagination(currentPage, lastPage) {
            let html = '';
            if (lastPage <= 1) {
                document.getElementById('pagination-container').innerHTML = '';
                return;
            }
            for (let i = 1; i <= lastPage; i++) {
                html += `<button class="mx-1 px-3 py-1 rounded ${i === currentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'}" onclick="loadHistory(${i})">${i}</button>`;
            }
            document.getElementById('pagination-container').innerHTML = html;
            }

            function loadHistory(page = 1) {
            const invoice = document.getElementById('invoice-input').value;
            const status = document.getElementById('status-select').value;
            document.getElementById('history-list').innerHTML = `<div class="text-gray-500 text-center py-8" data-aos="fade-up" data-aos-delay="400">Memuat data...</div>`;

            const filtered = filterHistories(invoice, status);
            const pageSize = 5;
            const lastPage = Math.ceil(filtered.length / pageSize) || 1;
            const paginated = paginate(filtered, pageSize, page);

            renderHistory(paginated, page, lastPage);
            renderPagination(page, lastPage);
            }

            document.getElementById('history-search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            loadHistory(1);
            });

            window.loadHistory = loadHistory; // make global for pagination
            window.confirmPayment = function(id) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin ingin melanjutkan ke pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                document.getElementById('checkout-form-' + id).submit();
                }
            });
            };

            document.addEventListener('DOMContentLoaded', function() {
            loadHistory();
            });
        </script>
        @endpush
    </div>
    </div>
@endsection
