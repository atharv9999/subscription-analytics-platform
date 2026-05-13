<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;

trait BelongsToTenant
{
    /**
     * The "booted" method is automatically called by Laravel 
     * when the model is initialized.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);

        // Auto-fill tenant_id when creating a new record
        static::creating(function ($model) {
            if (empty($model->tenant_id)) {
                $model->tenant_id = session('tenant_id') ?? auth()->user()?->tenant_id;
            }
        });
    }
}