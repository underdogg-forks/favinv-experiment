
@extends('themes.default1.layouts.front.master')
@section('title')
    {{ trans('message.invoice') }}
@stop
@section('nav-invoice')
    active
@stop
@section('page-heading')
    {{ trans('message.my_invoices')}}
@stop
@section('breadcrumb')
    @if(Auth::check())
        <li><a class="text-primary" href="{{url('my-invoices')}}">{{ trans('message.home')}}</a></li>
    @else
         <li><a class="text-primary" href="{{url('login')}}">{{ trans('message.home')}}</a></li>
    @endif
     <li class="active text-dark">{{ trans('message.my_invoices')}}</li>
@stop 
<?php $check = App\User::where('id', Auth::id())->value('company');

?>
@section('content')
   <style>
        [type=search] {
            padding-right: 20px;
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            margin-left: 3px;
            background-color: transparent;
}
        }
        #myModal {
            position: absolute;
            top: 65%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
        }
        #invoice-table td {
            padding-left: 10px; 
        }
        td a {
        margin-top: 5px; 
        }
        
        [name="invoice-table_length"] {
        background-color: white;
        height: 32px;
        padding: 4px;
        border-radius: 4px;
    }
        [dir="rtl"] .close {
            margin: -1rem -1rem -1rem !important;
        }

