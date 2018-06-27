<?php

namespace App\Http\Controllers;

use App\Pay;
use Illuminate\Http\Request;
include ('PayLib.php');

class PayController extends Controller
{
    //支付
    public function index()
    {
        //$names=DB::table('ezf_pay_type')->select('name')->get();
        return view('pay.index', compact('names'));
    }

    //下订单
    public function create(Request $request, Pay $pay)
    {
        //var_dump($_POST);die;
        $this->validate($request,
            [
                'name' => 'required',
                'money' => 'required|integer',
                'action' => 'required',
            ], [
                'name.required' => '账户名不能为空',
                'money.required' => '金额必填',
                'money.integer' => '必为数字',
                'action.required' => '必选支付方式',
            ]
        );
        $order_id = date('YmdHis', time());

        Pay::create([
            'name' => $request->name,
            'money' => $request->money,
            'action' => $request->action,
            'order_id' => $order_id,
        ]);
        session()->flash('success', '添加成功');
        return redirect()->route('home');
    }

    //定义支付宝
    public function enter(Request $request)
    {
        $address = $_SERVER['HTTP_HOST'];
        $this->validate($request,
            [
                'name' => 'required',
                'money' => 'required|integer',
                'action' => 'required',
            ], [
                'name.required' => '账户名不能为空',
                'money.required' => '金额必填',
                'money.integer' => '必为数字',
                'action.required' => '必选支付方式',
            ]
        );
        $order_id = date('YmdHis', time());
        $user_id=uniqid();
        $parameter = array(
            "oid_partner" => "201709141355751809",
            "time_order" => $order_id,
            "no_order"	=>"201610270213999",
            "notify_url"	=>"http://www.baidu.com/",
            "pay_type"	=> "48",
            "money_order"	=>100,
            "name_goods"	=> "sssss",
            "user_id"	=> $user_id,
            "sign_type" => "MD5",
//
//            'money_order' => "100",
//            'name_goods' => 'sssss',
//            'no_order' => "201610270213999", 'notify_url' => "http://www.baidu.com/",
//            'oid_partner' => "201709141355751809",
//            'pay_type' => '48',
//            'sign_type' => 'MD5',
//            'time_order' => $order_id,
//            'user_id' => $user_id,
        );

        $parameter = paraFilter($parameter);
        $parameter = argSort($parameter);
//        $signStr = "";
        $signStr = createLinkstring($parameter);
        $merchant_md5_key='hs12ll29g';
        var_dump($signStr);die;
        $code = md5Sign($signStr, $merchant_md5_key);

        $para = [
            'money_order' => 100,
            'name_goods' => 'sssss',
            'no_order' => "201610270213999",
            'notify_url' => "http://www.baidu.com/",
            'oid_partner' => "201709141355751809",
            'pay_type' => '48',
            'sign_type' => 'MD5',
            'time_order' => $order_id,
            'user_id' => $user_id,
            'sign' =>$code,
        ];
        $code1=http_build_query($para);
        return redirect("http://yiapi.lianlianspc.com/gateway/yigateway?{$code1}",302);
    }
}
