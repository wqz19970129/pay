<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Sodium\compare;

class PaymentController extends Controller
{
    //定义支付宝
    public function index(){
        $param=[
            'oid_partner'=>'201709141355751809',
            'notify_url'=>'',
            'user_id'=>'10000ml',
            'sign_type'=>'hs12ll29g',
            'sign'=>'hLUKaLFVkGVqAHeY3bB53bjYB7xQs32N4AbH9SQmUDqKMwqeVS+mFza3xsOY3q2Lv/IjCVrk9P7CNlSQ76c9aOLMIgByGMH9o8DJs7CVf5/5Me71Ytbwxr8UqRW4L19qSHv4nUei1egCP4mchbO66Rz+3lHlBVSw5zTwK6XX36Y',
            'no_order'=>201610270213,
            'time_order'=>20171227150634,
            'money_order'=>100,
            'info_order'=>'不错的产品',
            'name_goods'=>'玩具娃娃',
            'pay_type'=>32,
            ]
        ;
        //var_dump($data);die;
        return redirect('http://yiapi.lianlianspc.com/gateway/yigateway',302);
    }
}
