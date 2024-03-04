<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Paiement extends Model implements HasMedia
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
        'moyen_id',
        'commande_id',
    ];

    protected static $logFillable = true;

    public function moyen()
    {
        return $this->belongsTo(Moyen::class,'moyen_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class,'commande_id');
    }
}
