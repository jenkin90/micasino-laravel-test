<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay_method',
        'amount',
        'currency',
        'status',
    ];

    public function logs()
    {
        return $this->hasMany(TransactionsLogs::class);
    }

    public function changeStatus($status, $type, $payload)
    {
        $this->status = $status;
        $this->save();
        TransactionsLogs::createLog($this->id, $type, $payload);
    }



    
}
