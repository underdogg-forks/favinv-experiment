@extends('themes.default1.layouts.master')
@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
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

            </div>

            <div class="card-body">
                {!! html()->modelForm($set, 'PATCH', url('settings/error'))->acceptsFiles()->open() !!}

                <table class="table table-condensed">
                    <tr>
                        <td><h3 class="card-title">{{ trans('message.error-log') }}</h3></td>
                        <td>{!! html()->submit(trans('message.update'))->class('btn btn-primary pull-right') !!}</td>
                    </tr>

                    <tr>
                        <td><b>{!! html()->label(trans('message.error-log'))->for('error_log') !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('error_log') ? 'has-error' : '' }}">
                                {!! html()->radio('error_log', true, '1') !!} <span> {{ trans('message.yes') }}</span>
                                {!! html()->radio('error_log', false, '0') !!} <span> {{ trans('message.no') }}</span>
                                <p><i> {{ trans('message.enable-error-logging') }}</i></p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><b>{!! html()->label(trans('message.error-email'))->for('error_email') !!}</b></td>
                        <td>
                            <div class="form-group {{ $errors->has('error_email') ? 'has-error' : '' }}">
                                {!! html()->text('error_email')->class('form-control') !!}
                                <p><i> {{ trans('message.provide-error-reporting-email') }}</i></p>
                            </div>
                        </td>
                    </tr>
                </table>

                {!! html()->closeModelForm() !!}
            </div>
        </div>
    </div>
</div>
@stop