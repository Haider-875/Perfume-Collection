<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'is_active',
        'phone',
        'city',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'order_manager', 'catalog_manager']);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        $roleDefaults = [
            'admin' => [
                'manage_products',
                'manage_orders',
                'manage_categories',
                'manage_coupons',
                'manage_blogs',
                'manage_slides',
                'manage_settings',
                'manage_customers',
                'view_analytics',
            ],
            'order_manager' => [
                'manage_orders',
                'manage_customers',
                'view_analytics',
            ],
            'catalog_manager' => [
                'manage_products',
                'manage_categories',
                'manage_coupons',
                'manage_slides',
            ],
        ];

        $defaults = $roleDefaults[$this->role] ?? [];
        $custom = is_array($this->permissions) ? $this->permissions : (json_decode($this->permissions ?? '[]', true) ?: []);
        $allPerms = array_merge($defaults, $custom);

        if (in_array($permission, $allPerms)) {
            return true;
        }

        // Dotted and coarse mapping
        $coarseMapping = [
            'manage_orders' => ['orders.view', 'orders.status_update', 'orders.receipt_verify', 'orders.export'],
            'manage_products' => ['products.view', 'products.create', 'products.edit', 'products.delete', 'products.import', 'products.export'],
            'manage_categories' => ['categories.view', 'categories.create', 'categories.edit', 'categories.delete'],
            'manage_coupons' => ['coupons.view', 'coupons.create', 'coupons.edit', 'coupons.delete'],
            'manage_slides' => ['slides.view', 'slides.create', 'slides.edit', 'slides.delete'],
            'manage_blogs' => ['blogs.view', 'blogs.create', 'blogs.edit', 'blogs.delete'],
            'manage_settings' => ['settings.view', 'settings.manage'],
            'manage_customers' => ['customers.view', 'customers.edit'],
            'view_analytics' => ['analytics.view'],
            'manage_staff' => ['roles.manage', 'users.view', 'users.create', 'users.edit', 'users.delete'],
        ];

        foreach ($allPerms as $userPerm) {
            if (isset($coarseMapping[$userPerm]) && in_array($permission, $coarseMapping[$userPerm])) {
                return true;
            }
        }

        return false;
    }

    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'order_manager' => 'Order Specialist',
            'catalog_manager' => 'Catalog Manager',
            default => 'Patron Customer',
        };
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
