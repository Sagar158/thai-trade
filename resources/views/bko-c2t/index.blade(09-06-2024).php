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
        <x-page-heading title="{{ __('CKW-C2T Product Information') }}"></x-page-heading>
        <x-alert></x-alert>

        <div class="container-fluid card mt-3">
            <div class="row card-body pb-0">
                <div class="col-lg-12 col-sm-12 col-md-12">
            <button class="btn btn-warning" id="productModalButton">Delete Product</button>
                <button class="btn btn-secondary" id="updateCtIdButton">Update CT.ID</button>
                <button class="btn btn-primary" id="printButton">Print</button>
                </div>
            </div>
            <div class="row pt-0">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <form action="{{ route('ctid_lc_change') }}" method="post" class="d-flex justify-content-start mt-2">
                        @csrf
                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <x-select-box id="ci_id" name="ci_id" :value="old('ci_id')" :values="$ct_ids" autocomplete="off" placeholder="CTD ID" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <x-select-box id="logStatus" name="logStatus" :value="old('logStatus')" :values="$logStatus" autocomplete="off" placeholder="Log Status" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <x-select-box id="lc_new" name="lc_new" :value="old('lc_new')" :values="$lcs" autocomplete="off" placeholder="LC" />
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <button class="btn btn-primary mt-4" type="submit">Update</button>
                                    {{--<button class="btn btn-secondary mt-4">Reset</button>--}}
                                </div>
                            </div>
                        </div>
                        </form>
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
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Photo</th>
                                <th>Barcode</th>
                                <th>WareHouse</th>
                                <th>Type</th>
                                <th>CTNs</th>
                                <th>Total Weight</th>
                                <th>L</th>
                                <th>W</th>
                                <th>H</th>
                                <th>T.Cube</th>
                                <th>Date/Time</th>
                                <th>Remark</th>
                                <th>CT ID</th>
                                <th>Log Status</th>
                                <th>Print</th>
                                <th>Cost</th>
                                <th>NTF.CS</th>
                                <th>Survey</th>
                                <th class="d-none">Hiddens</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
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
                ajax: '{{ route("CKW_C2T.data") }}',
                columns: [
                    { data: 'checkbox', name: 'checkbox' },
                    { data: 'csd_id', name: 'csd_id' },
                    { data: 'maitou', name: 'maitou' },
                    { data: 'bill_id', name: 'bill_id'},
                    { data: 'photo1', name: 'photo1'},
                    { data: 'photo2', name: 'photo2'},
                    { data: 'photo3', name: 'photo3'},
                    { data: 'photo4', name: 'photo4'},
                    { data: 'sku', name: 'sku'},
                    { data: 'warehouse', name: 'warehouse'},
                    { data: 'type', name: 'type'},
                    { data: 'tpcs', name: 'tpcs'},
                    { data: 'total_weight', name: 'total_weight'},
                    { data: 'length', name: 'length'},
                    { data: 'width', name: 'width'},
                    { data: 'height', name: 'height'},
                    { data: 't_cube', name: 't_cube'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'remarks', name: 'remarks'},
                    { data: 'ct_id', name: 'ct_id'},
                    { data: 'log_status', name: 'log_status'},
                    { data: 'print', name: 'print'},
                    { data: 'cost', name: 'cost'},
                    { data: 'ntf_cs', name: 'ntf_cs'},
                    { data: 'survey', name: 'survey'},
                    { data: 'hidden_fields', name: 'hidden_fields'}
                ]
            });

        });
        $(document).on('click', '.view-image', function() {
            $('#imageModal img').attr('src', '');
            var imageUrl = "{{ url('/') }}" + $(this).attr('data-image');
            $('#imageModal img').attr('src', imageUrl);
            $('#imageModal').modal('show');
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
    </script>
@endpush
</x-app-layout>
