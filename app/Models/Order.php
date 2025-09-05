<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
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
        return $this->status == 'completed' && Carbon::parse($this->updated_at)->greaterThan(now()->subWeeks(2));
    }

    public static function getStatusOptions()
    {
        return [
            'pending',
            'paid', 
            'shipped',
            'completed',
            'cancelled'
        ];
    }
}
