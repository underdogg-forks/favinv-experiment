{{ trans('message.email_username') }}{{$email}}
<br>
{{ trans('message.email_password') }}{{$pass}}
<br>
<br>
{{ trans('message.activate_account') }}  <a href='{{ url('activate/'.$token) }}'>{{ trans('message.email_click_here') }}</a>