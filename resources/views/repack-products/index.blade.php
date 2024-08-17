<x-app-layout title="{{ $title }}">
    @push('css')
        <style>

            .barcode-container {
                position: relative;
                /* display: inline-block; */
            }

            .popup {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgb(176, 255, 198);
                border: 1px solid #ccc;
                width: 300px;
                height: auto;
                /* Adjusting height to fit content */
                padding: 5px;
                z-index: 1;
                overflow-x: auto;
                /* Making content horizontally scrollable */
                white-space: nowrap;
                /* Preventing content from wrapping */
            }


            .barcode-container:hover .popup {
                display: block;
            }
    </style>
    @endpush
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <x-page-heading title="{{ __('Product Information') }}"></x-page-heading>
        {{-- <x-right-side-button link="{{ route('department.create') }}" title="Create"></x-right-side-button> --}}
        <x-alert></x-alert>
        <div class="container-fluid card mt-3">
            <div class="row card-body">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <button class="btn btn-warning" id="productModalButton">Delete Product</button>
                    <button class="btn btn-secondary" id="updateCtIdButton">Update CT.ID</button>
                    <button class="btn btn-primary" id="printButton">Print</button>
                
                    <div class="table-responsive pt-2">
                        <table id="dataTable" class="table">
                          <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>CSDID</th>
                                <th>MAITOU</th>
                                <th>BillId</th>
                                <th>P.Name</th>
                                <th>P.</th>
                                <th>P.</th>
                                <th>P.</th>
                                <th>P.</th>
                                <th>Barcode</th>
                                <th>W.H.</th>
                                <th>BY</th>
                                <th>Type</th>
                                <th>CTNs</th>
                                <th>W.T</th>
                                <th>T.W.T</th>
                                <th>L</th>
                                <th>W</th>
                                <th>H</th>
                                <th>T.Cube</th>
                                <th>Date/Time</th>
                                <th>Remark</th>
                                <th>CT ID</th>
                                <th>Log Status</th>
                                <th>LC</th>
                                <th>Print</th>
                                <th>COST</th>
                                <th>DBT</th>
                                <th>NTF.CS</th>
                                <th>PAISONG SIJI</th>
                                <th>SERVEY</th>
                                <th style="display:none;">SERVEY</th>
                            </tr>
                          </thead>
                          <tbody class="main-table">
                          </tbody>
                        </table>
                      </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content" style="width: 180% !important;">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Delete Repack Product</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form id="productForm">

                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col mb-12">
                                        <table id="tablehead" class="table table-bordered">
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" class="btn-close"
                                data-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="productModalUpdateCtId" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content" style="width: 180% !important;">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit CT.ID</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form id="productFormUpdateCtId">

                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col mb-12">
                                        <table id="thead" class="table table-bordered">
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col mb-12">
                            <label for="remarks" class="form-label">CT. ID</label>
                            <input type="text" class="form-control" id="ctid" name="ctid">
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update CT.ID</button>
                            <button type="button" class="btn btn-secondary" class="btn-close"
                                data-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="print" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content" style="width: 180% !important;">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Print</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form id="productPrintRequest">

                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col mb-12">
                                        <table id="thead-print" class="table table-bordered">
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Print</button>
                            <button type="button" class="btn btn-secondary" class="btn-close"
                                data-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

         <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="
        max-width: 650px;
    ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Product Image <button class="btn btn-success zoom-in">Zoom In</button></h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img width="800px" height="800px" src="" alt="Product Image"
                        class="img-fluid modal-image-content">
                </div>
            </div>
        </div>
    </div>

    <div id="popup_status"
    style="display: none; position: absolute; background-color: #f9f9f9; border: 1px solid #ccc; padding: 10px;">
</div>
<div id="popup" style="display:none; position:absolute; background-color:#fff; border:1px solid #ccc; padding:5px;">
        <p id="popup-content"></p>
    </div>

    @push('scripts')

<script type="text/javascript" charset="utf8" src="stopwatch.js"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('delete-repack.js') }}"></script>
<script>
    var serverTime = '{{ now() }}';
    var serverTimeDate = new Date(serverTime);
    // console.log(serverTime);
    // console.log(serverTimeDate);

    var countdownInterval = setInterval(function() {
        serverTimeDate.setSeconds(serverTimeDate.getSeconds() + 1);
    }, 1000);
