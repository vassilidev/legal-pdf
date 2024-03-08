<?php

use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->index();
            /** @see \App\Enums\Currency */
            $table->string('currency');
            $table->json('answers')->nullable();
            $table->foreignIdFor(Contract::class);
            $table->string('payment_intent_id')->nullable();
            /** @see \App\Enums\Stripe\PaymentIntentStatus */
            $table->string('payment_status')->nullable();
            $table->string('invoicing_name')->nullable();
            $table->string('invoicing_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
