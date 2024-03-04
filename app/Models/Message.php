<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
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
        'emetteur_id',
        'recepteur_id',
        'statut',
    ];

    protected static $logFillable = true;

    public function emetteur()
    {
        return $this->belongsTo(User::class,'emetteur_id');
    }

    public function recepteur()
    {
        return $this->belongsTo(User::class,'recepteur_id');
    }
}
