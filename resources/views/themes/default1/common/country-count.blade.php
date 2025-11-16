@extends('themes.default1.layouts.master')
@section('title')
 {{ trans('message.settings') }}
@stop
@section('content-header')
    <div class="col-sm-6">
        <h1>{{ trans('message.country_list') }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{url('settings')}}"><i class="fa fa-dashboard"></i> {{ trans('message.settings') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('message.country_list') }}</li>
        </ol>
    </div><!-- /.col -->
@stop
@section('content')

<div class="card card-secondary card-outline">


        <div class="alert alert-success alert-dismissable" style="display: none;">
    <i class="fa  fa-check-circle"></i>
    <span class="success-msg"></span>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

      </div>
        <!-- fail message -->

        <div id="response"></div>
       


      <div class="card-body table-responsive">
        <div class="row">
        <div class="col-md-12 ">
      

                <table id="country-count" class="table display" cellspacing="0" width="100%" styleClass="borderless">
                            <thead><tr>
                            <th>{{ trans('message.country') }}</th>
                            <th>{{ trans('message.user_count') }}</th>
                            
                        </tr></thead>


                </table>
                </div>  
            </div>
            </div>
                </div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
     $('ul.nav-sidebar a').filter(function() {
        return this.id == 'setting';
    }).addClass('active');

    // for treeview
    $('ul.nav-treeview a').filter(function() {
        return this.id == 'setting';
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>
<script type="text/javascript">
        $('#country-count').DataTable({
            destroy:true,
            processing: true,
            stateSave: false,
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax: {
            "url":  '{!! route('country-count') !!}',
               error: function(xhr) {
               if(xhr.status == 401) {
                alert('{{ trans('message.session_expired') }}')
                window.location.href = '/login';
               }
            }

            },
            "oLanguage": {
                "sLengthMenu": "_MENU_ Records per page",
                "sSearch"    : "{{ trans('message.table_search') }}",
                "sProcessing": ' <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">{{ trans('message.loading') }}</div></div>',
            },
            language: {
                paginate: {
                    first:      "{{ trans('message.paginate_first') }}",
                    last:       "{{ trans('message.paginate_last') }}",
                    next:       "{{ trans('message.paginate_next') }}",
                    previous:   "{{ trans('message.paginate_previous') }}"
                },
                emptyTable:     "{{ trans('message.empty_table') }}",
                info:           "{{ trans('message.datatable_info') }}",
                zeroRecords:    "{{ trans('message.no_matching_records_found') }} ",
                infoEmpty:      "{{ trans('message.info_empty') }}",
                infoFiltered:   "{{ trans('message.info_filtered') }}",
                lengthMenu:     "{{ trans('message.length_menu') }}",
                loadingRecords: "{{ trans('message.loading_records') }}",
                search:         "{{ trans('message.table_search') }}",
            },
    
            columns: [
                {data: 'country', name: 'countries.nicename'},
                {data: 'count', name: 'count'},
            ],
            "fnDrawCallback": function( oSettings ) {
                $('.loader').css('display', 'none');
            },
            "fnPreDrawCallback": function(oSettings, json) {
                $('.loader').css('display', 'block');
            },
        });
    </script>


@stop