</script>

        <script>
            $(document).ready(function() {

                function startCountdown(startTime, row) {
        var countdownInterval = setInterval(function () {
            var currentTime = serverTimeDate;
            var elapsedTime = currentTime - startTime;
            var days = Math.floor(elapsedTime / (1000 * 60 * 60 * 24));
            var hours = Math.floor((elapsedTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
            var countdownString = days + "D " + hours.toString().padStart(2, '0') + ":" + minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
            //  console.log(countdownString , row);
            row.querySelector('.dbttime').textContent = countdownString;

        }, 1000);
    }
function stopWatch()
  {
    var rowsForCountDown = document.querySelectorAll('tbody.main-table tr');
    console.log(rowsForCountDown);
    rowsForCountDown.forEach(function (row, index) {
        var startTime = row.querySelector('.dbttime');

        if (startTime != null) {
            var startTimeStr = startTime.textContent;
            if (startTimeStr.startsWith('Started:')) {

                var startTime = new Date(startTimeStr.replace('Started: ', ''));


                startCountdown(startTime, row);
            }
        }

    });
  }

  // Event listener for log status selection
    $(document).ready(function() {
        $('.editable-log_status').on('change', function() {
            var selectedValue = $(this).val();
            var $row = $(this).closest('tr'); // Assuming the row is the closest parent <tr> element

            // Clear any existing countdown interval
            if ($row.data('countdownIntervalId')) {
                clearInterval($row.data('countdownIntervalId'));
                $row.removeData('countdownIntervalId');
            }

            // Check if the selected value requires starting the countdown
            if (selectedValue === '6' || selectedValue === '15') {
                var startTime = new Date().getTime(); // Use current time as start time
                startCountdown(startTime, $row);
            }
        });
        var selectedValue = $("editable-log_status").val();
        if (selectedValue === '6' || selectedValue === '15') {
            var startTime = new Date().getTime(); // Use current time as start time
            startCountdown(startTime, $row);
        }
    });

  var table = $('#dataTable').DataTable({
                    "pageLength": 50,
                    "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("repackProductsData") }}',
                    'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        $(nRow).find('td').eq(21).attr('contenteditable', true);
                        $(nRow).find('td').eq(21).addClass('editable-remarks');
                        $(nRow).find('td').eq(21).attr('data-id', $(nRow).find('td').find('.product-id').val());
                        let checkbox = 'unchecked';
                        if ($('#checkAll').prop('checked')) {
                        checkbox = 'checked'
                        } else {
                        checkbox = 'unchecked';
                        }
                        $(nRow).find("input[type=checkbox]").prop(checkbox, aData.checkbox);
                    },
                    columns: [
                        { data: 'checkbox', name: 'checkbox' },
                        { data: 'csd_id', name: 'csd_id' },
                        { data: 'maitou', name: 'maitou' },
                        { data: 'bill_id', name: 'bill_id'},
                        { data: 'product_name', name: 'product_name'},
                        { data: 'photo1', name: 'photo1'},
                        { data: 'photo2', name: 'photo2'},
                        { data: 'photo3', name: 'photo3'},
                        { data: 'photo4', name: 'photo4'},
                        { data: 'sku', name: 'sku'},
                        { data: 'warehouse', name: 'warehouse',
                            render: function(data, type, full, meta)
                            {
                                if(data == '义乌')
                                {
                                return '<span style="color:red">' + data + '</span>';
                                }
                                else if(data == '广州'){
                                return '<span style="color:green">' + data + '</span>';
                                }
                                else if(data ==  '深圳')
                                {
                                return '<span style="color:blue">' + data + '</span>';
                                }
                                return '';
                            }
                        },
                        { data: 'option', name: 'option',
                        render: function(data, type, full, meta) {
                                let imageUrl = '';
                                if(data == 'SEA') {
                                    imageUrl = '{{ asset("assets/images/icons/sea.jpeg") }}';
                                } else if(data == 'EK') {
                                    imageUrl = '{{ asset("assets/images/icons/ek.jpeg") }}';
                                } else if(data == 'AIR') {
                                    imageUrl = '{{ asset("assets/images/icons/air.jpeg") }}';
                                }

                                if(imageUrl) {
                                    return '<img src="' + imageUrl + '" class="image-option">';
                                }
                                return '';
                            }
                        },
                        { data: 'type', name: 'type'},
                        { data: 'tpcs', name: 'tpcs'},
                        { data: 'weight', name: 'weight'},
                        { data: 'total_weight', name: 'total_weight'},
                        { data: 'length', name: 'length'},
                        { data: 'width', name: 'width'},
                        { data: 'height', name: 'height'},
                        { data: 't_cube', name: 't_cube'},
                        { data: 'created_at', name: 'created_at'},
                        { data: 'remarks', name: 'remarks'},
                        { data: 'ct_id', name: 'ct_id'},
                        { data: 'log_status', name: 'log_status'},
                        { data: 'lc', name: 'lc'},
                        { data: 'print', name: 'print'},
                        { data: 'cost', name: 'cost'},
                        { data: 'dbt', name: 'dbt'},
                        { data: 'ntf_cs', name: 'ntf_cs'},
                        { data: 'paisong_siji', name: 'paisong_siji'},
                        { data: 'survey', name: 'survey'},
                        { data: 'hidden_fields', name: 'hidden_fields'},

                    ]
                });

                table.on('draw.dt', function() {
                stopWatch();

            });

            });

            $(document).on('click', '.view-image', function() {
            $('#imageModal img').attr('src', '');
            var imageUrl = "{{ url('/') }}" + $(this).attr('data-image');
            $('#imageModal img').attr('src', imageUrl);
            $('#imageModal').modal('show');
            console.log('lets see' , $(this).attr('data-image') , imageUrl);
        });
         $(document).ready(function () {
            $('#imageModal').on('show.bs.modal', function() {
                if( $("#repackModal").hasClass('show') ){
                    $(this).css("z-index", "1111");
                }
            });
         });

         function copyProducts(text) {
          const textArea = document.createElement("textarea");
          textArea.value = text;
          document.body.appendChild(textArea);
          textArea.focus();
          textArea.select();
          try {
                document.execCommand('copy');
                alert('Products copied to clipboard');
          } catch (err) {
            console.error('Unable to copy to clipboard', err);
          }
          document.body.removeChild(textArea);
        }



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

            // Function to show popup
            function showPopupLc(x, y, description) {

                $('#popup').css({ top: y + 10, left: x + 10 }).show();
                $('#popup-content').text(description);
            }

            // Function to hide popup
            function hidePopupLc() {
                $('#popup').hide();
            }

            // Event listener for hover
            $(document).on('mouseenter', '.editable-lc, .editable-cost, .editable-ntf_cs', function(event) {
            var $select = $(this);
            var description = $select.find('option:selected').attr('data-description');
            var x = event.clientX;
            var y = event.clientY;
            if(description !== "N/A"){
                // Disable the drop-down and change its color
                $select.prop('disabled', true);
                $select.addClass('disabled-dropdown'); // Apply the disabled class
                showPopupLc(x, y, description);
            }

            }).on('mouseleave', '.editable-lc', function() {
                 hidePopupLc();
            });




            // Event listener for change
            $(document).on('change', '.editable-lc, .editable-cost, .editable-ntf_cs', function() {
                var $select = $(this); // The <select> element that triggered the event
                var id = $select.data('id'); // Get the ID from data-id
                var selectedValue = $select.val(); // Get the selected value
                var classNameString = $(this).attr('class');
                var loggedInUserId = @json(auth()->id());
                var userId = loggedInUserId; // Ensure loggedInUserId is defined and holds the user ID

                $.ajax({
                    url: '/update-option/' + id,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        new_option: selectedValue, // Send the new option value
                        user_id: userId, // Send the user ID
                        className:classNameString
                    },
                    success: function(response) {
                        // Disable the drop-down and change its color
                        $select.prop('disabled', true);
                        $select.addClass('disabled-dropdown'); // Apply the disabled class
                    },
                    error: function(xhr) {
                        // Handle error
                        console.error('An error occurred:', xhr.responseText);
                        alert('An error occurred while updating the option.');
                    }
                });
            });

         $(document).on('blur', '.editable-remarks', function () {
            var $this = $(this);
            // if ($this.text().trim() === originalContent) {
            //     return;
            // }

            $(this).addClass('editing');;

            // clearTimeout(editingTimeout);

            // // Use a timeout to delay the API call after the user finishes editing
            // editingTimeout = setTimeout(function() {
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-repack-remarks/' + id,
                data: {
                    remarks: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    // alert(response.message);
                    var $editableLink = $('.editable-link[data-id="' + id + '"]');
                    $editableLink.text(value);
                    $editableLink.attr('href',
                        'https://dhl.com/index.php?route=account%2Fshipping&search=' +
                        value.trim());

                    $this.removeClass('editing')
                },
                error: function (error) {
                    console.log(error);
                    // alert("Error saving data please try again");
                }
            });
            // }, 1500); // Adjust the timeout duration as needed

    });

    $(document).ready(function(){

            // Event listener for dynamically generated elements
    $(document).on('mouseenter', '.editable-log_status', function(event) {
        var description = $(this).find('option:selected').attr('data-description');
        var x = event.clientX;
        var y = event.clientY;
        showPopup(x, y, description);
    }).on('mouseleave', '.editable-log_status', function() {
        hidePopup();
    });


        });


        $(document).ready(function(){
            $(document).on('click','.zoom-in', function(){
                $(this).addClass('zoom-out');
                $(this).html('Zoom out');
                $(this).removeClass('zoom-in');

                $(this).parent().parent().parent().parent().css('max-width', '65rem');
            });
            $(document).on('click','.zoom-out', function(){
                $(this).addClass('zoom-in');
                $(this).removeClass('zoom-out');
                $(this).html('Zoom In');

                $(this).parent().parent().parent().parent().css('max-width', '650px');
            });
        });



        </script>


    @endpush

</x-app-layout>
