<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Transfer</h1>
            <p class="text-muted mb-0">
                Riwayat perpindahan saldo antar-wallet.
            </p>
        </div>

        <a href="{{ route('transfers.create') }}"
           class="btn btn-primary">
            + Tambah Transfer
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($transfers->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <h5>Belum ada transfer</h5>
                <p class="text-muted">
                    Tambahkan transfer pertama untuk memindahkan saldo antar-wallet.
                </p>
                <a href="{{ route('transfers.create') }}"
                   class="btn btn-primary">
                    Tambah Transfer
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Dari Wallet</th>
                            <th>Ke Wallet</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $transfer)
                            <tr>
                                <td>
                                    {{ $transfer->transfer_date->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ $transfer->fromWallet->name }}
                                </td>
                                <td>
                                    {{ $transfer->toWallet->name }}
                                </td>
                                <td class="fw-semibold">
                                    Rp{{ number_format((float) $transfer->amount, 2, ',', '.') }}
                                </td>
                                <td>
                                    {{ $transfer->description ?: '-' }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('transfers.show', $transfer) }}"
                                           class="btn btn-sm btn-outline-info">
                                            Detail
                                        </a>

                                        <a href="{{ route('transfers.edit', $transfer) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>

                                        <form action="{{ route('transfers.destroy', $transfer) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus transfer ini? Saldo wallet akan disesuaikan.');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                {{ $transfers->links() }}
            </div>
        </div>
    @endif
</div>

