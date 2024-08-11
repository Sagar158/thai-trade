<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <img width="800px" height="800px" src="" alt="Product Image"
                    class="img-fluid modal-image-content">
            </div>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog custom-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Repack Product</h5>
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
                                            <th>MAITOU</th>
                                            <th>NAME</th>
                                            <th>W.H</th>
                                            <th>BY</th>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" name="productid" id="productid"></td>
                                            <td><input class="form-control" name="productname" id="productname">
                                            </td>
                                            <td><select class="form-control" id="wirehouse" name="wirehouse">
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
                                                    <option value="TGC">AIR
                                                    </option>
                                                </select></td>
                                        </tr>
                                        <tr class="theadphoto">
                                            <th>P.</th>
                                            <th>P.</th>
                                            <th>P.</th>
                                            <th>P.</th>
                                        </tr>
                                        <tr class="theadphoto">
                                            <td id="img1"></td>
                                            <td id="img2"></td>
                                            <td id="img3"></td>
                                            <td id="img4"></td>
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
                                            <th>W.T</th>
                                            <th>T.W.T</th>
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
                        <button type="button" class="btn btn-secondary" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
