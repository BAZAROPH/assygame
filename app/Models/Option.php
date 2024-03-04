<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Option extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'description',
        'option_id',
        'produit_id',
    ];

    protected static $logFillable = true;

    public function option()
    {
        return $this->belongsTo(Option::class,'option_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class,'option_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id');
    }

    public function commande_produits()
    {
        return $this->hasMany(Commande_produit::class,'option_id');
    }
}