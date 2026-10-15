<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Detail Transfer</h1>
            <p class="text-muted mb-0">
                Informasi lengkap perpindahan saldo.
            </p>
        </div>

        <a href="{{ route('transfers.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <div class="text-muted small">Jumlah Transfer</div>
                <h2 class="text-primary">
                    Rp{{ number_format((float) $transfer->amount, 2, ',', '.') }}
                </h2>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Wallet Asal</div>
                <div class="col-md-8 fw-semibold">
                    {{ $transfer->fromWallet->name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Wallet Tujuan</div>
                <div class="col-md-8 fw-semibold">
                    {{ $transfer->toWallet->name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Tanggal Transfer</div>
                <div class="col-md-8">
                    {{ $transfer->transfer_date->format('d/m/Y') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Keterangan</div>
                <div class="col-md-8">
                    {{ $transfer->description ?: '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Dibuat</div>
                <div class="col-md-8">
                    {{ $transfer->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                <div class="col-md-8">
                    {{ $transfer->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('transfers.edit', $transfer) }}"
                   class="btn btn-primary">
                    Edit Transfer
                </a>

                <form action="{{ route('transfers.destroy', $transfer) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus transfer ini? Saldo wallet akan disesuaikan.');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Hapus Transfer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>