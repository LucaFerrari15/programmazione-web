<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nome', 'prezzo', 'descrizione', 'image_path'];

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size')
            ->withPivot('quantita')
            ->withTimestamps();
    }

    public function soldOut()
    {
        foreach ($this->sizes as $size) {
            if ($size->pivot->quantita > 0) {
                return false;
            }
        }
        return true;
    }



    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


}


