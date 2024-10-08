<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_type', 'description', 'value','transaction_date', 'user_id'];

    protected $hidden = ['created_at','updated_at'];
}
