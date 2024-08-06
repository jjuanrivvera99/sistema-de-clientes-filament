<?php

namespace App\Livewire;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CustomerStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Clientes', Customer::count())
                ->url('/admin/customers'),
            Stat::make('Clientes Nuevos Este Mes', Customer::whereMonth('created_at', now()->month)->count())
                ->color('success')
                ->chart([1, 2, 3, 56, 100, 1000]),
            Stat::make('Clientes Eliminados', Customer::onlyTrashed()->count())
                ->color('danger')
                ->chart([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
                ->url('/admin/trashed-customers'),
            Stat::make('Afiliaciones Activas', Customer::whereHas('membership', function ($query) {
                $query->where('membership_status', 'active');
            })->count()),
            Stat::make('Afiliaciones Inactivas', Customer::whereHas('membership', function ($query) {
                $query->where('membership_status', 'inactive');
            })->count()),
        ];
    }
}
