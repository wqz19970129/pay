@extends('layout.default')
@section('title','支付页面')
@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">扫码支付</div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-6">
                        <img src="{{$pic}}"  class='img-responsive'>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop