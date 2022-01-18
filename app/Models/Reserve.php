<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $with = ['ride'];

    protected $fillable = ['num_of_seats_reserved'];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
