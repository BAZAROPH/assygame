<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Produit_like extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'id',
        'produit_id',
        'user_id',
    ];

    protected static $logFillable = true;

    public function produit()
    {
        return $this->belongsTo(Produit::class,'produit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
