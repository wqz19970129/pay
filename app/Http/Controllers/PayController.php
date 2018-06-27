<?php

namespace App\Http\Controllers;

use App\Pay;
use Illuminate\Http\Request;

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
        //var_dump($address);die;
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
        $param = [
            "oid_partner" =>'201709141355751809',
            'time_order' => $order_id,
            'no_order' =>'201610270213',
            'pay_type' => '32',
            'money_order' => $request->money,
            'name_goods' => '玩具娃娃',
            'info_order' => '不错的产品',
            "user_id"	=> $user_id,
            "sign_type" => 'MD5',
            ];
        //$arr=http_build_query($param);
        //var_dump($param);die;
//          var_dump(http_build_query($param));die;
        $code=http_build_query($param);
        $fix=$code.'hs12ll29g';
        //var_dump($fix);die;
        $code=md5($fix);
        //var_dump($code);die;
        $para = [
            'name' => $request->name,
            'oid_partner' => '201709141355751809',
            'notify_url' => 'http://$address/notify.php',
            'user_id' => $user_id,
            'sign_type' => 'MD5',
            'sign' =>$code,
            'no_order' => 201610270213,
            'time_order' => $order_id,
            'money_order' => $request->money,
            'info_order' => '不错的产品',
            'name_goods' => '玩具娃娃',
            'pay_type' => '32',
        ];
        //var_dump($para);die;
        $code1=http_build_query($para);

        return redirect("http://yiapi.lianlianspc.com/gateway/yigateway?{$code1}",302);
    }
}
