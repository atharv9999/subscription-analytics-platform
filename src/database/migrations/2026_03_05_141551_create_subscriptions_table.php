<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');

            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->uuid('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans');

            $table->string('status');

            $table->timestamp('current_period_start');
            $table->timestamp('current_period_end');
            $table->timestamp('canceled_at')->nullable();

            $table->jsonb('metadata')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
