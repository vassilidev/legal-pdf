<?php

namespace App\Models;

use App\Observers\ContractObserver;
use App\Services\ContractHelper;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Blade;

#[ObservedBy(ContractObserver::class)]
class Contract extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'signature_price',
        'slug',
        'content',
        'is_published',
        'form_schema'
    ];

    protected $casts = [
        'price'           => 'int',
        'signature_price' => 'int',
        'form_schema'     => 'array',
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

    public function render(array $answers = []): string
    {
        $helper = new ContractHelper($this, $answers);

        return Blade::render(
            string: $helper->render(),
            data: [
                'contractHelper' => $helper,
                'answers'        => optional($answers),
            ],
        );
    }
}
