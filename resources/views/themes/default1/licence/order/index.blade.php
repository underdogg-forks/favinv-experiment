@extends('themes.default1.layouts.master')
@section('content')
<div class="card border-top border-primary">

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
        <div id="response"></div>
        <h4>{{trans('message.orders')}}
            <!--<a href="{{url('licences/create')}}" class="btn btn-primary pull-right   ">{{trans('message.create')}}</a></h4>-->
    </div>



    <div class="card-body">
        <div class="row">

            <div class="col-md-12">
                {!! Datatable::table()
                ->addColumn('Organization','Name','Description','Number Of Slas','Price','Status','Action')
                ->setUrl('get-licence-orders') 
                ->render() !!}

            </div>
        </div>

    </div>

</div>



@stop

