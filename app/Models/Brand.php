<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // App\Models\Brand.php
    protected $fillable = ['nome'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
