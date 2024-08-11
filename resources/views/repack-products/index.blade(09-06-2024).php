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
            <div class="row card-body pb-0">
                <div class="col-lg-12 col-sm-12 col-md-12">
                <button class="btn btn-warning" id="productModalButton">Delete Product</button>
                <button class="btn btn-secondary" id="updateCtIdButton">Update CT.ID</button>
                <button class="btn btn-primary" id="printButton">Print</button>
                </div>
            </div>
            <div class="row card-body">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                        <table id="dataTable" class="table">
                          <thead>
                            <tr>
                                <th></th>
                                <th>CSDID</th>
                                <th>MAITOU</th>
                                <th>BillId</th>
                                <th>Product Name</th>
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Barcode</th>
                                <th>WareHouse</th>
                                <th>Option</th>
                                <th>Type</th>
                                <th>CTNs</th>
                                <th>Weight</th>
                                <th>Total Weight</th>
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
                          <tbody>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Delete Repack Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
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
                                data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="productModalUpdateCtId" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit CT.ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
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
                                data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="print" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Print</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
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
                                data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {

                $('#dataTable').DataTable({
                    "pageLength": 50,
                    "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("repackProductsData") }}',
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
                        { data: 'warehouse', name: 'warehouse'},
                        { data: 'option', name: 'option'},
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

            });
        </script>
    @endpush
</x-app-layout>
