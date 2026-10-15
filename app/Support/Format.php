<?php

namespace App\Support;

use Carbon\CarbonInterface;

class Format
{
    /**
     * Format rupiah tanpa desimal, contoh: Rp 1.250.000 atau -Rp 50.000.
     */
    public static function rupiah(int|float|string|null $amount): string
    {
        $value = round((float) $amount);
        $sign = $value < 0 ? '-' : '';

        return $sign . 'Rp ' . number_format(abs($value), 0, ',', '.');
    }

    /**
     * Format tanggal konsisten: 15 Okt 2026 (nama bulan mengikuti APP_LOCALE).
     */
    public static function date(?CarbonInterface $date): string
    {
        return $date ? $date->translatedFormat('d M Y') : '-';
    }

    public static function walletType(string $type): string
    {
        return match ($type) {
            'CASH' => 'Tunai',
            'BANK' => 'Bank',
            'E_WALLET' => 'E-Wallet',
            default => $type,
        };
    }

    public static function walletTypeColor(string $type): string
    {
        return match ($type) {
            'CASH' => 'amber',
            'BANK' => 'sky',
            'E_WALLET' => 'violet',
            default => 'slate',
        };
    }

    /**
     * Label untuk tipe INCOME / EXPENSE (transaksi maupun kategori).
     */
    public static function flowType(string $type): string
    {
        return $type === 'INCOME' ? 'Pemasukan' : 'Pengeluaran';
    }

    public static function flowTypeColor(string $type): string
    {
        return $type === 'INCOME' ? 'emerald' : 'red';
    }
}