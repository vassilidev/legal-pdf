<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Contract
 *
 * @property-read mixed $final_schema
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property array|null $form_schema
 * @property int $is_published
 * @property int $price
 * @property int $signature_price
 * @property \App\Enums\Currency $currency
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $direction
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ContractFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract published()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract unpublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereFormSchema($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereSignaturePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract withoutTrashed()
 */
	class Contract extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\EditorUi
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi query()
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EditorUi withoutTrashed()
 */
	class EditorUi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Font
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Font newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Font newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Font query()
 * @method static \Illuminate\Database\Eloquent\Builder|Font whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Font whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Font whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Font whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Font whereUrl($value)
 */
	class Font extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property string $id
 * @property string $email
 * @property \App\Enums\Currency $currency
 * @property array|null $answers
 * @property int $contract_id
 * @property string|null $payment_intent_id
 * @property \App\Enums\Stripe\PaymentIntentStatus|null $payment_status
 * @property string|null $invoicing_name
 * @property string|null $invoicing_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property bool $signature_option
 * @property-read \App\Models\Contract|null $contract
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read mixed $stripe_payment_intent
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInvoicingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInvoicingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentIntentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSignatureOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $quantity
 * @property int $unit_price
 * @property string $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

