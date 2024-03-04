<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tarif extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'quantite',
        'remise',
        'montant',
        'produit_id',
    ];

    protected static $logFillable = true;

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id');
    }
}
