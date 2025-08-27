<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nome',
        'descrizione',
        'prezzo',
        'brand_id',
        'team_id',
        'image_path',
    ];


    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')
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

    public function getAmoutGivenSize($id_sizeGiven) {
        foreach ($this->sizes as $size) {
            if ($size->pivot->id == $id_sizeGiven) {
                return $size->pivot->quantita;
            }
        }
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


