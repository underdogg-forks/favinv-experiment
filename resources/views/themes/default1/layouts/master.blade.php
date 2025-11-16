<!DOCTYPE html>
<?php
    $set = new \App\Model\Common\Setting();
    $set = $set->findOrFail(1);
    $page_count = DB::table('frontend_pages')->count();
?>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar', 'he']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if($set->fav_icon)
    <link rel="shortcut icon" href='{{ $set->fav_icon }}' type="image/x-icon" />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <title>@yield('title') | {{$set->favicon_title}}</title>
    
    <!-- Tailwind CSS v4 with Vite -->
    @vite(['resources/assets/css/app.css', 'resources/assets/js/app.js'])
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('admin/css-1/all.min.css')}}">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    
    <!-- Additional plugins -->
    <link rel="stylesheet" href="{{asset('admin/css-1/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css-1/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css-1/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css-1/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css-1/flag-icons.min.css')}}">
    
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    
    <!-- Custom css/js -->
    <link rel="stylesheet" href="{{ asset('common/intl-tel-input/css/intlTelInput.css') }}">
    
    <!-- Sweet Alert -->
    @if(in_array(app()->getLocale(), ['ar', 'he']))
        <link rel="stylesheet" href="{{asset('admin/css-1/sweet-alert-rtl.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('admin/css-1/sweet-alert-ltr.css')}}">
    @endif
    
    <script src="{{asset('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js')}}"></script>
    <script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/admin/jquery.validate.js') }}"></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    <style>
        /* CoreUI Custom Overrides and CSS Variables Configuration */
        :root {
            /* You can customize these CSS variables to change the theme */
            --primary: #321fdb;
            --sidebar-bg: #2c384a;
            --navbar-bg: #fff;
            --body-bg: #e4e5e6;
        }
        
        .swal2-popup {
            margin:0 !important;
        }
        .swal2-title{
            padding-left:0 !important;
            padding-bottom:0 !important;
        }
        .swal2-html-container{
            padding-left:0 !important;
            padding-right:0 !important;
        }
        .custom-confirm,
        .custom-cancel {
            min-width: 100px;
        }
        .is-invalid + .select2-container .select2-selection {
            border: 1px solid #dc3545 !important;
        }
        .is-invalid + .tox-tinymce{
            border: 1px solid #dc3545 !important;
        }
        .required:after {
            content:'*';
            color:red;
            padding-left:5px;
        }
        [type=search] {
            outline-offset: 0px;
            -webkit-appearance: none;
        }
        .system-error{
            font-size:80%;
            color:#dc3545;
        }
        .table.dataTable thead th {
            padding: 8px 10px;
        }
        input[type="password"]::-ms-reveal {
            display: none !important;
        }
        .error-message{
            color: #dc3545;
            font-size: 80%;
        }
        .dropdown-menu-arrow:before {
            content: ""!important;
            position: absolute!important;
            top: -10px!important;
            left: 88%;
            transform: translate(-50%);
            border-width: 3px 7px 8px;
            border-style: solid;
            border-color: transparent transparent #3e4d5d
        }
        .model-box {
            margin-top: 8px !important;
            margin-right: 20px !important;
            padding-top: 9px !important;
            width: 170px !important;
            height: 82px !important;
            background-color: #4f5962;
        }
        .dp-data {
            background-color: #4f5962;
            color: #c2c7d0 !important;
        }
        .dp-data:hover {
            background-color: rgba(0,0,0,0.2);
            color: #c2c7d0;
        }
        .dropdown-profile {
            right: 0;
            left: auto !important;
        }
        .select2-results .select2-results__message {
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .tooltip {
            pointer-events: none;
        }
        .popover {
            pointer-events: auto;
        }
        #language-dropdown{
            z-index: 9999;
            max-height: none !important;
        }
        [dir="rtl"] #language-dropdown{
            margin-right: -150px !important;
        }
    </style>
</head>

@include('mini_views.loader')

