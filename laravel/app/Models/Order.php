<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ['bus', 'driver'];

    public function getBusAttribute()
    {
        return Bus::find($this->bus_id)->plate_number;
    }
    
    public function getDriverAttribute()
    {
        return Driver::find($this->driver_id)->name;
    }
}
