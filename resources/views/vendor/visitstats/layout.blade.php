@extends($visitortrackerLayout)

@section($visitortrackerSectionContent)
    <link rel="stylesheet"
        property="stylesheet"
        href="/vendor/visitortracker/css/visitortracker.css">

    <h1>{{ trans('message.statistics') }}</h1>

    @yield('visitortracker_content')
@endsection