<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    //
    protected $fillable = [
        'name', 'action','money','order_id',
    ];
}
