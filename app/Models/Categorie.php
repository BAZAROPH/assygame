<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Categorie extends Model implements HasMedia
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
        'categorie_id',
    ];

    protected static $logFillable = true;

    public function categorie()
    {
        return $this->belongsTo(Categorie::class,'categorie_id');
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class,'categorie_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class,'categorie_id');
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
