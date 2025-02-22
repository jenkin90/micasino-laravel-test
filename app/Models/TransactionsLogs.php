<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'payload',
        'transactions_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }

    public static function createLog($transationId,$type, $payload)
    {
        return self::create([
            'type' => $type,
            'transactions_id' => $transationId,
            'payload' => $payload,
        ]);
    }
    
}
