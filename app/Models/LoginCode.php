<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LoginCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'used',
        'expires_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Проверяет, истёк ли код
     */
    public function isExpired(): bool
    {
        return $this->expires_at->lt(Carbon::now());
    }

    /**
     * Отмечает код как использованный
     */
    public function markAsUsed(): void
    {
        $this->used = true;
        $this->save();
    }

    /**
     * Связь с пользователем
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
