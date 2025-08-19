<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = ['nome'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
