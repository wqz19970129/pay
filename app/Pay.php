<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    //
    protected $fillable = [
        'name', 'pay_type','money_order','no_order','name_goods','notify_url','oid_partner','sign_type','user_id','time_order'
    ];
}
