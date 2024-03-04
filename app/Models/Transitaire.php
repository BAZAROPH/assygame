<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Transitaire extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory, SoftDeletes, LogsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'telephone',
        'email',
        'description',
        'user_id'
    ];

    protected static $logFillable = true;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class,'commande_id');
    }
}
