<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = [
        'name', 'price', 'quota', 'remaining_stock',
        'event_name', 'event_date', 'event_location',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
