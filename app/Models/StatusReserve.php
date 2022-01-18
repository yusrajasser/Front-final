<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReserve extends Model
{
    use HasFactory;

    protected $fillable = ['total_amount'];

    protected $with = ['ride', 'passenger', 'reserve'];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
}
