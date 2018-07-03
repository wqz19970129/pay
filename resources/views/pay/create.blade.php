@extends('layout.default')
@section('title','支付页面')
@section('content')
    <style>
        .main {
            border: 1px solid #ccc;
            width: 800px;
            margin: auto;
            padding-bottom: 10px
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        a {
            text-decoration:none;
        }

        .title {
            padding: 8px 18px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            margin-bottom: 8px;;
        }

        .group {
            padding: 0 10px;
        }

        .group .item {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            margin: 6px 0
        }

        .group .item .text {
            line-height: 24px;
            font-size: 14px;
            padding-right: 10px;
            text-align: right;
            flex: 0 0 90px;

        }

        .group .item .money {
            line-height: 24px;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .group .buttons button {
            margin-top: 10px;
            margin-left: 100px;
            width: 120px;
            height: 30px;
            background-color: #F77A06;
            cursor: pointer;
            border-radius: 2px;
            color: #fff;
            border: none;
        }
        .group .cards li {
            font-size: 14px;
            width: 298px;
            height: 38px;
            border: 1px solid #C0C0C0;
            background-color: #F8F8F8;
            margin-bottom: 3px;
            line-height: 38px;
            position: relative;
            color: #2E2E2E;
            padding: 0 30px;
            cursor: pointer;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
        }
        .group .cards li:hover,
        .group .cards li.selected {
            border: 1px solid #FF8F00;
            background-color: #F5F5F5;
        }
        .group .cards li .name{
            margin-right: 20px
        }
        .group .cards li#addCard{
            font-size: 14px;
            justify-content: center;
            background-color: #F8F8F8;
            color: #8A8A8A;
        }
        .group .cards li#addCard:hover {
            color: #FF8F00;
        }
        .group .buttons button:hover {
            background-color: #eca461;
        }
    </style>
    <div class="main">
        <div class="title">确认订单</div>
        <form action="https://120.78.196.14/testPay" method="post">
            <input type="hidden" name="outTradeNo" class="form-control" value="{{$parameter['outTradeNo']}}">
            <input type="hidden" name="totalAmount" class="form-control" value="{{$parameter['totalAmount']}}">
            <input type="hidden" name="orgId" class="form-control" value="{{$parameter['orgId']}}">
            <input type="hidden" name="txnType" class="form-control" value="{{$parameter['txnType']}}">
            <input type="hidden" name="nodeId" class="form-control" value="10000012">
            <input type="hidden" name="orderTime" class="form-control" value="{{$parameter['orderTime']}}">

            <div class="group">
                <div class="item">
                    <span class="text">订单金额：</span>
                    <span class="money">{{$parameter['totalAmount']}}</span>
                </div>
            </div>


            付款方账号:<input type="text" name="payerAcc" class="form-control" value="">
            收款方账号:<input type="text" name="payeeAcc" class="form-control" value="">
            收款方姓名:<input type="text" name="payeeName" class="form-control" value="">
            <input type="hidden" name="privateFlag" class="form-control" value="G">
            <input type="hidden" name="currency" class="form-control" value="">
            <input type="hidden" name="notifyUrl" class="form-control" value="">
            <div class="item buttons">
                <button id="confirm">提交</button>
            </div>
        </form>
    </div>
@stop