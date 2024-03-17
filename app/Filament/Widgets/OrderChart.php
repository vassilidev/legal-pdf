<?php

namespace App\Filament\Widgets;

use App\Enums\Stripe\PaymentIntentStatus;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Orders';

    protected function getData(): array
    {
        $data = Trend::query(Order::wherePaymentStatus(PaymentIntentStatus::SUCCEEDED))
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Order per day',
                    'data'  => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels'   => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
