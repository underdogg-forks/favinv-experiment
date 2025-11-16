@extends('visitstats::layout')

@section('visitortracker_content')
<div class="row">
	<div class="col-md-12">
		<h5>{{ trans('message.summary') }}</h5>

		<table class="visitortracker-table table table-sm table-striped fs-1">
			<thead>
				<th>{{ trans('message.period') }}</th>
				<th>{{ trans('message.unique_visitors') }}</th>
				<th>{{ trans('message.visits') }}</th>
			</thead>

			<tbody>
                <tr>
                    <td>24 {{ trans('message.hours') }}</td>

                    <td>{{ $unique24h }}</td>

                    <td>{{ $visits24h }}</td>
                </tr>

                <tr>
                    <td>1 {{ trans('message.week') }}</td>

                    <td>{{ $unique1w }}</td>

                    <td>{{ $visits1w }}</td>
                </tr>

                <tr>
                    <td>1 {{ trans('message.month') }}</td>

                    <td>{{ $unique1m }}</td>

                    <td>{{ $visits1m }}</td>
                </tr>

                <tr>
                    <td>1 {{ trans('message.year') }}</td>

                    <td>{{ $unique1y }}</td>

                    <td>{{ $visits1y }}</td>
                </tr>

                <tr>
                    <td>{{ trans('message.all_time') }}</td>

                    <td>{{ $uniqueTotal }}</td>

                    <td>{{ $visitsTotal }}</td>
                </tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<h5>{{ trans('message.last_10_requests') }}</h5>

		@include('visitstats::_table_requests', ['visits' => $lastVisits])
	</div>
</div>
@endsection