<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscriber_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }
}
