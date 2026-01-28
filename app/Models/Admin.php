<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'media_id',
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
        ?string $media_id,
        bool $isActive
    ): static {
        return new static([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'media_id' => $media_id,
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
     * Kiểm tra admin có phải là superadmin không
     */
    public function isSuperAdmin(): bool
    {
        return $this->permissions->contains('code', 'super-admin');
    }

    /**
     * Kiểm tra admin có quyền hay không
     */
    public function hasPermission(string $code): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->permissions->contains('code', $code);
    }

    /**
     * Kiểm tra admin có tất cả quyền hay không
     */
    public function hasAllPermissions(array $codes): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->permissions
            ->whereIn('code', $codes)
            ->count() === count($codes);
    }

    /**
     * Kiểm tra admin có bất kỳ quyền nào hay không
     */
    public function hasAnyPermission(array $codes): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return $this->permissions
            ->whereIn('code', $codes)
            ->isNotEmpty();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
