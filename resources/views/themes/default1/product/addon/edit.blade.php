@extends('themes.default1.layouts.master')
@section('content')
<div class="card border-top border-primary">

    <div class="content-header">
        {!! html()->modelForm($addon,'PATCH',url('addons/'.$addon->id))->open() !!}
        <h4>{{ trans('message.addon') }} {!! html()->submit(trans('message.save'))->class('form-group btn btn-primary pull-right') !!}</h4>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12">

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>{{ __('message.whoops') }}</strong> {{ __('message.input_problem') }}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <b>{{trans('message.alert')}}!</b> {{trans('message.success')}}.
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

                <div class="row">

                    <div class="col-md-3 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.name'), 'name')->class('required') !!}
                        {!! html()->text('name')->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('subscription') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.subscription'), 'subscription')->class('required') !!}
                        {!! html()->select('subscription', ['' => __('message.select'), 'Subscription' => $subscription])->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('regular_price') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.regular-price'), 'regular_price')->class('required') !!}
                        {!! html()->text('regular_price')->class('form-control') !!}
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('selling_price') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.selling-price'), 'selling_price')->class('required') !!}
                        {!! html()->text('selling_price')->class('form-control') !!}
                    </div>


                </div>

                <div class="row">



                    <div class="col-md-3 form-group {{ $errors->has('tax_addon') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.tax-addon'), 'tax_addon') !!}
                        <p>{!! html()->checkbox('tax_addon', null,1) !!} {{ trans('message.charge-tax-on-this-addon') }}</p>
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('show_on_order') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.show-on-order'), 'show_on_order') !!}
                        <p>{!! html()->checkbox('show_on_order', null,1) !!} {{ trans('message.show-addon-during-initial-product-order-process') }}</p>
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('auto_active_payment') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.auto-active-payment'), 'auto_active_payment') !!}
                        <p>{!! html()->checkbox('auto_active_payment', null,1) !!} {{ trans('message.auto-activate-on-payment') }}</p>
                    </div>

                    <div class="col-md-3 form-group {{ $errors->has('suspend_parent') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.suspend-parent-product'), 'suspend_parent') !!}
                        <p>{!! html()->checkbox('suspend_parent', null,1) !!} {{ trans('message.tick-to-suspend-the-parent-product-as-well-when-instances-of-this-addon-are-overdue') }}</p>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6 form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.description'), 'description') !!}
                        {!! html()->textarea('description')->class('form-control') !!}
                    </div>

                    <div class="col-md-6 form-group {{ $errors->has('products') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.applicable-products'), 'products') !!}
                        {!! html()->select('products[]', ['' => __('message.select'), 'Products' => $product], $relation)
                            ->class('form-control')
                            ->multiple() !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{!! html()->form()->close() !!}
@stop