@extends('layout.default')
@section('title','支付页面')
@section('content')
    <div class="panel-body">
        <form method="POST" action="{{ $pay_gateway_new }}" enctype="multipart/form-data">
            <input type="text" name="money_order" class="form-control" value="{{$parameter['money_order']}}">
            <input type="text" name="name_goods" class="form-control" value="{{$parameter['name_goods']}}">
            <input type="text" name="no_order" class="form-control" value="{{$parameter['no_order']}}">
            <input type="text" name="notify_url" class="form-control" value="{{$parameter['notify_url']}}">
            <input type="text" name="oid_partner" class="form-control" value="{{$parameter['oid_partner']}}">
            <input type="text" name="pay_type" class="form-control" value="{{$parameter['pay_type']}}">
            <input type="text" name="return_url" class="form-control" value="{{$parameter['return_url']}}">


            <input type="text" name="sign_type" class="form-control" value="{{$parameter['sign_type']}}">
            <input type="text" name="time_order" class="form-control" value="{{$parameter['time_order']}}">
            <input type="text" name="user_id" class="form-control" value="{{$parameter['user_id']}}">
            <input type="text" name="sign" class="form-control" value="{{$parameter['sign']}}">

            <div class="col-sm-offset-1 col-sm-6">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>

        </form>
    </div>

@stop