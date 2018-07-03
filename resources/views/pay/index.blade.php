@extends('layout.default')
@section('title','支付页面')
@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>支付选择</h5>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('inters') }}" enctype="multipart/form-data">
                    <div class="form-group" >
                        <label for="inputEmail3" class="col-sm-2 control-label">账户名：</label>
                        <div class="col-sm-4">
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group" >
                        <label for="inputPassword3" class="col-sm-2 control-label">金额：</label>
                        <div class="col-sm-4">
                            <input type="text" name="money_order" class="form-control" value="{{ old('money_order') }}">

                    </div>
                    </div>
                    <div style="margin:10px 30px">

                        <label class="radio-inline">
                            <input type="radio" name="pay_type" id="inlineRadio1" value="23">支付宝扫码
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay_type" id="inlineRadio1" value="11"> 网银支付
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay_type" id="inlineRadio1" value="20"> 代付
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="pay_type" id="inlineRadio1" value="21"> 快捷支付
                        </label>
                    </div>

                    {{csrf_field()}}
                    <div class="col-sm-offset-1 col-sm-6">
                        <button type="submit" class="btn btn-primary">充值</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @stop