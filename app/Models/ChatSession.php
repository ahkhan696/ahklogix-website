<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'driver',
        'turns',
        'messages',
        'intent_detected',
        'handoff_triggered',
    ];

    protected $casts = [
        'messages'          => 'array',
        'handoff_triggered' => 'boolean',
        'turns'             => 'integer',
    ];
}
