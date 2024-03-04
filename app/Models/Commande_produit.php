<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Commande_produit extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantite',
        'montant',
        'produit_id',
        'commande_id',
        'option_id',
    ];

    protected static $logFillable = true;

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class,'commande_id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class,'option_id');
    }
}
