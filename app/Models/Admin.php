<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

     public static function make(
        string $name,
        string $email,
        string $hashedPassword,
        ?string $phone,
        ?string $avatar,
        bool $isActive
    ): static {
        return new static([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'avatar' => $avatar,
            'is_active' => $isActive,
        ]);
    }

    /**
     * Mối quan hệ với Permission
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'admin_permission');
    }

    /**
     * Kiểm tra admin có quyền hay không
     */
    public function hasPermission(string $code): bool
    {
        return $this->permissions()->where('code', $code)->exists();
    }

    /**
     * Kiểm tra admin có tất cả quyền hay không
     */
    public function hasAllPermissions(array $codes): bool
    {
        return $this->permissions()
            ->whereIn('code', $codes)
            ->count() === count($codes);
    }

    /**
     * Kiểm tra admin có bất kỳ quyền nào hay không
     */
    public function hasAnyPermission(array $codes): bool
    {
        return $this->permissions()
            ->whereIn('code', $codes)
            ->exists();
    }
}
