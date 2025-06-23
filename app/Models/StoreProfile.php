<?php

// app/Models/StoreProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProfile extends Model
{
    protected $fillable = [
        'store_name', 'owner_name', 'phone_number', 'address', 'logo_url'
    ];
}

