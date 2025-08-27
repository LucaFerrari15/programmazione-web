<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getStatusOptions()
    {
        $table = (new self)->getTable();
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = 'status'")[0]->Type;
        
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $options = explode(',', str_replace("'", '', $matches[1]));
        
        return $options;
    }
}
