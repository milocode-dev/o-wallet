<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'wallet_id', 'category_id', 'name', 'type', 'nominal', 'transaction_date', 'description', 'transfer_pair_id'];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transferPair()
    {
        return $this->belongsTo(Transaction::class, 'transfer_pair_id');
    }
}
