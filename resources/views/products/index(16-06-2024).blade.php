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
        <button class="btn btn-success" id="repack_product" data-toggle="modal" data-target="#repackModal" id="repack_product">Repack Product</button>
        {{-- <x-right-side-button link="{{ route('department.create') }}" title="Create"></x-right-side-button> --}}
        <x-alert></x-alert>
        <div class="container-fluid card mt-3">
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
                                <th class="d-none">Remark</th>
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
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="
        max-width: 650px;
    ">
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
                    <img width="1000px" height="1000px" src="" alt="Product Image"
                        class="img-fluid modal-image-content">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="repackModal" tabindex="-1" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog "  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Repack Product</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form id="productForm">

                        <div class="row" style="max-height: 70vh; overflow-y: scroll;">


                            <div class="col">
                                <div class="row">
                                    <div class="col mb-12">
                                        <table id="tablehead" class="table table-bordered">
                                            <tr>
                                                <th>MAITOU</th>
                                                <th>NAME</th>
                                                <th>W.HOUSE</th>
                                                <th>OPTION</th>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="productid" id="productid"></td>
                                                <td><input class="form-control" name="productname" id="productname">
                                                </td>
                                                <td><select class="form-control" id="warehouse" name="warehouse">
                                                        <option value="广州">
                                                            广州</option>
                                                        <option value="义乌">
                                                            义乌</option>
                                                        <option value="深圳">
                                                            深圳</option>
                                                    </select></td>
                                                <td><select class="form-control" name="option" id="option">
                                                        <option value="EK">EK</option>
                                                        <option value="SEA">SEA
                                                        </option>
                                                        <option value="AIR">AIR
                                                        </option>
                                                    </select></td>
                                            </tr>
                                            <tr class="theadphoto">
                                                <th>PHOTO</th>
                                                <th>PHOTO</th>
                                                <th>PHOTO</th>
                                                <th>PHOTO</th>
                                            </tr>
                                            <tr class="theadphoto">
                                                <td id="photo1"><a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal"> <img src="{{ asset('assets/images/picture.png') }}" alt="Photo 2"></a></td>
                                                <td id="photo2"><a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal"> <img src="{{ asset('assets/images/picture.png') }}" alt="Photo 2"></a></td>
                                                <td id="photo3"><a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal"> <img src="{{ asset('assets/images/picture.png') }}" alt="Photo 2"></a></td>
                                                <td id="photo4"><a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal"> <img src="{{ asset('assets/images/picture.png') }}" alt="Photo 2"></a></td>
                                            </tr>
                                            <tr>
                                                <th>L</th>
                                                <th>W</th>
                                                <th>H</th>
                                                <th>T.CUBE</th>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="l" id="l"></td>
                                                <td><input class="form-control" name="w" id="w"></td>
                                                <td><input class="form-control" name="h" id="h"></td>
                                                <td><input class="form-control" name="tcube" id="tcube"
                                                        readonly></td>
                                            </tr>
                                            <tr>
                                                <th>WEIGHT</th>
                                                <th>T.WEIGHT</th>
                                                <th>CTNS</th>
                                                <th>REMARK</th>
                                            </tr>
                                            <tr>
                                                <td><input class="form-control" name="weight" id="weight"></td>
                                                <td><input class="form-control" name="tweight" id="tweight"
                                                        readonly></td>
                                                <td><input class="form-control" name="ctns" id="ctns"></td>
                                                <td><input class="form-control" name="remarks" id="remarks"></td>
                                            </tr>
                                            <tr>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                                <th>Barcode</th>
                                            </tr>
                                        </table>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col mb-12">
                                                    <label for="remarks" class="form-label">Bill ID</label>
                                                    <input type="number" class="form-control" id="billid"
                                                        name="billid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>


                                <button type="button" class="btn btn-secondary"
                                data-dismiss="modal" aria-label="Close">

                                Close

                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script type="text/javascript" charset="utf8" src="{{ asset('product-repack2.js') }}"></script>
        <script>
            $(document).ready(function() {

                let bill_id = '{{ $bill_id }}';

                $('#dataTable').DataTable({
                    "pageLength": 50,
                    "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route("products.getProductsData") }}',
                        data: function(d) {
                        if(bill_id)
                        d.bill_id = bill_id; // Add the bill_id to the request data
                        }
                    },
                    'fnRowCallback': function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        $(nRow).find('td:last').prev('td').attr('contenteditable', true);
                        $(nRow).find('td:last').prev('td').addClass('editable-remarks');
                        $(nRow).find('td:last').prev('td').attr('data-id', $(nRow).find('td:last').find('.product-id').val());
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
                                    return '<img src="' + imageUrl + '" style="height: 50px;">';
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
                        { data: 'hidden_fields', name: 'hidden_fields'},

                    ]
                });

            });

        $(document).on('click', '.view-image', function() {
            $('#imageModal img').attr('src', '');
            var imageUrl = "{{ url('/') }}" + $(this).attr('data-image');
            $('#imageModal img').attr('src', imageUrl);
            $('#imageModal').modal('show');
        });
         $(document).ready(function () {
            $('#imageModal').on('show.bs.modal', function() {
                if( $("#repackModal").hasClass('show') ){
                    $(this).css("z-index", "1111");
                }
            });
         });
         function ABC() {
            $('#modal').modal().hide();


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
                url: '/update-remarks/' + id,
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

        </script>
    @endpush
</x-app-layout>
