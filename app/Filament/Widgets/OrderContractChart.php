<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderContractChart extends ChartWidget
{
    protected static ?string $heading = 'Order Contract';

    public static function canView(): bool
    {
        return Auth::user()->can('widget_OrderContractChart');
    }

    protected function getData(): array
    {
        $orderCountsPerContractType = Order::select('contracts.name as contract_name', DB::raw('count(orders.id) as order_count'))
            ->leftJoin('contracts', 'orders.contract_id', '=', 'contracts.id')
            ->groupBy('contracts.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Orders per Contract',
                    'data'  => $orderCountsPerContractType->pluck('order_count')
                ],
            ],
            'labels'   => $orderCountsPerContractType->pluck('contract_name')
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
