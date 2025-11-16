@extends('themes.default1.layouts.front.master')
@section('title')
{{ trans('message.cart') }}
@stop
@section('page-heading')
Faveo {{ trans('message.download') }}
@stop
@section('breadcrumb')
<li><a href="{{url('home')}}">{{ trans('message.home')}}</a></li>
<li class="active">{{ trans('message.download')}}</li>
@stop
@section('main-class') "main shop" @stop
@section('content')

<section class="page-not-found">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="page-Download-main">
                
                <h2><span >{{ trans('message.download')}}</span>&nbsp;<i class="fa fa fa-download "></i></h2>
                <p>&nbsp;&nbsp;&nbsp;{{ trans('message.download_begin')}} <a href="{{$release}}">{{ trans('message.here')}}</a> {{ trans('message.to_download')}}</p>
            </div>
        </div>

    </div>
</section>
@stop
@section('end')
<?php 
header("Location: $release"); 
exit;
?>
@stop