@extends('themes.default1.layouts.master')
@section('content')
<div class="card border-top border-primary">

    <div class="content-header">
        {!! html()->modelForm($bundle, 'PATCH', url('bundles/' . $bundle->id)) !!}
        <h4>{{ trans('message.bundles') }}
            {!! html()->submit(trans('message.save'))->class('form-group btn btn-primary pull-right') !!}
        </h4>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-12">

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

                    <div class="col-md-4 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.name'), 'name')->class('required') !!}
                        {!! html()->text('name')->class('form-control') !!}
                    </div>

                    <div class="col-md-4 form-group {{ $errors->has('valid_from') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.valid-from'), 'valid_from') !!}
                        {!! html()->date('valid_from', $from)->class('form-control') !!}
                    </div>

                    <div class="col-md-4 form-group {{ $errors->has('valid_till') ? 'has-error' : '' }}">
                        {!! html()->label(trans('message.valid-till'), 'valid_till') !!}
                        {!! html()->date('valid_till', $till)->class('form-control') !!}
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-6 form-group {{ $errors->has('items.0') ? 'has-error' : '' }}">

                        {!! html()->label(trans('message.bundle-items'), 'items')->class('required') !!}
                        {!! html()->select('items[]', ['' => trans('message.select'), 'Products' => $products], $relation)
                            ->class('form-control')
                            ->multiple() !!}

                    </div>

                    <div class="col-md-6">

                        <ul class="list-unstyled">

                            <li>
                                <div class="form-group {{ $errors->has('allow_promotion') ? 'has-error' : '' }}">
                                    {!! html()->label(trans('message.allow-promotion'), 'allow_promotion') !!}
                                    <p>
                                        {!! html()->checkbox('allow_promotion', null,1) !!}
                                        {{ trans('message.tick-to-allow-promotion-codes-to-be-used-in-conjunction-with-this-bundle') }}
                                    </p>
                                </div>
                            </li>

                            <li>
                                <div class="row">
                                    <div class="col-md-6 form-group {{ $errors->has('uses') ? 'has-error' : '' }}">
                                        {!! html()->label(trans('message.uses'), 'uses') !!}
                                        {!! html()->text('uses')->class('form-control') !!}
                                    </div>
                                    <div class="col-md-6 form-group {{ $errors->has('maximum_use') ? 'has-error' : '' }}">
                                        {!! html()->label(trans('message.maximum-use'), 'maximum_uses') !!}
                                        {!! html()->text('maximum_uses')->class('form-control') !!}
                                    </div>
                                </div>
                            </li>

                        </ul>

                    </div>



                </div>

            </div>

        </div>

    </div>

</div>


{!! html()->form()->close() !!}
@stop