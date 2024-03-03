<?php

namespace App\Models;

use App\Actions\Stripe\PaymentIntent\RetrievePaymentIntent;
use App\Enums\Currency;
use App\Enums\Stripe\PaymentIntentStatus;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(OrderObserver::class)]
class Order extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $fillable = [
        'email',
        'price',
        'answers',
        'contract_id',
        'payment_intent_id',
        'payment_status',
        'currency',
    ];

    protected $casts = [
        'answers'        => 'array',
        'price'          => 'int',
        'payment_status' => PaymentIntentStatus::class,
        'currency'       => Currency::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    protected function stripePaymentIntent(): Attribute
    {
        return Attribute::get(fn() => app(RetrievePaymentIntent::class)->execute($this->payment_intent_id));
    }
}