</style>

    @auth

        <div class="d-flex justify-content-end mb-2">
            <button class="btn-credit open-createCreditDialog text-truncate"
                    style="background-color: white; border: none; max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <i class="fas fa-credit-card me-1"></i>
                {{ trans('message.credits') }} {!! $formattedValue !!}
            </button>
        </div>
        <script>
            $(document).ready(function () {
                $(document).on("click", ".open-createCreditDialog", function () {
                    $('#credit').modal('show');
                });
            });
        </script>
    @endauth

            
            <div id="message-container"></div>
            <div class="modal fade" id="credit" tabindex="-1" role="dialog" aria-labelledby="creditLabel" aria-hidden="true">

                <div class="modal-dialog credit-dialog">
                    <div class="modal-content credit-content">
                        <div class="modal-header credit-header">
                            <h4 class="modal-title credit-title">{{ trans('message.credit_balance')}} {!! $formattedValue !!}</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body credit-body">
                            <ul class="list-group">
                                <h6 class="modal-title">{{ trans('message.credit_balance_history')}}</h6>
                                <br>

                                @if(!$payment_activity->isEmpty())
                                    @foreach($payment_activity as $activity)
                                        <li class="list-group-item">
                                            {!! getDateHtml($activity->created_at) !!}
                                            <br>
                                            {!! $activity->text !!}
                                            <br>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item" style="text-align: center">{{ trans('message.activity_recorded')}}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

           <div class="row pt-2">

            @include('themes.default1.front.clients.navbar')
            
            


                <div class="col-lg-10">

                   <div class="tab-pane tab-pane-navigation active" id="invoices" role="tabpanel">

                        <div id="examples" class="container py-4">

                            <div class="row">

                                <div class="col">
                                    <div class="table-responsive">

                                                <table id="invoice-table" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>{{ trans('message.invoice_no')}}</th>
                                                    <th>{{ trans('message.date')}}</th>
                                                    <th>{{ trans('message.order_no')}}</th>
                                                    <th>{{ trans('message.total')}}</th>
                                                    <th>{{ trans('message.paid')}}</th>
                                                    <th>{{ trans('message.balance')}}</th>
                                                    <th>{{ trans('message.status')}}</th>
                                                    <th style="width: 122px;">{{ trans('message.action')}}</th>

                                                </tr> </thead>
                                            </table>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('message.required_details')}}</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ url('store-basic-details') }}">
                        @csrf
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><b>{{ trans('message.company')}}</b><span style="color: red;">*</span></label>
                            <input type="text" class="form-control required" id="company" name="company">

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label"><b>{{ trans('message.address')}}</b><span style="color: red;">*</span></label>
                            <textarea class="form-control required" id="address" name="address"></textarea>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span class="button-text"> <i class="fa fa-save">&nbsp;&nbsp;</i>{{ trans('message.save')}}</span>
                    </button>
                </div>

            </div>
        </div>
    </div>

   <!-- Delete Confirmation Modal -->
   <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="deleteModalLabel">{{ trans('message.confirm_deletion') }}</h5>
                   <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   {{ trans('message.delete_invoice') }}
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="cancelBtn">{{ trans('message.cancel') }}</button>
                   <button type="button" class="btn btn-primary" id="confirmDeleteBtn">{{ trans('message.delete') }}</button>
               </div>
           </div>
       </div>
   </div>

    <script>
        $(document).ready(function () {
            var deleteId; // Store the invoice ID temporarily

            // Show modal on delete button click
            $('#invoice-table').on('click', '.delete-btn', function () {
                deleteId = $(this).data('id'); // Get the invoice ID
                $('#deleteConfirmationModal').modal('show'); // Show the modal
            });

            // Handle delete confirmation
            $('#confirmDeleteBtn').on('click', function () {
                var messageContainer = $('#message-container');

                // Send AJAX request to delete item
                $.ajax({
                    url: "{{ url('invoices/delete/') }}/" + deleteId,
                    type: 'DELETE',
                    beforeSend: function () {
                        $('#deleteConfirmationModal').modal('hide');
                    },
                    success: function (response) {
                        // Display success message
                        var successMessage = '<div class="alert alert-success alert-dismissible">' +
                            '<button type="button" class="btn-close" data-dismiss="alert" aria-label="{{ trans('message.close') }}">' +
                            '<span aria-hidden="true"></span></button>' +
                            '<strong><i class="far fa-thumbs-up"></i> {{ trans('message.well_done') }} </strong>' +
                            response.message + '!</div>';
                        messageContainer.html(successMessage);

                        // Reload the DataTable
                        setTimeout(function () {
                            messageContainer.empty();
                            location.reload();
                        }, 5000);
                    },
                    error: function (xhr, status, error) {

                        // Display error message
                        var errorMessage = '<div class="alert alert-danger alert-dismissible">' +
                            '<button type="button" class="btn-close" data-dismiss="alert" aria-label="{{ trans('message.close') }}">' +
                            '<span aria-hidden="true"></span></button>' +
                            '<strong>{{ trans('message.oh_snap') }} </strong>{{ trans('message.something_wrong') }}<br><br><ul>';
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                        errorMessage += '</ul></div>';
                        messageContainer.html(errorMessage);

                        setTimeout(function () {
                            messageContainer.empty();
                            location.reload();
                        }, 5000);
                    },
                    complete: function () {
                        $('#deleteConfirmationModal').modal('hide');
                        window.scrollTo(0, 0);
                    }
                });
            });
        });

    </script>
    <script type="text/javascript">



        $(document).ready(function() {
            $('#submit').click(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Custom validation logic here
                const company = $('#company').val();
                const address = $('#address').val();

                // Check if the fields are empty
                if (company.trim() === '' || address.trim() === '') {
                    // Display an error message or take appropriate action
                    alert(@json(trans('message.company_details_required')));
                } else {
                    // If fields are not empty, proceed with the form submission
                    var btn = $(this);
                    btn.prop('disabled', true);
                    btn.find('.spinner-border').removeClass('d-none');
                    btn.find('.button-text').text('Saving...');

                    var formData = $('#myModal form').serialize();

                    $.ajax({
                        url: $('#myModal form').attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            btn.prop('disabled', false);
                            btn.find('.spinner-border').addClass('d-none');
                            btn.find('.button-text').text('Save');
                            $('#myModal').modal('hide');
                            localStorage.setItem('isModalFilled', 'true');
                        },
                        error: function(xhr, status, error) {
                            btn.prop('disabled', false);
                            btn.find('.spinner-border').addClass('d-none');
                            btn.find('.button-text').text('Save');
                        }
                    });
                }
            });
        });

    </script>
    <script>
       var status = '';

        $('#invoice-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 1, "asc" ]],
            ajax: {
                "url": '{!! route('get-my-invoices', "status=$request->status") !!}',

                error: function(xhr) {
                    if(xhr.status == 401) {
                        alert(@json(trans('message.session_expired')));
                        window.location.href = '/login';
                    }
                }

            },
            "oLanguage": {
                "sLengthMenu": "_MENU_ Records per page",
                "sSearch"    : "Search: ",
                "sProcessing": '<img id="blur-bg" class="backgroundfadein" style="top:40%;left:50%; width: 50px; height:50 px; display: block; position:    fixed;" src="{!! asset("lb-faveo/media/images/gifloader3.gif") !!}">'
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
                {data: 'number', name: 'number'},
                {data: 'date', name: 'date'},
                {data: 'orderNo', name: 'orderNo'},
                {data: 'total', name: 'grand_total'},
                {data: 'paid', name: 'paid'},
                {data: 'balance', name: 'balance'},
                {data: 'status', name: 'status'},
                {data: 'Action', name: 'Action', searchable: true}
            ],
            
            "fnDrawCallback": function( oSettings ) {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip({
                        container : 'body'
                    });
                });
                $('.loader').css('display', 'none');
            },
            "fnPreDrawCallback": function(oSettings, json) {
                $('.loader').css('display', 'block');
            },
        });

    </script>
    @if(!$check)
        <script>
            $(window).on('load', function () {
                const isFirstLogin = !localStorage.getItem('isLoggedIn');
                const isModalFilled = localStorage.getItem('isModalFilled');

                if (isFirstLogin && !isModalFilled) {
                    $('#myModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }

                $('#myModal form').on('submit', function () {
                    localStorage.setItem('isModalFilled', 'true');
                });
            });

        </script>

    @endif
    <style>

        /* Custom styles */
        .btn-credit {
            font-size: 14px;
            padding: 5px 10px;
        }
        .credit-dialog {
            max-width: 600px;
        }
        .credit-content {
            border: none;
            border-radius: 10px;
        }
        .credit-header {
            border-bottom: none;
        }
        .credit-title {
            font-size: 18px;
        }
        .credit-body {
            max-height: 400px;
            overflow-y: auto;
        }
        .list-group-item {
            border: none;
            padding: 8px 15px;
            margin-bottom: 5px; /* Add margin between list items */
            background-color: #f8f9fa; /* Light gray background */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
    </style>


 @stop
 