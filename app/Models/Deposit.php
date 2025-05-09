<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    // ✅ Tambahkan konstanta status di sini
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';

    protected $fillable = [
        'customer_id',
        'amount',
        'note',
        'status',
        'proof'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
