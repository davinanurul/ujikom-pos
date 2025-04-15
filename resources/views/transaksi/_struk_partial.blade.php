<div class="struk-container">
    <h4 class="text-center">Nama Toko</h4>
    <p class="text-center">Jl. Contoh Alamat No. 123</p>
    <p class="text-center">0812-XXXX-XXXX</p>
    <hr>
    <p>No Transaksi : {{ $transaksi->nomor_transaksi }}</p>
    <p>Tanggal : {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}</p>
    <p>Pembayaran : {{ $transaksi->pembayaran }}</p>
    <p>Member : {{ $transaksi->member->nama ?? '-' }}</p>
    <hr>
    <table class="struk-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-right">Sub</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailTransaksi as $detail)
                <tr>
                    <td>
                        {{ $detail->produk->nama ?? '-' }}<br>
                        {{ $detail->varian->warna ?? '-' }} / {{ $detail->varian->size ?? '-' }} x{{ $detail->qty }}<br>
                        @ Rp{{ number_format($detail->harga) }}
                    </td>
                    <td class="text-right">Rp{{ number_format($detail->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="struk-total text-right">Total: Rp{{ number_format($transaksi->total) }}</p>
    <hr>
    <p class="text-center">Terima kasih telah berbelanja</p>
</div>
