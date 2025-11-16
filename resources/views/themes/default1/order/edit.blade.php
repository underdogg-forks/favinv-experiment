@extends('themes.default1.layouts.master')
@section('title')
    {{ trans('message.edit_order') }}
@stop
@section('content')
<div class="card border-top border-primary">

    <div class="content-header">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('message.whoops') }}</strong> {{ trans('message.input_problem') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{session('success')}}
        </div>
        @endif
        <!-- fail message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{{trans('message.alert')}}!</b> {{trans('message.failed')}}.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{session('fails')}}
        </div>
        @endif

            {!! html()->modelForm($order,'PATCH',url('orders/'.$order->id))->open() !!}
            <h4>{{trans('message.orders')}}	{!! html()->submit(trans('message.save'))->class('form-group btn btn-primary pull-right') !!}</h4>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12">


                <div class="row">

                    <div class="col-md-3 form-group {!! $errors->has('client') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.client'))->class('required')->for('client') !!}
                        {!! html()->select('client', ['' => 'Select', 'Clients' => $clients])
                            ->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {!! $errors->has('payment_method') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.payment-method'))->for('payment_method') !!}
                        {!! html()->select('payment_method', ['paypal' => 'payapal'])
                            ->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {!! $errors->has('promotion_code') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.promotion-code'))->for('promotion_code') !!}
                        {!! html()->select('promotion_code', ['' => 'Select', 'Promotions' => $promotion])
                            ->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {!! $errors->has('order_status') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.order-status'))->for('order_status') !!}
                        {!! html()->select('order_status', ['Pending' => 'pending', 'Active' => 'active'])
                            ->class('form-control') !!}
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-4 form-group">
                        <p>
                            {!! html()->checkbox('confirmation', null,1) !!}
                            {{ trans('message.order-confirmation') }}
                        </p>
                    </div>

                    <div class="col-md-4 form-group {!! $errors->has('invoice') ? 'has-error' : '' !!}">
                        <p>
                            {!! html()->checkbox('invoice', null,1) !!}
                            {{ trans('message.generate-invoice') }}
                        </p>
                    </div>

                    <div class="col-md-4 form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                        <p>
                            {!! html()->checkbox('email', null,1) !!}
                            {{ trans('message.send-email') }}
                        </p>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 form-group {!! $errors->has('product') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.product'), 'product')->class('required') !!}
                        {!! html()->select('product', ['' => 'Select', 'Product' => $product])->class('form-control') !!}
                    </div>

                    <div class="col-md-6 form-group {!! $errors->has('domain') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.domain'), 'domain') !!}
                        {!! html()->text('domain')->class('form-control') !!}
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 form-group {!! $errors->has('subscription') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.subscription'), 'subscription') !!}
                        {!! html()->select('subscription', ['' => 'Select', 'Subscription' => $subscription])->class('form-control') !!}
                    </div>

                    <div class="col-md-4 form-group {!! $errors->has('price_override') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.price-override'), 'price_override') !!}
                        {!! html()->text('price_override')->class('form-control') !!}
                    </div>

                    <div class="col-md-4 form-group {!! $errors->has('qty') ? 'has-error' : '' !!}">
                        {!! html()->label(trans('message.quantity'), 'qty') !!}
                        {!! html()->text('qty')->class('form-control') !!}
                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


{!! html()->form()->close() !!}
@stop