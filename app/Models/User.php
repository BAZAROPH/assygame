<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements HasMedia
{
    use InteractsWithMedia, HasApiTokens, HasFactory, Notifiable, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'contact',
        'type',
        'email',
        'password',
        'pays_id',
        'ville',
        'adresse',
        'boutique',
        'biographie',
        'date_naissance',
        'sexe',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logFillable = true;

    public function commandes()
    {
        return $this->hasMany(Commande::class,'client_id')->whereIn('statut', ['attente', 'annule', 'effectue']);
    }

    public function panier()
    {
        return $this->hasMany(Commande::class,'client_id')
        ->where('statut', 'cours')
        ->orderBy('created_at', 'desc');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class,'fournisseur_id');
    }

    public function message_emis()
    {
        return $this->hasMany(Message::class,'emetteur_id');
    }

    public function message_recus()
    {
        return $this->hasMany(Message::class,'recepteur_id');
    }

    public function produit_likes()
    {
        return $this->hasMany(Produit_like::class,'user_id');
    }

    public function transitaire()
    {
        return $this->belongsTo(Transitaire::class,'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('my-collection')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(400)
                    ->height(200);
            });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(300)
        ->height(300)
        ->nonOptimized();

        $this->addMediaConversion('my-conversion')
            ->withResponsiveImages();
    }
}
