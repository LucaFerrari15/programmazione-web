<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'nome_spedizione',
        'cognome_spedizione',
        'via',
        'civico',
        'cap',
        'comune',
        'provincia',
        'paese',
        'total'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function dataDiCreazioneOrdineFormattata()
    {
        return $this->created_at->format('d-m-Y');
    }

    public function quantitaTotale()
    {
        $quantitaTotale = 0;

        foreach ($this->items as $orderItem) {
            $quantitaTotale += $orderItem->quantity;
        }

        return $quantitaTotale;
    }

    public function canReturn()
    {
        return $this->status == 'completed' && $this->updated_at->gt(now()->subWeeks(2));
    }

}
