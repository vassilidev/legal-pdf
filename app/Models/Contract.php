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

/**
 * @property-read  mixed $final_schema
 */
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

    public function getFinalSchemaAttribute(): array
    {
        $schema = $this->form_schema;

        if ($this->signature_price) {
            $schema['components'][] = [
                "key"        => "signatureOption",
                "type"       => "panel",
                "input"      => false,
                "label"      => "",
                "title"      => "Options",
                "tableView"  => false,
                "components" => [
                    [
                        "key"             => "content",
                        "html"            => "<p><strong>Avez-vous besoin d'une signature d'un avocat sur le contrat ?</strong></p>",
                        "type"            => "content",
                        "input"           => false,
                        "label"           => "Content",
                        "tableView"       => false,
                        "refreshOnChange" => false
                    ],
                    [
                        "key"          => "signatureOption",
                        "type"         => "checkbox",
                        "input"        => true,
                        "label"        => "Option signature d'avocat",
                        "tableView"    => false,
                        "defaultValue" => false
                    ]
                ]
            ];
        }

        if (Auth::check()) {
            return $schema;
        }

        $schema['components'][] = $data = [
            "key"        => "finalPage",
            "type"       => "panel",
            "input"      => false,
            "label"      => "",
            "title"      => "",
            "tableView"  => false,
            "components" => [
                [
                    "key"         => "surveyUserEmail",
                    "type"        => "email",
                    "input"       => true,
                    "label"       => "Adresse Email",
                    "tableView"   => true,
                    "applyMaskOn" => "change",
                    "validate"    => [
                        'required' => true,
                    ],
                ]
            ]
        ];

        return $schema;
    }
}
