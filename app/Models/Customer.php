<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory,HasApiTokens;
    protected $table = 'cutomers';
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image'
    ];
}
