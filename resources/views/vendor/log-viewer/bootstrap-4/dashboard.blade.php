@extends('log-viewer::_template.master')
@section('title')
    {{ trans('message.logs_viewer') }}
@stop
@section('content-header')
    <div class="col-sm-6">
        <h1>{{ trans('message.logs_viewer') }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{url('settings')}}"><i class="fa fa-dashboard"></i> {{ trans('message.settings') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('message.error_logs') }}</li>
        </ol>
    </div><!-- /.col -->
@stop

@section('content')

  <div class="card card-secondary card-outline">
      <div class="card-header">
          <h3 class="card-title">{{ trans('message.Log_viewer') }}</h3>

          <div class="card-tools">
              <a href="{{url('log-viewer/logs')}}" class="btn btn-default btn-sm pull-right">&nbsp;{{ trans('message.logs') }}</a>


          </div>
      </div>
    <div class="card-body">
    <div class="row">

        <div class="col-md-12">
            <section class="card-body">
                <div class="row">
                    @foreach($percents as $level => $item)
                        <div class="col-md-4">
                            <div class="info-box level level-{{ $level }} {{ $item['count'] === 0 ? 'level-empty' : '' }}">
                                <span class="info-box-icon">
                                    {!! log_styler()->icon($level) !!}
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $item['name'] }}</span>
                                    <span class="info-box-number">
                                        {{ $item['count'] }} {{ trans('message.entries') }} - {!! $item['percent'] !!} %
                                    </span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ $item['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
    <script>
        $(function() {
            new Chart($('canvas#stats-doughnut-chart'), {
                type: 'doughnut',
                data: {!! $chartData !!},
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            });
        });
    </script>
@endsection
