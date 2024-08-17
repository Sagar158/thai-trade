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
        <x-page-heading title="{{ __('BKW-C2T Product Information') }}"></x-page-heading>
        {{-- <x-right-side-button link="{{ route('department.create') }}" title="Create"></x-right-side-button> --}}
        <x-alert></x-alert>
        @php($product = \App\Models\RepackProduct::orderBy('id', 'desc')->first())
        <div class="container-fluid card mt-3">
            <div class="row card-body pb-0 pt-0">
                <div class="col-lg-3 col-sm-3 col-md-3 pt-5">
                    <button class="btn btn-secondary" id="updateCtIdButton">Update CT.ID</button>
                    <button class="btn btn-primary" id="printButton">Print</button>
                </div>
                <div class="col-lg-9 col-sm-19 col-md-9">
                    <form action="{{ route('ctid_lc_change') }}" method="post" class="d-flex justify-content-start mt-2">
                        @csrf
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">CTD ID</label>
                                        <select onchange="fetchLogStatus(this.value)" class="js-example-basic-single w-100 select2-hidden-accessible" data-width="100%" name="ci_id" id="ci_id"   >
                                            <option value="">Select CTD ID</option>
                                            @if(!empty($ct_ids))
                                                @foreach($ct_ids as $key => $data)
                                                    <option value="{{ $key }}" >{{ $data }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                 </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Log Status</label>
                                    <select  class="js-example-basic-single w-100 select2-hidden-accessible" data-width="100%" name="logStatus" id="logStatus"   >
                                        <option value="">Select Log Status</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <x-select-box id="lc_new" name="lc_new" :value="old('lc_new')" :values="$lcs" autocomplete="off" placeholder="LC" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                                    {{--<button class="btn btn-secondary mt-4">Reset</button>--}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                          <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>CSDID</th>
                                <th>MAITOU</th>
                                <th>BillId</th>
                                <th>CT ID</th>
                                <th>T.Cube</th>
                                <th>Barcode</th>
                                <th>BY</th>
                                <th>Log Status</th>
                                <th>LC</th>
                                <th>Print</th>
                                <th>Cost</th>
                                <th>NTF.CS</th>
                                <th>DBT</th>
                                <th class="d-none">Remark</th>
                                <th class="d-none">SKU</th>
                            </tr>
                          </thead>
                          <tbody class="main-table"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="popup_status" style="display: none; position: absolute; background-color: #f9f9f9; border: 1px solid #ccc; padding: 10px;"></div>
    <div id="popup" style="display:none; position:absolute; background-color:#fff; border:1px solid #ccc; padding:5px;">
        <p id="popup-content"></p>
    </div>
        <div class="modal fade" id="productModalUpdateCtId" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content" style="width: 180%;">
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
            <div class="modal-content" style="width: 180%;">
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

                        var table = $('#dataTable').DataTable({
                                "pageLength": 50,
                                "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
                                processing: true,
                                serverSide: true,
                                ajax: '{{ route("repackProductsData") }}',
                                'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                    let checkbox = 'unchecked';
                                    if ($('#checkAll').prop('checked')) {
                    checkbox = 'checked'
                } else {
                    checkbox = 'unchecked';
                }
                    $(nRow).find("input[type=checkbox]").prop(checkbox, aData.checkbox);

                    $(nRow).find('td:last').prev('td').hide();
                },
                columns: [
                    { data: 'checkbox', name: 'checkbox' },
                    { data: 'csd_id', name: 'csd_id' },
                    { data: 'maitou', name: 'maitou' },


                    {
                        data: 'bill_id',
                        name: 'bill_id',
                        render: function(data, type, full, meta) {
                            // Assuming your route for viewing bill details is named 'bill.view'
                            if (data) {
                                var url =
                                    '{{ route('products.index', ['bill_id' => 'BillParam']) }}';
                                url = url.replace('BillParam', data);
                                return '<a href="' + url + '">' + data + '</a>';
                            } else {
                                return '';
                            }

                        }
                    },
                    { data: 'ct_id', name: 'ct_id'},
                    { data: 't_cube', name: 't_cube'},
                    { data: 'sku', name: 'sku'},
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
                                    return '<img src="' + imageUrl + '"  class="image-option">';
                                }
                                return '';
                            }
                        },
                    { data: 'log_status', name: 'log_status'},
                    { data: 'lc', name: 'lc' },
                    { data: 'print', name: 'print'},
                    { data: 'cost', name: 'cost'},
                    { data: 'ntf_cs', name: 'ntf_cs'},
                    { data: 'dbt', name: 'dbt'},
                    { data: 'sku', name: 'sku'},
                    { data: 'hidden_fields', name: 'hidden_fields'},
                ]
            });

            // Add search event listener
            table.on('draw.dt', function() {
                stopWatch();

            });

        });
        // Define the function to handle input
        function handleInput() {
            var searchValue = document.getElementById('searchInput').value;

            sendDataToServer(searchValue);
        }

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

        function sendDataToServer(data) {
            var xhr = new XMLHttpRequest();

            // Construct the URL with the search value as part of the path
            var url = '/custom_search/' + encodeURIComponent(data);


            xhr.open('GET', url, true); // Change to GET request
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var responseData = JSON.parse(xhr.responseText);
                    if (responseData.hasOwnProperty('repackProducts')) {
                        var repackProducts = responseData['repackProducts'];
                        updateDataTable(repackProducts);
                        if (repackProducts.length < 50) {

                            document.getElementById('pagenation').style.cssText = 'display: none !important';
                        } else {
                            document.getElementById('pagenation').style.display = 'block';
                        }

                    } else {
                        console.error('repackProducts not found in JSON response');
                    }
                } else {
                    console.error('Error receiving data:', xhr.statusText);
                }
            };

            // Send the GET request
            xhr.send();
        }

        function updateDataTable(data) {
            var tbody = document.querySelector('#productTable tbody');
            tbody.innerHTML = ''; // Clear existing rows

            data.forEach(function(product, index) {
                var row = document.createElement('tr');

                // Add checkbox cell
                var checkboxCell = document.createElement('td');
                checkboxCell.innerHTML = '<input type="checkbox" class="row-checkbox" data-row-index="' + index +
                    '">';
                row.appendChild(checkboxCell);

                // Customer CS
                var customerCSCell = document.createElement('td');
                if (product.customer) {
                    customerCSCell.textContent = product.customer.CS;
                }
                row.appendChild(customerCSCell);

                // Product ID
                var productIDCell = document.createElement('td');
                productIDCell.textContent = product.product_id;
                row.appendChild(productIDCell);

                // Bill ID
                var billIDCell = document.createElement('td');
                billIDCell.textContent = product.bill_id;
                row.appendChild(billIDCell);

                // Product Name (Hidden)
                var productNameCell = document.createElement('td');
                productNameCell.style.display = 'none';
                productNameCell.textContent = product.name;
                row.appendChild(productNameCell);

                // Photo 1 (Hidden)
                var photo1Cell = document.createElement('td');
                photo1Cell.style.display = 'none';
                // Add logic for photo 1
                // ...

                // Photo 2 (Hidden)
                var photo2Cell = document.createElement('td');
                photo2Cell.style.display = 'none';
                // Add logic for photo 2
                // ...

                // Photo 3 (Hidden)
                var photo3Cell = document.createElement('td');
                photo3Cell.style.display = 'none';
                // Add logic for photo 3
                // ...

                // Photo 4 (Hidden)
                var photo4Cell = document.createElement('td');
                photo4Cell.style.display = 'none';
                // Add logic for photo 4
                // ...

                // Barcode Container (Hidden)
                var barcodeContainerCell = document.createElement('td');
                barcodeContainerCell.style.display = 'none';
                // Add logic for barcode container
                // ...

                // Warehouse (Hidden)
                var warehouseCell = document.createElement('td');
                warehouseCell.style.display = 'none';
                warehouseCell.textContent = product.warehouse;
                row.appendChild(warehouseCell);

                // Option (Hidden)
                var optionCell = document.createElement('td');
                optionCell.style.display = 'none';
                optionCell.textContent = product.option;
                row.appendChild(optionCell);

                // Type (Hidden)
                var typeCell = document.createElement('td');
                typeCell.style.display = 'none';
                typeCell.textContent = product.type;
                row.appendChild(typeCell);

                // tpcs (Hidden)
                var tpcsCell = document.createElement('td');
                tpcsCell.style.display = 'none';
                tpcsCell.contentEditable = true;
                tpcsCell.id = 'tpcs' + index;
                tpcsCell.classList.add('editable-tpcs');
                tpcsCell.dataset.id = product.id;
                tpcsCell.textContent = product.tpcs;
                row.appendChild(tpcsCell);

                // Weight (Hidden)
                var weightCell = document.createElement('td');
                weightCell.style.display = 'none';
                weightCell.contentEditable = true;
                weightCell.id = 'weight' + index;
                weightCell.classList.add('editable-weight');
                weightCell.dataset.id = product.id;
                weightCell.textContent = product.weight;
                row.appendChild(weightCell);

                // Total Weight Result (Hidden)
                var totalWeightResultCell = document.createElement('td');
                totalWeightResultCell.style.display = 'none';
                totalWeightResultCell.id = 'totalWeightResult' + index;
                row.appendChild(totalWeightResultCell);

                // l (Hidden)
                var lCell = document.createElement('td');
                lCell.style.display = 'none';
                lCell.contentEditable = true;
                lCell.classList.add('editable-l');
                lCell.id = 'l' + index;
                lCell.dataset.id = product.id;
                lCell.textContent = product.l;
                row.appendChild(lCell);

                // w (Hidden)
                var wCell = document.createElement('td');
                wCell.style.display = 'none';
                wCell.contentEditable = true;
                wCell.classList.add('editable-w');
                wCell.id = 'w' + index;
                wCell.dataset.id = product.id;
                wCell.textContent = product.w;
                row.appendChild(wCell);

                // h (Hidden)
                var hCell = document.createElement('td');
                hCell.style.display = 'none';
                hCell.contentEditable = true;
                hCell.classList.add('editable-h');
                hCell.id = 'h' + index;
                hCell.dataset.id = product.id;
                hCell.textContent = product.h;
                row.appendChild(hCell);



                // Calculation Result (Hidden)
                var calculationResultCell = document.createElement('td');
                calculationResultCell.classList.add('product-tcube');
                calculationResultCell.id = 'calculationResult' + index;
                row.appendChild(calculationResultCell);

                // Function to update the calculation result
                function updateCalculation() {
                    var l = parseFloat(lCell.textContent);
                    var w = parseFloat(wCell.textContent);
                    var h = parseFloat(hCell.textContent);
                    var tpcs = parseFloat(tpcsCell.textContent);
                //    var result = (l * w * h / 1000000) * tpcs;
                //    calculationResultCell.textContent = result.toFixed(2); // Adjust precision as needed
                    if(product.t_cube > 0 ){
                        var result = product.t_cube//(l * w * h / 1000000) * tpcs;
                        calculationResultCell.textContent = result; // Adjust precision as needed

                    }else{
                        var result = (l * w * h / 1000000) * tpcs;
                        calculationResultCell.textContent = result.toFixed(2); // Adjust precision as needed

                    }


                }

                // Initial calculation when the row is created
                updateCalculation();

                // Created At (Hidden)
                var createdAtCell = document.createElement('td');
                createdAtCell.style.display = 'none';
                createdAtCell.textContent = product.created_at;
                row.appendChild(createdAtCell);

                // Remarks (Hidden)
                var remarksCell = document.createElement('td');
                remarksCell.contentEditable = true;
                remarksCell.classList.add('editable-remarks');
                remarksCell.dataset.id = product.id;
                remarksCell.style.display = 'none';
                remarksCell.textContent = product.remarks;
                row.appendChild(remarksCell);


                var ctIDCell = document.createElement('td');
                ctIDCell.contentEditable = false;
                ctIDCell.classList.add('editable-ct_id');
                ctIDCell.dataset.id = product.id;
                ctIDCell.textContent = product.ct_id;
                row.appendChild(ctIDCell);



                // Other cells creation...

                var logStatusCell = document.createElement('td');
                var logStatusSelect = document.createElement('select');
                logStatusSelect.classList.add('editable-log_status');
                logStatusSelect.dataset.id = product.id;

                // Creating the default "N/A" option
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'N/A';
                logStatusSelect.appendChild(defaultOption);

                // Adding option based on product.log_status value
                var statusOption = document.createElement('option');
                statusOption.value = product.log_status;
                statusOption.textContent = product.log_status; // You may want to change this to something more descriptive
                statusOption.selected = true; // Select the option if it matches the log_status
                logStatusSelect.appendChild(statusOption);

                logStatusCell.appendChild(logStatusSelect);
                row.appendChild(logStatusCell);
                
                // lc
                var lcCell = document.createElement('td');
                var lcSelect = document.createElement('select');
                lcSelect.classList.add('editable-lc');
                lcSelect.dataset.id = product.id;

                // Creating the default "N/A" option
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'N/A';
                defaultOption.selected = product.lc == '' || product.lc == null;
                lcSelect.appendChild(defaultOption);

                // Adding option based on product.log_status value
                var clOption = document.createElement('option');
                clOption.value = product.lc;
                clOption.textContent = product.lc; // You may want to change this to something more descriptive
                clOption.selected = true; // Select the option if it matches the log_status
                lcSelect.appendChild(clOption);
                console.log("comes");
                // Creating options for lc
                var lcOptions = ['ABC14', 'ABC15', 'ABC16', 'ABC17', 'ABC18'];
                lcOptions.forEach(function(optionValue) {
                    var option = document.createElement('option');
                    option.value = optionValue;
                    option.textContent = optionValue;
                    option.selected = product.lc == optionValue;
                    lcSelect.appendChild(option);
                });

                lcCell.appendChild(lcSelect);
                row.appendChild(lcCell);


                // print
                var printCell = document.createElement('td');
                printCell.textContent = '{{ $product->print == null ? 'Not Printed' : 'Printed' }}';
                row.appendChild(printCell);

                // cost
                var costCell = document.createElement('td');
                var costSelect = document.createElement('select');
                costSelect.classList.add('editable-cost');
                costSelect.dataset.id = product.id;

                var costNoOption = document.createElement('option');
                costNoOption.value = 'No';
                costNoOption.textContent = 'No';
                costNoOption.selected = product.cost === 'No';

                var costYesOption = document.createElement('option');
                costYesOption.value = 'Yes';
                costYesOption.textContent = 'Yes';
                costYesOption.selected = product.cost === 'Yes';

                // Set option based on the value of product.cost
                if (product.cost === 'Yes') {
                    costYesOption.selected = true;
                } else {
                    costNoOption.selected = true;
                }

                costSelect.appendChild(costNoOption);
                costSelect.appendChild(costYesOption);

                costCell.appendChild(costSelect);
                row.appendChild(costCell);



                // ntf_cs
                var ntfCsCell = document.createElement('td');
                var ntfCsSelect = document.createElement('select');
                ntfCsSelect.classList.add('editable-ntf_cs');
                ntfCsSelect.dataset.id = product.id;

                var ntfCsNoOption = document.createElement('option');
                ntfCsNoOption.value = 'No';
                ntfCsNoOption.textContent = 'No';
                ntfCsNoOption.selected = product.ntf_cs === 'No' || product.ntf_cs === null;

                var ntfCsYesOption = document.createElement('option');
                ntfCsYesOption.value = 'Yes';
                ntfCsYesOption.textContent = 'Yes';
                ntfCsYesOption.selected = product.ntf_cs === 'Yes';

                // Set option based on the value of product.ntf_cs
                if (product.ntf_cs === 'Yes') {
                    ntfCsYesOption.selected = true;
                    ntfCsNoOption.removeAttribute('selected'); // Remove selected attribute from No option
                } else {
                    ntfCsNoOption.selected = true;
                    ntfCsYesOption.removeAttribute('selected'); // Remove selected attribute from Yes option
                }

                ntfCsSelect.appendChild(ntfCsNoOption);
                ntfCsSelect.appendChild(ntfCsYesOption);

                ntfCsCell.appendChild(ntfCsSelect);
                row.appendChild(ntfCsCell);


                // dbt
                var dbtCell = document.createElement('td');
                if (product.dbt === '' || product.dbt === null) {
                    var dbtButton = document.createElement('button');
                    dbtButton.classList.add('btn btn-primary editable-dbt');
                    dbtButton.dataset.id = '{{ $product->id }}';
                    dbtButton.textContent = 'Start';
                    dbtCell.appendChild(dbtButton);
                } else {
                    var dbtTime = document.createElement('p');
                    dbtTime.classList.add('dbttime');
                    dbtTime.textContent = product.dbt;
                    dbtCell.appendChild(dbtTime);
                }
                row.appendChild(dbtCell);

                // paisong_siji
                var paisongSijiCell = document.createElement('td');
                var paisongSijiSelect = document.createElement('select');
                paisongSijiSelect.classList.add('editable-paisong_siji');
                paisongSijiSelect.dataset.id = product.id;
                var paisongSijiNoOption = document.createElement('option');
                paisongSijiNoOption.value = '';
                paisongSijiNoOption.textContent = 'Not Selected';
                paisongSijiNoOption.selected = '{{ $product->paisong_siji }}' === null;
                var paisongSijiOptions = ['PAISONG SIJI 1', 'PAISONG SIJI 2', 'PAISONG SIJI 3', 'PAISONG SIJI 4'];
                paisongSijiOptions.forEach(function(optionValue, optionIndex) {
                    var option = document.createElement('option');
                    option.value = optionIndex + 1;
                    option.textContent = optionValue;
                    option.selected = '{{ $product->paisong_siji }}' === (optionIndex + 1).toString();
                    paisongSijiSelect.appendChild(option);
                });
                paisongSijiCell.appendChild(paisongSijiSelect);
                paisongSijiCell.style.display = 'none';

                row.appendChild(paisongSijiCell);

                // survey
                var surveyCell = document.createElement('td');
                var surveySelect = document.createElement('select');
                surveySelect.classList.add('editable-survey');
                surveySelect.dataset.id = product.id;
                var surveyNoOption = document.createElement('option');
                surveyNoOption.value = 'No';
                surveyNoOption.textContent = 'No';
                surveyNoOption.selected = '{{ $product->survey }}' === 'No' || '{{ $product->survey }}' ===
                    null;
                var surveyYesOption = document.createElement('option');
                surveyYesOption.value = 'Yes';
                surveyYesOption.textContent = 'Yes';
                surveyYesOption.selected = '{{ $product->survey }}' === 'Yes';
                surveySelect.appendChild(surveyNoOption);
                surveySelect.appendChild(surveyYesOption);
                surveyCell.appendChild(surveySelect);
                surveyCell.style.display = 'none';
                row.appendChild(surveyCell);

                // Hidden inputs
                var hiddenProductIDInput = document.createElement('input');
                hiddenProductIDInput.type = 'hidden';
                hiddenProductIDInput.classList.add('product-id');
                hiddenProductIDInput.value = product.id;
                var hiddenProductCodeInput = document.createElement('input');
                hiddenProductCodeInput.type = 'hidden';
                hiddenProductCodeInput.classList.add('product-code');
                hiddenProductCodeInput.value = product.product_id;
                var hiddenProductNameInput = document.createElement('input');
                hiddenProductNameInput.type = 'hidden';
                hiddenProductNameInput.classList.add('product-name');
                hiddenProductNameInput.value = product.name;
                var hiddenProductWInput = document.createElement('input');
                hiddenProductWInput.type = 'hidden';
                hiddenProductWInput.classList.add('product-w');
                hiddenProductWInput.value = product.w;
                var hiddenProductLInput = document.createElement('input');
                hiddenProductLInput.type = 'hidden';
                hiddenProductLInput.classList.add('product-l');
                hiddenProductLInput.value = product.l;
                var hiddenProductHInput = document.createElement('input');
                hiddenProductHInput.type = 'hidden';
                hiddenProductHInput.classList.add('product-h');
                hiddenProductHInput.value = product.h;
                var hiddenProductTpcsInput = document.createElement('input');
                hiddenProductTpcsInput.type = 'hidden';
                hiddenProductTpcsInput.classList.add('product-tpcs');
                hiddenProductTpcsInput.value = product.tpcs;
                var hiddenProductSkuInput = document.createElement('input');
                hiddenProductSkuInput.type = 'hidden';
                hiddenProductSkuInput.classList.add('product-sku');
                hiddenProductSkuInput.value = product.sku;
                var hiddenProductWeightInput = document.createElement('input');
                hiddenProductWeightInput.type = 'hidden';
                hiddenProductWeightInput.classList.add('product-weight');
                hiddenProductWeightInput.value = product.weight;
                var hiddenOptionInput = document.createElement('input');
                hiddenOptionInput.type = 'hidden';
                hiddenOptionInput.classList.add('option');
                hiddenOptionInput.value = product.option;
                var hiddenTypeInput = document.createElement('input');
                hiddenTypeInput.type = 'hidden';
                hiddenTypeInput.classList.add('type');
                hiddenTypeInput.value = product.type;
                var hiddenWarehouseInput = document.createElement('input');
                hiddenWarehouseInput.type = 'hidden';
                hiddenWarehouseInput.classList.add('warehouse');
                hiddenWarehouseInput.value = product.warehouse;

                row.appendChild(hiddenProductIDInput);
                row.appendChild(hiddenProductCodeInput);
                row.appendChild(hiddenProductNameInput);
                row.appendChild(hiddenProductWInput);
                row.appendChild(hiddenProductLInput);
                row.appendChild(hiddenProductHInput);
                row.appendChild(hiddenProductTpcsInput);
                row.appendChild(hiddenProductSkuInput);
                row.appendChild(hiddenProductWeightInput);
                row.appendChild(hiddenOptionInput);
                row.appendChild(hiddenTypeInput);
                row.appendChild(hiddenWarehouseInput);

                tbody.appendChild(row);
            });
        }



        // Function to get nested property value from an object
        function getNestedPropertyValue(obj, keyPath) {
            var keys = keyPath.split('.');
            var value = obj;
            for (var i = 0; i < keys.length; i++) {
                value = value[keys[i]];
                if (value === undefined || value === null) {
                    return null; // Return null if any intermediate property is undefined or null
                }
            }
            return value;
        }



        $(document).ready(function(){

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


        // Event listener for dynamically generated elements
        $(document).on('mouseenter', '.editable-log_status', function(event) {

            var description = $(this).find('option:selected').attr('data-description');
            var x = event.clientX;
            var y = event.clientY;

            console.log(x,y)
            showPopup(x, y, description);
            }).on('mouseleave', '.editable-log_status', function() {
            hidePopup();
        });
        
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




});

function fetchLogStatus(CTD_ID)
{

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'get',
        url: '/get-logs-status/' + CTD_ID,
        data: {
            remarks: CTD_ID,
            _token: csrfToken // Include the CSRF token in the data
        },
        success: function (response) {
            console.log(response);

            $('#logStatus').empty().append(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}



    </script>
@endpush
</x-app-layout>
