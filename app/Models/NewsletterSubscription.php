<?php

// app/Models/NewsletterSubscription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    protected $fillable = [
        'user_id', 'email', 'confirmed',
        'subscribed_at', 'unsubscribed_at',
        'confirm_token', 'unsubscribe_token',
    ];

    protected $casts = [
        'confirmed'       => 'boolean',
        'subscribed_at'   => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($q)
    {
        return $q->whereNull('unsubscribed_at');
    }
}
