<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Billing extends Model
{
    use HasFactory;

    protected $table = 'billings';
    
    protected $fillable = [
    		'Amount',
    		'DueDate',
    		'client_id',
    		'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
