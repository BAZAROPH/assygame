<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Produit extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'titre',
        'sous_titre',
        'description',
        'promo',
        'categorie_id',
        'mesure_id',
        'fournisseur_id',
        'like',
        'accueil',
        'status',
        'stock',
        'option',
        'hebdo',
    ];

    protected static $logFillable = true;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'produits',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'PR-',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function mesure()
    {
        return $this->belongsTo(Mesure::class,'mesure_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo(User::class,'fournisseur_id');
    }

    public function tarifs()
    {
        return $this->hasMany(Tarif::class,'produit_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class,'produit_id');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produits');
    }

    public function tailles()
    {
        return $this->belongsToMany(Option::class, 'option_produit')
        ->where('type', 'taille')
        ->withTimestamps();
    }

    public function couleurs()
    {
        return $this->belongsToMany(Option::class, 'option_produit')
        ->where('type', 'couleur')
        ->withTimestamps();
    }

    public function produit_likes()
    {
        return $this->hasMany(Produit_like::class,'produit_id');
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
