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
        Schema::create('users', function (Blueprint $table) {
<<<<<<<< HEAD:src/database/migrations/2026_03_02_194600_create_users_table.php
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
========
            $table->uuid("id")->primary();
            $table->uuid("tenant_id");
>>>>>>>> feat/tenant_schema:src/database/migrations/2026_03_04_192000_create_users_table.php
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('viewer');
<<<<<<<< HEAD:src/database/migrations/2026_03_02_194600_create_users_table.php
            $table->jsonb('metadata')->nullable(); // JSONB for Tenant-Specific User Preferences (Theme, Notifications, etc.)
            $table->rememberToken();
            $table->timestamps();
========
            $table->jsonb('metadata')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
            
>>>>>>>> feat/tenant_schema:src/database/migrations/2026_03_04_192000_create_users_table.php
            $table->index('tenant_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
