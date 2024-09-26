<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = ['retailer_id', 'reciever_id', 'date', 'value'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id', 'retailer_id');
    }
    public function sellers()
    {
        return $this->belongsTo(User::class, 'id', 'reciever_id');
    }
}