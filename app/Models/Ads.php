<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ads extends Model
{
    protected $fillable = [
        'name',
        'price',
//        'brand',
//        'model',
        'year',
        'description',
        'images',
        'user_id',
        'status',
        'moderation_status',
        'address',
        'city',
        'phone',
        'type_call',
        'slug',
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($ad) {
            $ad->slug = Str::slug($ad->name.'-'.uniqid());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
