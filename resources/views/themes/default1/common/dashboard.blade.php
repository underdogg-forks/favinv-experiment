@extends('themes.default1.layouts.master')
@section('title')
    {{ trans('message.dashboard') }}
@endsection
@section('content')
@section('content-header')
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{ trans('message.dashboard') }}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}">{{ trans('message.home') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('message.dashboard') }}</li>
        </ol>
    </div><!-- /.col -->
@stop
<style>
.scrollit {
    overflow:scroll;
    height:300px;
}
</style>
{!! html()->form('GET', url("my-profile?status=$status"))->open() !!}
<div class="row">
        <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-info">
            <div class="card-body pb-0">
              <h4>{{ trans('message.total_sales') }}</h4>
              @if(($allowedCurrencies2) != null)
              <span>{{$allowedCurrencies2}}: &nbsp;  {{currencyFormat($totalSalesCurrency2,$code=$allowedCurrencies2)}}</span><br/>
              @endif
               <span>{{$allowedCurrencies1}}: &nbsp;  {{currencyFormat($totalSalesCurrency1,$code=$allowedCurrencies1)}} </span>
            </div>

              <a href="{{url('invoices?status=success')}}" class="card-footer text-center py-2">{{ trans('message.more_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-success">
            <div class="card-body pb-0">
              <h4>{{ trans('message.yearly_sales') }}</h4>
                <?php
              $startingDateOfYear = (date('Y-01-01'));
              
              ?>
              @if(($allowedCurrencies2) != null)
              <span>{{$allowedCurrencies2}}:&nbsp;  {{currencyFormat($yearlySalesCurrency2,$code=$allowedCurrencies2)}}   </span><br/>
              @endif
               <span>{{$allowedCurrencies1}}:&nbsp; {{currencyFormat($yearlySalesCurrency1,$code=$allowedCurrencies1)}} </span>
            </div>
             <a href="{{url('invoices?status=success&from='.$startingDateOfYear)}}" class="card-footer text-center py-2">{{ trans('message.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
             </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-warning">
            <div class="card-body pb-0">
              <h4>{{ trans('message.monthly_sales') }}</h4>
               <?php
              $startMonthDate = date('Y-m-01');
              $endMonthDate = date('Y-m-t');
               ?>
               @if(($allowedCurrencies2) != null)
              <span>{{$allowedCurrencies2}}:&nbsp; {{currencyFormat($monthlySalesCurrency2,$code=$allowedCurrencies2)}}</span><br/>
              @endif
              <span>{{$allowedCurrencies1}}:&nbsp; {{currencyFormat($monthlySalesCurrency1,$code=$allowedCurrencies1)}}</span>
             
            </div>
            <a href="{{url('invoices?status=success&from='.$startMonthDate. '&till='.$endMonthDate)}}" class="card-footer text-center py-2">{{ trans('message.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
             </div>
        </div>

         <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-danger">
            <div class="card-body pb-0">
              <h4>{{ trans('message.pending_payments') }}</h4>
              @if(($allowedCurrencies2) != null)
              <span>{{$allowedCurrencies2}}: &nbsp;  {{currencyFormat($pendingPaymentCurrency2,$code=$allowedCurrencies2)}}</span><br/>
              @endif
               <span>{{$allowedCurrencies1}}: &nbsp; {{currencyFormat($pendingPaymentCurrency1,$code=$allowedCurrencies1)}} </span>
            </div>
             <a href="{{url('invoices?status=pending')}}" class="card-footer text-center py-2">{{ trans('message.more_info') }}
              <i class="fa fa-arrow-circle-right"></i></a>
             </div>
        </div>
        @php
        $startDate = new Carbon\Carbon('-30 days');
        $endDate = Carbon\Carbon::now()->subDay();
        @endphp
         <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-warning">
            <div class="card-body pb-0">
              <h4>{{ trans('message.products_installed_rate') }}&nbsp;{{number_format($getLast30DaysInstallation['rate'], 2, '.', '')}}%</h4>
              <span>{{ trans('message.total_subscription') }} &nbsp;  {{$getLast30DaysInstallation['total_subscription']}}</span></br>
              <span>{{ trans('message.not_installed') }} &nbsp;  {{$getLast30DaysInstallation['inactive_subscription']}}</span>
            </div>
               <a href="{{url('orders?ins_not_ins=not_installed&sub_from='.$startDate.'&sub_till='.$endDate)}}" class="card-footer text-center py-2">{{ trans('message.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
             </div>
        </div>
        @php
        $startDate = date('m/d/Y', strtotime('-1 months'));
        $endDate = date('m/d/Y');
        @endphp

        <div class="col-lg-4 col-sm-6">
          <!-- CoreUI widget card -->
          <div class="card text-white bg-info">
            <div class="card-body pb-0">
              <h4>{{ trans('message.paid_orders_rate') }}&nbsp;{{number_format($conversionRate['rate'], 2, '.', '')}}%</h4>
              <span>{{ trans('message.total_orders_rate') }} &nbsp;  {{$conversionRate['all_orders']}}</span></br>
              <span>{{ trans('message.paid_orders') }} &nbsp;  {{$conversionRate['paid_orders']}}</span>
            </div>
              <a href="{{url('orders?p_un=unpaid&from='.$startDate.'&till='.$endDate)}}" class="card-footer text-center py-2">{{ trans('message.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
             </div>
        </div>
</div>
{!! html()->form()->close() !!}



<div class="row">
    <?php
    $url = 'clients?' .
       'reg_from=' . $startDate . '&' .
       'mobile_verified=1&active=1&
       reg_till=' . $endDate;
    ?>

    {{-- Recently Registered Users --}}
    @component('mini_views.card', [
           'title' => trans('message.recently_register_users'),
           'layout' => 'custom',
           'collection'=> $users,
           'linkLeft'=> [  trans('message.view_all') => url($url)],

           'linkRight'=> [ trans('message.create_new_user') => url('clients/create')]
    ])
        <ul class="users-list clearfix">
            @foreach($users as $user)
            <?php
            $client = \DB::table('users')->find($user['id']);
            ?>
                <li>
                    <a class="users-list-name" href="{{url('clients/'.$user['id'])}}"> <img loading="lazy" src="{{$user['profile_pic']}}" style="height: 80px;width: 80px;" alt="User Image"></a>
                    <a class="users-list-name" href="{{url('clients/'.$user['id'])}}">{{$user['first_name']." ".$user['last_name']}}</a>

                    @php
                        $mytime = Carbon\Carbon::now();
                        $yesterday = Carbon\Carbon::yesterday();
                        $productSold=[];
                        $displayDate = new DateTime($user['created_at']);
                    @endphp

                    @if ($displayDate < $mytime)
                        <span class="users-list-date">{{($displayDate)->format('M j')}}</span>
                    @elseif ($displayDate == $yesterday)
                        <span class="users-list-date">{{ trans('message.yesterday') }}</span>
                    @else
                        <span class="users-list-date">{{ trans('message.today') }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endcomponent


    {{-- Recent Invoices(Past 30 Days) --}}
    @component('mini_views.card', [
           'title'=> trans('message.total_sold_products'),
           'layout' => 'table',
           'collection'=> $invoices,
           'columns'=> [ trans('message.invoice_no'), trans('message.total'), trans('message.user') ,trans('message.date'), trans('message.paid'), trans('message.balance'), trans('message.status')],
           'linkLeft'=> [ trans('message.view_all') => url('invoices?from='.$startDate.'&till='.$endDate)],
           'linkRight'=> [ trans('message.generate_new_invoice') => url('invoice/generate')]
    ])

        @foreach($invoices as $element)
            <?php
            $date = getDateHtml($element->date);
            ?>
            <tr>
                <td><a href="{{url('invoices/show?invoiceid='.$element->invoice_id)}}">{{$element->invoice_number}}</a></td>
                <td>{{$element->grand_total}}</td>
                <td><a href="{{'clients/'.$element->user_id}}">{{ $element->client_name }}</a></td>
                <td>{!! $date !!}</td>
                <td>{{$element->paid}}  </td>
                <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">{{$element->balance}}</div>
                </td>
               <td>{!! $element->status !!}</td>
            </tr>
        @endforeach
    @endcomponent

</div>


 <div class="row">
     {{-- Paid Orders Expired in Last 30 days --}}
     @php
        $currentDate = date('m/d/Y');
        $expiringSubscriptionDate = date('m/d/Y', strtotime('+1 months'));
        $expiredSubscriptionDate = date('m/d/Y', strtotime('-1 months'));
     @endphp

     @component('mini_views.card', [
            'title' => trans('message.paid_orders_expired'),
            'layout' => 'table',
            'collection'=> $expiredSubscriptions,
            'columns'=> [ trans('message.user'), trans('message.order_no'), trans('message.expiry'), trans('message.days_passed'), trans('message.product')],
            'linkRight'=> [ trans('message.place_new_order') => url('invoice/generate')],
            'linkLeft'=> [ trans('message.view_all') => url('orders?from='.$expiredSubscriptionDate.'&till='.$currentDate.'&renewal=expired_subscription&product_id=paid')]
     ])

         @foreach($expiredSubscriptions as $element)
             <tr>
                 <td><a href="{{$element->client_profile_link}}">{{ $element->client_name }}</a></td>
                 <td><a href="{{$element->order_link}}">{{$element->order_number}}</a></td>
                 <td style="color: red";>{!! $element->subscription_ends_at !!}</td>
                 <td>{{$element->days_difference}}</td>
                 <td>{{$element->product_name}}</td>
             </tr>
         @endforeach
     @endcomponent

     {{-- Paid Orders Expiring Soon (Next 30 Days) --}}
     @component('mini_views.card', [
            'title' => trans('message.paid_next_orders_expired'),
            'layout' => 'table',
            'collection'=> $subscriptions,
            'columns'=> [ trans('message.user'), trans('message.order_no'), trans('message.expiry'), trans('message.days_left'), trans('message.product')],
            'linkRight'=> [ trans('message.place_new_order') => url('invoice/generate')],
            'linkLeft'=> [ trans('message.view_all') => url('orders?from='.$currentDate.'&till='.$expiringSubscriptionDate.'&renewal=expiring_subscription&product_id=paid')]
     ])

         @foreach($subscriptions as $element)
             <tr>
                 <td><a href="{{$element->client_profile_link}}">{{ $element->client_name }}</a></td>
                 <td><a href="{{$element->order_link}}">{{$element->order_number}}</a></td>
                 <td>{!! $element->subscription_ends_at !!}</td>
                 <td>{{$element->days_difference}}</td>
                 <td>{{$element->product_name}}</td>
             </tr>
         @endforeach
     @endcomponent

 </div>

 <div class="row">

     {{--   Clients With outdated Product Version (Last 30) --}}
     @php
        // NOTE: adding a filter between latest and olderst version for paid products for seeing outdated versions and sorting them in ascending order
        $expiringSubscriptionDate = date('m/d/Y', strtotime('+1 months'));
        $latestVersion = \App\Model\Product\Subscription::orderBy("version", "desc")->groupBy("version")->skip(1)->value('version');
        $oldestVersion = \App\Model\Product\Subscription::where('version', '!=', null)->where('version', '!=', '')->orderBy("update_ends_at", "asc")->groupBy("version")->value('version');
     @endphp

     @component('mini_views.card', [
            'title' => trans('message.clients_outdated_version'),
            'layout' => 'table',
            'collection'=> $clientsUsingOldVersion,
            'columns'=> [trans('message.user'), trans('message.version'), trans('message.product'), trans('message.expiry')],
            'linkLeft'=> [ trans('message.view_all') => url('orders')."?product_id=paid&version=Outdated"],
            'linkRight'=> [ trans('message.create_new_product') => url('products/create')]
     ])
         @foreach($clientsUsingOldVersion as $element)
             <tr>
                 <td>{!! $element->client_name !!}</td>
                 <td>{!! getVersionAndLabel($element->product_version,$element->product_id) !!}</td>
                 <td>{!! $element->product_name !!}</td>
                 @if($element->subscription_ends_at < Carbon\Carbon::now()->toDateTimeString())
                 <td style="color: red;">{!! getDateHtml($element->subscription_ends_at) !!}</td>
                 @else
                 <td>{!! getDateHtml($element->subscription_ends_at) !!}</td>
                 @endif
             </tr>
         @endforeach
     @endcomponent


     {{-- Recent Paid Orders (Last 30 Days) --}}
     @component('mini_views.card', [
            'title' => trans('message.recent_paid_orders'),
            'layout' => 'table',
            'collection'=> $recentOrders,
            'columns'=> [trans('message.order_no'), trans('message.product'), trans('message.date'), trans('message.user')],
             'linkLeft'=> [ trans('message.view_all_orders') => url('orders?from='.$expiredSubscriptionDate.'&till='.$currentDate.'&product_id=paid')],
            'linkRight'=> [trans('message.place_new_order') => url('invoice/generate')]
     ])

         @foreach($recentOrders as $element)
             <tr>
                 <td><a href="{{url('orders/'.$element->order_id)}}">{{$element->order_number}}</a></td>
                 <td>{{$element->product_name}}</td>
                 <td>{!! $element->order_created_at !!}</td>
                 <td><a href="{{$element->client_profile_link}}" target="_blank" class="sparkbar" data-color="#00a65a" data-height="20">{{$element->client_name}}</a></td>
             </tr>
         @endforeach
     @endcomponent

 </div>

<div class="row">

    {{-- Products Sold  (Last 30 Days) --}}
    @component('mini_views.card', [
           'title' => trans('message.product_sold'),
           'layout' => 'list',
           'collection'=> $productSoldInLast30Days,
           'columns'=> [ trans('message.order_no'), trans('message.item'), trans('message.date'), trans('message.client')],
            'linkLeft'=> [ trans('message.view_all_orders') => url('orders?from='.$expiredSubscriptionDate.'&till='.$currentDate)],
           'linkRight'=> [ trans('message.place_new_order') => url('invoice/generate')]
    ])

        @foreach($productSoldInLast30Days as $element)
            <li class="item">
                <div class="product-img">
                    &nbsp;&nbsp;<img loading="lazy" src="{{$element->product_image}}" alt="Product Image">
                </div>
                <div class="product-info">
                    <a href="#" class="product-title">{{$element->product_name}}<strong> &nbsp; &nbsp;  <td><span class="label label-success">{{$element->order_count}}</span></td></strong>
                    </a>
                    <span class="product-description">
                        <strong> {{ trans('message.last_purchase') }} </strong>
                          {{$element->order_created_at}}
                    </span>

                </div>
            </li>
        @endforeach
    @endcomponent


    {{-- Total Sold Products --}}
    @component('mini_views.card', [
           'title'=> trans('message.total_sold_products'),
           'layout' => 'list',
           'collection'=> $allSoldProducts,
           'linkLeft'=> [ trans('message.view_sold_products') => url('products?value=totalSoldProduct')],
           'linkRight'=> [ trans('message.create_new_product') => url('products/create')]
    ])
        @foreach($allSoldProducts as $element)
            <li class="item">
                <div class="product-img">
                    &nbsp;&nbsp;<img loading="lazy" src="{{$element->product_image}}" alt="Product Image">
                </div>
                <div class="product-info">
                    <a href="#" class="product-title">{{$element->product_name}}<strong> &nbsp; &nbsp;  <td><span class="label label-success">{{$element->order_count}}</span></td></strong>
                    </a>
                    <span class="product-description">
                    <strong> {{ trans('message.last_purchase') }} </strong>
                      {{$element->order_created_at}}
                    </span>
                </div>
            </li>
        @endforeach
    @endcomponent
</div>
<script type="text/javascript">
  $('ul.nav-sidebar a').filter(function() {
        return this.id == 'dashboard';
    }).addClass('active');

    // for treeview
    $('ul.nav-treeview a').filter(function() {
        return this.id == 'dashboard';
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
  $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
        container : 'body'
    });
  })
</script>
@stop