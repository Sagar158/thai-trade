$(document).ready(function () {

    var selectedRows = [];
    var selectedRowsSku = [];

    $('#printButton').on('click', function () {
        selectedRows = [];
        selectedRowsSku = [];
        selectedRowsSkuShow = [];
        selectedRows.length = 0;
        selectedRowsSku.length = 0;
        selectedRowsSkuShow.length = 0;


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

        // if (selectedRows.length > 6) {
        //     alert("Can't select more then 6 row");
        //     return
        // }

        if (selectedRows.length > 0) {
            $('#print').modal('show');
            $('#thead-print .dynamic').remove();
            selectedRowsSkuShow.forEach(function (item, index) {
                var colIndex = index % 4;
                if (colIndex === 0) {
                    $('#thead-print').append('<tr class="dynamic"></tr>');
                }
                $('#thead-print tr:last-child').append('<td>' + item + '</td>');
            });

        } else {
            alert('No rows selected for deletion.');
        }
    });


    $("#productPrintRequest").submit(function (event) {
        event.preventDefault();
        var formDataObject = {};
        formDataObject.selectedRows = selectedRows;
        formDataObject.selectedRowsSku = selectedRowsSku;

        // Add CSRF token
        formDataObject._token = $('meta[name="csrf-token"]').attr('content');

        console.log(formDataObject);

        $.ajax({
            type: 'GET',
            url: '/generate-invoices',
            data: formDataObject,
            success: async function (response) {
                $('#print').modal('hide');
                // console.log('Delete successfully');
                // alert('Delete Repack successfully');
                // window.location.reload();
                // console.log(response)
                var newWindow = window.open('', '_blank');

                // Set the paper size to A5
                newWindow.document.body.style.width = "148mm"; // A5 width
                newWindow.document.body.style.height = "210mm"; // A5 height

                newWindow.document.open();
                newWindow.document.write(response);


                // newWindow.document.close();

                await new Promise(r => setTimeout(r, 2000));

                newWindow.print();
                // newWindow.close();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error repacking selected rows', textStatus, errorThrown);
                if (xhr.status === 406) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Please try again.');
                }
            }
        });
    });


});