<body class="app">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Brand Logo -->
        <div class="sidebar-brand d-md-down-none">
            @if ($set->admin_logo == '')
                <a href="{{url('/')}}" class="sidebar-brand-full">
                    <span class="sidebar-brand-full"><b>{{$set->title}}</b></span>
                </a>
                <a href="{{url('/')}}" class="sidebar-brand-minimized">
                    <span class="sidebar-brand-minimized"><b>{{substr($set->title, 0, 2)}}</b></span>
                </a>
            @else
                <a href="{{url('/')}}" class="sidebar-brand-full">
                    <img src="{{$set->admin_logo}}" class="sidebar-brand-full" alt="{{$set->title}}" style="max-height: 50px; width: auto;">
                </a>
                <a href="{{url('/')}}" class="sidebar-brand-minimized">
                    <img src="{{$set->fav_icon ?: $set->admin_logo}}" class="sidebar-brand-minimized" alt="{{$set->title}}" style="max-height: 35px; width: auto;">
                </a>
            @endif
        </div>
        
        <!-- Sidebar Navigation -->
        <ul class="sidebar-nav nav ps" data-widget="treeview">
            <!-- Dashboard -->
            <li class="sidebar-nav nav-item">
                <a href="{{url('/')}}" class="sidebar-nav nav-link" id="dashboard">
                    <i class="sidebar-nav nav-icon fas fa-tachometer-alt"></i>
                    {{Lang::get('message.dashboard')}}
                </a>
            </li>
            
            <!-- Users -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-users"></i>
                    {{ __('message.users') }}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('clients')}}" class="sidebar-nav nav-link" id="all_user">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{ __('message.all-users') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('clients/create')}}" class="sidebar-nav nav-link" id="add_user">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{ __('message.add-new') }}</span>
                        </a>
                    </li>
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('deleted-users')}}" class="sidebar-nav nav-link" id="soft_delete_user">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{ __('message.suspended_users') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Orders -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-chart-pie"></i>
                    {{ __('message.orders') }}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('orders')}}" class="sidebar-nav nav-link" id="all_order">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.all-orders')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Invoices -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-paperclip"></i>
                    {{Lang::get('message.invoices')}}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('invoices')}}" class="sidebar-nav nav-link" id="all_invoice">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.all-invoices')}}</span>
                        </a>
                    </li>
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('invoice/generate')}}" class="sidebar-nav nav-link" id="add_invoice">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.add-new')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Pages -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-sticky-note"></i>
                    {{Lang::get('message.pages')}}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('pages')}}" class="sidebar-nav nav-link" id="all_page">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.all-pages')}}</span>
                        </a>
                    </li>
                    @if($page_count <= 2)
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('pages/create')}}" class="sidebar-nav nav-link" id="all_new_page">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.add-new')}}</span>
                        </a>
                    </li>
                    @endif
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('demo/page')}}" class="sidebar-nav nav-link" id="demo_page">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.add-demo')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Products -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-briefcase"></i>
                    {{Lang::get('message.products')}}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('products')}}" class="sidebar-nav nav-link" id="all_product">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.all-products')}}</span>
                        </a>
                    </li>
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('products/create')}}" class="sidebar-nav nav-link" id="add_product">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.add-new')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Settings -->
            <li class="sidebar-nav nav-dropdown">
                <a href="#" class="sidebar-nav nav-dropdown-toggle">
                    <i class="sidebar-nav nav-icon fas fa-cog"></i>
                    {{Lang::get('message.settings')}}
                </a>
                <ul class="sidebar-nav nav-dropdown-items">
                    <li class="sidebar-nav nav-item">
                        <a href="{{url('settings')}}" class="sidebar-nav nav-link" id="system_setting">
                            <i class="sidebar-nav nav-icon far fa-circle"></i>
                            <span>{{Lang::get('message.system')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        
        <button class="sidebar-minimizer" type="button" ></button>
    </div>
    
    <!-- Main Content Wrapper -->
    <div class="app-body">
        <!-- Header -->
        <header class="app-header navbar">
            <button class="navbar-toggler  d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="sidebar-show">
                <i class="fas fa-bars"></i>
            </button>
            <button class="navbar-toggler  mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="sidebar-show" responsive="true">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-nav d-md-down-none">
                <li class="navbar-nav-item px-3">
                    <a href="{{url('client-dashboard')}}" class="navbar-nav-link">{{ __('message.go_to_client') }}</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ml-auto mr-4">
                <!-- Language Dropdown -->
                <li class="navbar-nav-item dropdown">
                    <a class="navbar-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php
                        $localeMap = [
                            'ar' => 'ae', 'bsn' => 'bs', 'de' => 'de', 'en' => 'us', 'en-gb' => 'gb',
                            'es' => 'es', 'fr' => 'fr', 'id' => 'id', 'it' => 'it', 'kr' => 'kr',
                            'mt' => 'mt', 'nl' => 'nl', 'no' => 'no', 'pt' => 'pt', 'ru' => 'ru',
                            'vi' => 'vn', 'zh-hans' => 'cn', 'zh-hant' => 'cn', 'ja' => 'jp',
                            'ta' => 'in', 'hi' => 'in', 'he' => 'il', 'tr' => 'tr',
                        ];
                        $currentLocale = app()->getLocale();
                        $flagCode = $localeMap[$currentLocale] ?? 'us';
                        ?>
                        <span class="fi fi-{{$flagCode}}"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" id="language-dropdown">
                        @include('themes.default1.common.language_dropdown')
                    </div>
                </li>
                
                <!-- User Dropdown -->
                <li class="navbar-nav-item dropdown">
                    <a class="navbar-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <div class="img-avatar">
                            <img src="{{Auth::user()->profile_pic}}" class="c-avatar-img" alt="{{Auth::user()->first_name}}">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2">
                            <strong>{{ucfirst(Auth::user()->first_name)}} {{ucfirst(Auth::user()->last_name)}}</strong>
                        </div>
                        <a class="dropdown-item" href="{{url('/clients/'.Auth::user()->id)}}">
                            <i class="c-icon fas fa-user"></i> {{ __('message.profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="c-icon fas fa-lock"></i> {{ __('message.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </header>
        
        <!-- Main Body -->
        <div class="app-body">
            <main class="main">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </div>
        
        <!-- Footer -->
        <footer class="app-footer">
            <div>
                <a href="https://faveo.com" target="_blank">Faveo Helpdesk</a>
                <span class="ml-1">&copy; {{ date('Y') }} Ladybird Web Solution.</span>
            </div>
            <div class="ml-auto">
                <span class="mr-1">Powered by</span>
                <a href="https://coreui.io" target="_blank">CoreUI 2.16</a>
            </div>
        </footer>
    </div>
    
    <!-- CoreUI Scripts -->
    <script src="{{asset('js/coreui/coreui.min.js')}}"></script>
    <script src="{{asset('js/coreui/coreui-utilities.min.js')}}"></script>
    <script src="{{asset('js/coreui/perfect-scrollbar.min.js')}}"></script>
    
    <!-- Bootstrap Bundle -->
    <script src="{{asset('admin/js-1/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Additional Plugins -->
    <script src="{{asset('admin/plugins-1/select2.full.min.js')}}"></script>
    <script src="{{asset('admin/plugins-1/moment.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
    <script src="{{asset('admin/plugins-1/bootstrap-switch.min.js')}}"></script>
    <script src="{{asset('admin/plugins-1/bs-stepper.min.js')}}"></script>
    <script src="{{asset('admin/plugins-1/summernote-bs4.min.js')}}"></script>
    
    <script>
        // Initialize CoreUI components
        $(document).ready(function() {
            // Initialize Perfect Scrollbar for sidebar
            if (document.querySelector('.sidebar-nav nav')) {
                const ps = new PerfectScrollbar('.sidebar-nav nav', {
                    wheelSpeed: 2,
                    wheelPropagation: true,
                    minScrollbarLength: 20
                });
            }
            
            // Bootstrap switch initialization
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
