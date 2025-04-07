<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'is_menu',
        'menu_icon',
        'menu_route',
        'menu_order',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_menu' => 'boolean',
        'menu_order' => 'integer',
    ];

    /**
     * Get the parent permission.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    /**
     * Get the child permissions.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
}
