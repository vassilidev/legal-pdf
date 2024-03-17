<?php

namespace App\Models;

use App\Enums\Currency;
use App\Observers\ContractObserver;
use App\Services\ContractHelper;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read  mixed $final_schema
 */
#[ObservedBy(ContractObserver::class)]
class Contract extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'signature_price',
        'slug',
        'content',
        'is_published',
        'form_schema',
        'currency',
        'signature_url',
        'direction',
    ];

    protected $casts = [
        'price'           => 'int',
        'signature_price' => 'int',
        'form_schema'     => 'array',
        'currency'        => Currency::class,
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeUnpublished(Builder $query): Builder
    {
        return $query->where('is_published', false);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function render(
        array  $answers = [],
        ?Order $order = null,
    ): string
    {
        $helper = new ContractHelper($this, answers: $answers, order: $order);

        return Blade::render(
            string: $helper->render(),
            data: [
                'contractHelper' => $helper,
                'answers'        => optional($answers),
            ],
        );
    }

    /**
     * @throws \JsonException
     */
    public function getFinalSchemaAttribute(): array
    {
        $schema = $this->form_schema;

        if ($this->signature_price) {
            $schema['components'][] = json_decode(str_replace(
                '{{ contract.signature_option_text }}',
                __('contract.signature_option_text'),
                setting('builder.signature_component')
            ), true, 512, JSON_THROW_ON_ERROR);
        }


        if (Auth::check()) {
            return $schema;
        }

        $schema['components'][] = json_decode(str_replace(
            '{{ contract.email_option_text }}',
            __('contract.email_option_text'),
            setting('builder.final_component')
        ), true, 512, JSON_THROW_ON_ERROR);

        return $schema;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('signature');
    }
}
