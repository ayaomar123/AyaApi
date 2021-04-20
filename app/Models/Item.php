<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
       'description',
       'image',
       'price',
       'special_price',
       'offer',
       'special_price_start',
       'special_price_end',
       'price_offer',
       'category_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function getImageAttribute($image)
    {
        return Storage::url('public/images/' .$image);
    }
}
