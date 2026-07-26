<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
