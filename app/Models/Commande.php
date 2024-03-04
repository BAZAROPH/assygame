<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Commande extends Model implements HasMedia
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
        'description',
        'montant',
        'livraison',
        'total',
        'client_id',
        'statut',
        'created_ip',
    ];

    protected static $logFillable = true;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->code = IdGenerator::generate([
                'table' => 'commandes',
                'field' => 'code',
                'length' => 10,
                'prefix' => 'OR-',
                'reset_on_prefix_change' => false,
            ]);
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class,'commande_id');
    }


    public function commande_produits()
    {
        return $this->hasMany(Commande_produit::class,'commande_id');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produits')
        ->withPivot('montant', 'quantite', 'options')
        ->withTimestamps();;
    }

    public function versements()
    {
        return $this->belongsToMany(Produit::class, 'versements')
        ->withPivot('montant', 'transid', 'abonnement', 'methode', 'payid', 'buyername', 'transstatus', 'signature', 'phone', 'errormessage', 'statut', 'datepaiement')
        ->withTimestamps();;
    }
}
