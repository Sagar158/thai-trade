<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} : {{ isset($title) ? $title : '' }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/dropify.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
        @if(Session::has('theme') && (Session::get('theme') == 'dark'))
            <link rel="stylesheet" href="{{ asset('assets/css/demo_2/style.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
        @endif
        <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}" type="image/x-icon">
        <!-- Scripts -->
        @stack('css')
        <script>var base_url = "{{ url('/') }}"</script>
    <style>
        select.form-control, select, .email-compose-fields .select2-container--default select.select2-selection--multiple, .select2-container--default select.select2-selection--single, .select2-container--default .select2-selection--single select.select2-search__field, select.typeahead, select.tt-query, select.tt-hint
        {
            padding: 0 .3rem !important;
            padding-top: 0px;
            padding-right: 0.3rem;
            padding-bottom: 0px;
            padding-left: 0.3rem;
            border: 1px solid #e8ebf1;
            border-radius: 0px;
            outline: none;
            color: #c9c8c8;
        }
        .form-control, select, .email-compose-fields .select2-container--default .select2-selection--multiple, .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field, .typeahead, .tt-query, .tt-hint {
            border: 1px solid #e8ebf1;
            font-weight: 400;
            font-size: 0.70rem !important;
        }
        .table td {
            font-size: 0.70rem !important;
        }
    </style>
    </head>
    <body class="font-sans antialiased">
        <div class="main-wrapper">
            <x-sidebar></x-sidebar>
            <x-settings-sidebar></x-settings-sidebar>
            <div class="page-wrapper">
                <x-header></x-header>
                <div class="page-content">
                    {{ $slot }}
                </div>
                <x-footer></x-footer>
            </div>
        </div>
            <div id="popup_status"
        style="display: none; position: absolute; background-color: #f9f9f9; border: 1px solid #ccc; padding: 10px;">
    </div>

    </body>

	<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
	<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
	<script src="{{ asset('assets/js/dropify.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('product-calculation.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('repack-update2.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('delete-repack.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('print-repack.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('product-update.js') }}"></script>

    <script>
            function refreshSelectBox()
            {
                $('.ajax-endpoint').each(function() {
                    var $this = $(this);
                    var endpoint = $this.data('endpoint');
                    var placeholder = $this.data('placeholder');
                    var field1 = $this.data('field1-id');
                    var field2 = $this.data('field2-id');
                    var countryId = $('select[name="state_id"]').attr('data-field1-id');
                    $this.select2({
                        ajax: {
                            url: endpoint,
                            dataType: 'json',

                            data: function(params) {
                                var data = {
                                    search: params.term,
                                    field1: field1,
                                    field2: field2,
                                    countryId: countryId
                                };
                                return data;
                            },
                            processResults: function(response) {
                                return {
                                    results: response.data.map(function(item) {
                                        return { id: item.id, text: item.name };
                                    })
                                };
                            }
                        },
                        minimumInputLength: 0,
                        placeholder: placeholder,
                    });
                });
            }
    </script>
    @stack('scripts')
    <script>
        $(document).ready(function(){
            $("#alert").fadeTo(5000, 500).slideUp(1000, function(){
                $("#alert").slideUp(100);
            });

            $(document).on('click','.delete-record',function(){
                var route = $(this).attr('data-route');
                Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                            if (result.isConfirmed)
                            {
                                $.ajax({
                                        url: route,
                                        method: 'POST',
                                        headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(response)
                                        {

                                            if(response.success == 1)
                                            {
                                                Swal.fire({
                                                        title: "Deleted!",
                                                        text: "Record has been deleted successfully",
                                                        icon: "success"
                                                     });
                                                $('#dataTable').DataTable().ajax.reload();
                                            }
                                            else
                                            {
                                                Swal.fire({
                                                        title: "OOPS!",
                                                        text: "Something went wrong",
                                                        icon: "error"
                                                     });
                                            }
                                        }
                                      });
                            }
                        });
            });

            refreshSelectBox();
        });
        $('.editable-product-id, .editable-cs-did, .editable-product-name, .editable-tpcs, .editable-weight, .editable-l, .editable-w, .editable-h, .editable-remarks')
            .on('blur', function() {
                table.destroy();
                table = $('#productTable').DataTable({
                    paging: false,
                    autoWidth: false,
                    info: false,
                    lengthChange: false,
                    ordering: false,
                });
            });


        $(document).ready(function() {
            $('.editable-log_status').hover(function(event) {
                // var selectedId = $(this).val();
                var description = $(this).find('option:selected').attr('data-description');
                var x = event.clientX;
                var y = event.clientY;
                showPopup(x, y, description);
            }, function() {
                hidePopup();
            });
        });

        function showPopup(x, y, selectedId) {
            var popup = $("#popup_status");
            popup.html(selectedId);
            popup.css({
                display: "block",
                top: (y + 10) + "px",
                left: (x + 10) + "px"
            });
        }

        function hidePopup() {
            $("#popup_status").css("display", "none");
        }

        $('#select-all-checkbox').on('change', function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.row-checkbox').on('change', function() {
            if (!$(this).prop('checked')) {
                $('#select-all-checkbox').prop('checked', false);
            }
        });

    </script>


</html>
