$(document).ready(function () {
alert('jj')
    var selectedRows = [];
    var selectedRowsSku = [];
    $('#repack_product').on('click', function () {
        selectedRows = [];
        selectedRowsSku = [];
        selectedRows.length = 0;
        selectedRowsSku.length = 0;

        var tpcs = 0;
        var weightValue = 0;
        var tcubeValue = 0;

        var productW_Value = 0;
        var productL_Value = 0;
        var productH_Value = 0;
        var product_weight_Value = 0;

            console.log('sss');

        $('.row-checkbox:checked').each(function () {
            var productId = $(this).closest('tr').find('.product-id').val();
            console.log($(this).closest('tr'));
            var productSku = $(this).closest('tr').find('.product-sku').val();
            var productTpcs = $(this).closest('tr').find('.product-tpcs').val();
            var weight = $(this).closest('tr').find('.tweight').text();


            var productW = $(this).closest('tr').find('.product-w').val();
            var productL = $(this).closest('tr').find('.product-l').val();
            var productH = $(this).closest('tr').find('.product-h').val();
            var productweight = $(this).closest('tr').find('.product-weight').val();

            console.log(productweight,'xxxx');

            productW_Value = productW_Value + parseFloat(productW);
            productL_Value = productL_Value + parseFloat(productL);
            productH_Value = productH_Value + parseFloat(productH);
            product_weight_Value = product_weight_Value + parseFloat(productweight);




            // console.log($(this).closest('tr').find('.tweight'));
            // console.log(weight);
            var tcube = $(this).closest('tr').find('.product-tcube').text();
            tpcs = tpcs + parseInt(productTpcs);
            weightValue = weightValue + parseFloat(weight);
            tcubeValue = tcubeValue + parseFloat(tcube);
            selectedRows.push(productId);
            selectedRowsSku.push(productSku);
        });

        console.log(selectedRows);
        console.log(selectedRowsSku, '=======', selectedRows.length , weightValue);

        if (selectedRows.length > 0) {
            $('#repackModal').modal('show');
            $('.row-checkbox:checked').each(function () {
           

                var productCode = $(this).closest('tr').find('.product-code').val();
                var productName = $(this).closest('tr').find('.product-name').val();
                // var productW = $(this).closest('tr').find('.product-w').val();
                // var productL = $(this).closest('tr').find('.product-l').val();
                // var productH = $(this).closest('tr').find('.product-h').val();
                var productTpcs = $(this).closest('tr').find('.product-tpcs').val();
                var productSku = $(this).closest('tr').find('.product-sku').val();
                var weight = $(this).closest('tr').find('.product-weight').val();
                var optionValue = $(this).closest('tr').find('.option').val();
                var typeValue = $(this).closest('tr').find('.type').val();
                var warehouseValue = $(this).closest('tr').find('.warehouse').val();
                var image1Value = $(this).closest('tr').find('.image1').attr('data-image');
                var image2Value = $(this).closest('tr').find('.image2').attr('data-image');
                var image3Value = $(this).closest('tr').find('.image3').attr('data-image');
                var image4Value = $(this).closest('tr').find('.image4').attr('data-image');

                var tcubeValue = $(this).closest('tr').find('.product-tcube').text();
                var remarksValue = $(this).closest('tr').find('.editable-remarks').text().trim();


                console.log('check' , product_weight_Value);


                $('#w').val(productW_Value);
                $('#l').val(productL_Value);
                $('#h').val(productH_Value);
                $('#tcube').val(tcubeValue);
                $('#productid').val(productCode);
                $('#productname').val(productName);

                $('#wirehouse').val(warehouseValue).prop('selected', true);
                // $('#wirehouse').val(warehouseValue);
                // $('#option').val(optionValue);
                $('#option').val(optionValue).prop('selected', true);
                $('#weight').val(product_weight_Value);
                $('#ctns').val(productTpcs);
                $('#remarks').val(remarksValue);

                if (image1Value !== null && image1Value !== undefined) {
                    $('#img1').html(`<a href="#" class="view-image image1" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="${image1Value}"><img src="picture.png" alt="Photo 1"></a>`);
                }

                if (image2Value !== null && image2Value !== undefined) {
                    $('#img2').html(`<a href="#" class="view-image image2" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="${image2Value}"><img src="picture.png" alt="Photo 2"></a>`);
                }

                if (image3Value !== null && image3Value !== undefined) {
                    $('#img3').html(`<a href="#" class="view-image image3" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="${image3Value}"><img src="picture.png" alt="Photo 3"></a>`);
                }

                if (image4Value !== null && image4Value !== undefined) {
                    $('#img4').html(`<a href="#" class="view-image image4" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="${image4Value}"><img src="picture.png" alt="Photo 4"></a>`);
                }
                return false;
            });

            if (selectedRows.length > 1) {
                //fiverr freelancer to enable weight lenght and height . to show tcube and tweight in repack product
                // $('#w').val("");
                // $('#l').val("");
                // $('#h').val("");
                $('#weight').val(product_weight_Value);

                $('#tcube').val(tcubeValue.toFixed(4));
                $('#tweight').val(weightValue.toFixed(4));
                $('#ctns').val(tpcs);
                $('#tablehead .theadphoto').hide(); // Hide the elements with the class "theadphoto"
            } else {
                $('#tablehead .theadphoto').show();

                calculateTotalCube();
                calculateTotalWeight();
            }

            $('#tablehead .dynamic').remove();
            selectedRowsSku.forEach(function (item, index) {
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


    $("#productForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formDataObject = {};

        // Iterate over each form field and add it to formDataObject
        $("#productForm :input").each(function () {
            var name = $(this).attr("name");
            var value = $(this).val();
            formDataObject[name] = value;
        });

        // Add selectedRows and selectedRowsSku to formDataObject
        formDataObject.selectedRows = selectedRows;
        formDataObject.selectedRowsSku = selectedRowsSku;

        // Add CSRF token
        formDataObject._token = $('meta[name="csrf-token"]').attr('content');

        console.log(formDataObject);
        console.log(formDataObject.billid);


        $.ajax({
            type: 'POST',
            url: '/add-to-repack',
            data: formDataObject,
            success: function (response) {
                $('#repackModal').modal('hide');
                console.log('Repack successfully');
                // window.location.reload();
                $('.row-checkbox:checked').each(function () {
                    var pbillid = $(this).closest('tr').find('.pbillid');
                    pbillid.text(formDataObject.billid)
                });

                alert('Repack successfully');
                location.reload();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.error('Error repacking selected rows', textStatus, errorThrown);

                // alert('Error repacking selected rows. Please try again.');
                if (xhr.status === 406) {
                    // Handle specific error message for 406 status code
                    alert(xhr.responseJSON.message);
                } else {
                    // Default error message for other status codes
                    alert('Error repacking selected rows. Please try again.');
                }
            }
        });
    });

    function calculateTotalCube() {
        var w = parseFloat($('#w').val()) || 0;
        var l = parseFloat($('#l').val()) || 0;
        var h = parseFloat($('#h').val()) || 0;
        var tpcs = parseFloat($('#ctns').val()) || 0;
        var result = ((w * l * h) / 1000000) * tpcs;
        $('#tcube').val(result.toFixed(4));
    }

    // Function to calculate the total weight
    function calculateTotalWeight() {
        var weight = parseFloat($('#weight').val()) || 0;
        var tpcs = parseFloat($('#ctns').val()) || 0;
        var totalWeight = weight * tpcs;
        $('#tweight').val(totalWeight.toFixed(4));
    }


    $('#w, #l, #h, #ctns, #weight').on('input', function () {
        calculateTotalCube();
        calculateTotalWeight();
    });

});



