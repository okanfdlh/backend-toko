<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'email',
        'saldo'
    ];

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
    public function deposits()
{
    return $this->hasMany(Deposit::class);
}

}
