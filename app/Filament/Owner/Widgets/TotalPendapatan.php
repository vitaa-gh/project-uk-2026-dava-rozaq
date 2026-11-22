<?php

namespace App\Filament\Owner\Widgets;

use App\Models\TbTransaksi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalPendapatan extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPendapatan = TbTransaksi::where('status', 'keluar')
            ->sum('biaya_total');

        return [
            Stat::make(
                'Total Pendapatan',
                'Rp ' . number_format($totalPendapatan, 0, ',', '.')
            )
                ->description('Total pendapatan parkir')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}