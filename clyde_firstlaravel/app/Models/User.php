<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

protected $fillable = [
            'name', 'email', 'email_verified_at', 'password', 'role', 'status', 'user_id_number'
        ];
        protected $appends = ['user_id_number_display'];
        protected $hidden = ['password', 'remember_token'];

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isPharmacist(): bool { return $this->role === 'pharmacist'; }
    public function isSalesClerk(): bool { return $this->role === 'sales_clerk'; }
    public function isActive(): bool { return $this->status === 'active'; }

    public function getUserIdNumberDisplayAttribute() {
        return $this->user_id_number ?: 'USR' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function sales() { return $this->hasMany(Sale::class); }
}