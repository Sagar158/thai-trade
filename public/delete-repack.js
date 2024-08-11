$(document).ready(function () {

    var selectedRows = [];
    var selectedRowsSku = [];
    $('#productModalButton').on('click', function () {
        selectedRows = [];
        selectedRowsSku = [];
        selectedRowsSkuShow = [];
        selectedRows.length = 0;
        selectedRowsSku.length = 0;
        selectedRowsSkuShow.length = 0;

        // Iterate over each checked checkbox and store the associated product ID
        $('.row-checkbox:checked').each(function () {
            var productId = $(this).closest('tr').find('.product-id').val();
            var productSku = $(this).closest('tr').find('.product-sku').val();
            var productProduct = $(this).closest('tr').find('.products').val();
            var productProductVal = productProduct.split(',');
            console.log(productProductVal);
            selectedRows.push(productId);
            selectedRowsSku.push(productSku);
            productProductVal.forEach(function (item, index) {
                selectedRowsSkuShow.push(item);
            });
        });


        if (selectedRows.length > 0) {
            $('#productModal').modal('show');
            $('#tablehead .dynamic').remove();
            selectedRowsSkuShow.forEach(function (item, index) {
                var colIndex = index % 4;
                if (colIndex === 0) {
                    $('#tablehead').append('<tr class="dynamic"></tr>');
                }
                $('#tablehead tr:last-child').append('<td>' + item + '</td>');
            });

        } else {
            alert('No rows selected for deletion.');
        }
    });




    $('#updateCtIdButton').on('click', function () {
        selectedRows = [];
        selectedRowsSku = [];
        selectedRowsSkuShow = [];
        selectedRows.length = 0;
        selectedRowsSku.length = 0;
        selectedRowsSkuShow.length = 0;

        // Iterate over each checked checkbox and store the associated product ID
        $('.row-checkbox:checked').each(function () {
            var productId = $(this).closest('tr').find('.product-id').val();
            var productSku = $(this).closest('tr').find('.product-sku').val();
            var productProduct = $(this).closest('tr').find('.products').val();
            var productProductVal = productProduct.split(',');
            console.log(productProductVal);
            selectedRows.push(productId);
            selectedRowsSku.push(productSku);
            productProductVal.forEach(function (item, index) {
                selectedRowsSkuShow.push(item);
            });
        });


        if (selectedRows.length > 0) {
            $('#productModalUpdateCtId').modal('show');
            $('#thead .dynamic').remove();
            selectedRowsSkuShow.forEach(function (item, index) {
                var colIndex = index % 4;
                if (colIndex === 0) {
                    $('#thead').append('<tr class="dynamic"></tr>');
                }
                $('#thead tr:last-child').append('<td>' + item + '</td>');
            });

        } else {
            alert('No rows selected for deletion.');
        }
    });



    $("#productModalUpdateCtId").submit(function (event) {
        event.preventDefault();
        var formDataObject = {};
        $("#productFormUpdateCtId :input").each(function () {
            var name = $(this).attr("name");
            var value = $(this).val();
            formDataObject[name] = value;
        });
        formDataObject.selectedRows = selectedRows;
        formDataObject.selectedRowsSku = selectedRowsSku;

        // Add CSRF token
        formDataObject._token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/update-bulk-ctid',
            data: formDataObject,
            success: function (response) {
                $('#productModal').modal('hide');
                console.log('Update successfully');
                alert('Update successfully');
                window.location.reload();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error repacking selected rows', textStatus, errorThrown);
                if (xhr.status === 406) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Error updating selected rows. Please try again.');
                }
            }
        });
    });



    $("#productForm").submit(function (event) {
        event.preventDefault();
        var formDataObject = {};
        formDataObject.selectedRows = selectedRows;
        formDataObject.selectedRowsSku = selectedRowsSku;

        // Add CSRF token
        formDataObject._token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/delete-from-repack',
            data: formDataObject,
            success: function (response) {
                $('#productModal').modal('hide');
                console.log('Delete successfully');
                alert('Delete Repack successfully');
                window.location.reload();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error repacking selected rows', textStatus, errorThrown);
                if (xhr.status === 406) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Error deleting selected rows. Please try again.');
                }
            }
        });
    });

});



