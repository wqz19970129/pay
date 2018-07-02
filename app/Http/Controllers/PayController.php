<?php
namespace App\Http\Controllers;

use App\Pay;
use Illuminate\Http\Request;
//use App\PayLib;
include ('PayLib.php');
include ('phpqrcode.php');

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
        $order_id = date('YmdHis', time());
        $user_id = uniqid();
        $no_order = date('YmdHis', time());
        $address = $_SERVER['HTTP_HOST'];
        if($request->pay_type == 23){
            $this->validate($request,
                [
                    'name' => 'required',
                    'money_order' => 'required|integer',
                    'pay_type' => 'required',
                ], [
                    'name.required' => '账户名不能为空',
                    'money_order.required' => '金额必填',
                    'money_order.integer' => '必为数字',
                    'pay_type.required' => '必选支付方式',
                ]
            );
            $parameter = array(
                'money_order' => "100",
                'name_goods' => 'sssss',
                'no_order' => $no_order,
                'notify_url' => "http://www.jhwl668.com/api/notify/zfwypay.php",
                'oid_partner' => "201709141355751809",
                'pay_type' => '48',
                'sign_type' => 'MD5',
                'time_order' => $order_id,
                'user_id' => $user_id,
            );
            $parameter = paraFilter($parameter);
            $parameter = argSort($parameter);
            $signStr = createLinkstring($parameter);
            $signStr = addslashes($signStr);
            //var_dump($signStr);die;
            $merchant_md5_key = 'hs12ll29g';
            $code = md5Sign($signStr, $merchant_md5_key);
            $parameter['sign'] = $code;
            //var_dump($parameter);die;
            $ch = curl_init();
            $pay_gateway_new = 'http://yiapi.lianlianspc.com/gateway/yigateway';
            curl_setopt($ch,CURLOPT_URL,$pay_gateway_new);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            curl_close($ch);
            $res = json_decode($response, true);
            //$this->notify($res);
            $ret_code = $res['ret_code'];

            if ($ret_code == "0000") {

                $qrcode = $res['dimension_url'];

                if (file_exists('qrcode.png')) {
                    unlink('qrcode.png');
                }
                $pic = "qrcode.png";
                $errorCorrectionLevel = 'L';
                $matrixPointSize = 10;
                \QRcode::png($qrcode, $pic, $errorCorrectionLevel, $matrixPointSize, 2);

                //$img = "<img src={{$pic}} class='img-responsive'>";

                return view('pay.test',compact('pic'));
            }
        }else if($request->pay_type == 11){
            $parameter = array(
                'money_order' => "100",
                'name_goods' => 'sssss',
                'no_order' => $no_order,
                'notify_url' => "http://www.jhwl668.com/api/notify/zfwypay.php",
                'return_url' => "http://www.jhwl668.com/api/notify/zfwypay.php",
                'oid_partner' => "201709141355751809",
                'pay_type' => '11',
                'sign_type' => 'MD5',
                'time_order' => $order_id,
                'user_id' => $user_id,
            );
            $parameter = paraFilter($parameter);
            $parameter = argSort($parameter);
            $signStr = createLinkstring($parameter);
            $signStr = addslashes($signStr);
            //var_dump($signStr);die;
            $merchant_md5_key = 'hs12ll29g';
            $signStr.=$merchant_md5_key;
            var_dump($signStr);die;
            $code = md5Sign($signStr, $merchant_md5_key);
               //var_dump($code);die;
            $parameter['sign'] = $code;

            $ch = curl_init();
            $pay_gateway_new = 'http://yiapi.lianlianspc.com/gateway/yigateway';
            curl_setopt($ch,CURLOPT_URL,$pay_gateway_new);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameter));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            var_dump($response);die;
            curl_close($ch);
            //var_dump($parameter);die;
          //return view('pay.add',compact('parameter','pay_gateway_new'));

    }else{

        }

    }
    //异步通知
    public function notify(){
        $str = file_get_contents("php://input");
        //var_dump($str);die;
        if($str != ''){
            $arr_res = json_decode($str, true);
            $oid_partner = $arr_res['oid_partner'];
            $no_order = $arr_res['no_order'];
            $oid_paybill = $arr_res['oid_paybill'];
            $result_pay = $arr_res['result_pay'];
            $info_order = $arr_res['info_order'];
            $pay_type = $arr_res['pay_type'];
            $money_order = $arr_res['money_order'];
            $sign = $arr_res['sign'];

            $parameter = paraFilter($arr_res);
            $parameter = argSort($parameter);
            $signStr = "";
            $signStr = createLinkstring($parameter);
            $merchant_md5_key = 'hs12ll29g';
            $sign_base = md5Sign($signStr, $merchant_md5_key);

            if($sign_base == $sign){

                die('{"ret_code":"0000","ret_msg":"交易成功"}'); //请不要修改或删除

            }else{
                die('{"ret_code":"9999","ret_msg":"验签失败"}');
            }
        }
        die('{"ret_code":"9999","ret_msg":"验签失败"}');
    }
}
