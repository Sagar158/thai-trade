$(document).ready(function () {

    var selectedRows = [];
    var selectedRowsSku = [];
    var selectedRowsSkuShow = [];
    var alreadyPrinted = false;  // Track if the data has been printed already

    $('#printButton').on('click', function () {
        selectedRows = [];
        selectedRowsSku = [];
        selectedRowsSkuShow = [];

        $('.row-checkbox:checked').each(function () {
            var productId = $(this).closest('tr').find('.product-id').val();
            var productSku = $(this).closest('tr').find('.product-sku').val();
            var productProduct = $(this).closest('tr').find('.products').val();
            var productProductVal = productProduct.split(',');
            console.log(productProductVal);
            selectedRows.push(productId);
            selectedRowsSku.push(productSku);
            productProductVal.forEach(function (item) {
                selectedRowsSkuShow.push(item);
            });
        });

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

            // Set the alreadyPrinted flag to true to show confirmation if reprinting
            alreadyPrinted = true;
        } else {
            alert('No rows selected for printing.');
        }
    });

    $("#productPrintRequest").submit(function (event) {
        event.preventDefault();
    
        // Show confirmation dialog if the data has been printed already
        if (alreadyPrinted && !confirm("Are you sure you want to print this again?")) {
            return;
        }
    
        var formDataObject = {
            selectedRows: selectedRows,
            selectedRowsSku: selectedRowsSku,
            _token: $('meta[name="csrf-token"]').attr('content')
        };
    
        console.log(formDataObject);
    
        $.ajax({
            type: 'GET',
            url: '/generate-invoices',
            data: formDataObject,
            success: async function (response) {
                $('#print').modal('hide');
                var newWindow = window.open('', '_blank');
    
                newWindow.document.open();
                newWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Preview</title>
                        <style>
                            @media print {
                                body {
                                    margin: 0;
                                    padding: 0;
                                }
                                .page-break {
                                    page-break-before: always;
                                    page-break-after: always;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        ${response.split('<!-- page-break -->').map((bill, index) => `
                            <div class="page-break">
                                ${bill}
                            </div>
                        `).join('')}
                    </body>
                    </html>
                `);
    
                await new Promise(r => setTimeout(r, 2000));
    
                newWindow.print();
                newWindow.close();
    
                // Reset flag after successful print
                alreadyPrinted = false;
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error printing selected rows', textStatus, errorThrown);
                if (xhr.status === 406) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Please try again.');
                }
            }
        });
    });
    

});
