<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companyinfo extends Model
{
    protected $fillable = [
        'name',
        'address_line1',
        'address_line2',
        'phone',
        'email',
        'location_map',
        'message',
        'copyright',
        'version',
        'status',
    ];
}
