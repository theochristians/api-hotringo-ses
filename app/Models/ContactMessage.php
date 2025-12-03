<?php

namespace App\Models;

class ContactMessage extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'source',
        'ip_address',
        'user_agent',
    ];
}
