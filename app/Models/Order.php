<?php

namespace App\Models;

use App\Actions\Stripe\PaymentIntent\CreatePaymentIntent;
use App\Actions\Stripe\PaymentIntent\RetrievePaymentIntent;
use App\Enums\Currency;
use App\Enums\Stripe\PaymentIntentStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stripe\Exception\ApiErrorException;

class Order extends Model
{
    use HasUuids,
        SoftDeletes;

    protected $fillable = [
        'email',
        'answers',
        'contract_id',
        'payment_intent_id',
        'payment_status',
        'currency',
        'signature_option',
        'invoicing_name',
        'invoicing_address',
    ];

    protected $casts = [
        'answers'          => 'array',
        'payment_status'   => PaymentIntentStatus::class,
        'currency'         => Currency::class,
        'signature_option' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalDue(): int
    {
        $price = 0;

        foreach ($this->products as $product) {
            $price += $product->getTotalPrice();
        }

        return $price;
    }

    /**
     * @throws ApiErrorException
     */
    public function createPaymentIntent(): void
    {
        $paymentIntent = app(CreatePaymentIntent::class)->execute(
            price: $this->getTotalDue(),
            currency: $this->currency->value,
        );

        $this->payment_intent_id = $paymentIntent->id;
        $this->payment_status = $paymentIntent->status;

        $this->save();
    }

    protected function stripePaymentIntent(): Attribute
    {
        return Attribute::get(fn() => app(RetrievePaymentIntent::class)->execute($this->payment_intent_id));
    }
}
