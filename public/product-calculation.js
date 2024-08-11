
$(document).ready(function () {
    var editingTimeout;
    calculateWeight();
});


$(document).ready(function () {
    $('.view-image').click(function () {
        var imageUrl = $(this).data('image');
        // console.log(imageUrl);
        $('.modal-image-content').attr('src', imageUrl);
    });
});


$(document).ready(function () {
    var productIdToDelete;

    // Handle click on delete link to set the product ID
    $('.delete-product').on('click', function () {
        productIdToDelete = $(this).data('product-id');
        console.log(productIdToDelete);
    });

    // Handle click on confirm delete button
    $('#confirmDelete').on('click', function () {
        if (productIdToDelete) {
            $.ajax({
                type: 'DELETE',
                url: '/products/' + productIdToDelete,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log('Product deleted successfully');
                    // window.location.reload();
                    window.location.href = '/products';
                },
                error: function (error) {
                    console.error('Error deleting product', error);
                    alert('Error deleting product. Please try again.');
                }
            });
        }

        // Close the modal after deletion
        $('#deleteConfirmationModal').modal('hide');
    });

});



function calculateWeight() {
    var rows = document.querySelectorAll('tbody.main-table tr');

    rows.forEach(function (row, index) {
        var w = parseFloat(document.getElementById('w' + index).innerText) || 0;
        var l = parseFloat(document.getElementById('l' + index).innerText) || 0;
        var h = parseFloat(document.getElementById('h' + index).innerText) || 0;
        var tpcs = parseFloat(document.getElementById('tpcs' + index).innerText) || 0;
        var result = ((w * l * h) / 1000000) * tpcs;

        var checktcube = parseFloat(document.getElementById('calculationResult' + index).innerText);
        var checktWeght = parseFloat(document.getElementById('totalWeightResult' + index).innerText);

        
        if (!checktcube) {  // Check if data is empty or null
            document.getElementById('calculationResult' + index).innerText = result.toFixed(2) || '0.0';

        } 

        if (!checktWeght) {  // Check if data is empty or null

            var weight = parseFloat(document.getElementById('weight' + index).innerText) || 0;
            var totalWeight = weight * tpcs;
            document.getElementById('totalWeightResult' + index).innerText = totalWeight || '0.0';
    ;

        } 


    });
}



function updateTotalWeight(index) {
    var weight = parseFloat(document.getElementById('weight' + index).innerText) || 0;
    var tpcs = parseFloat(document.getElementById('tpcs' + index).innerText) || 0;

    var result = weight * tpcs;
    document.getElementById('totalWeightResult' + index).innerText = result || '0.0';
}



function updateCalculation(index) {
    var w = parseFloat(document.getElementById('w' + index).innerText) || 0;
    var l = parseFloat(document.getElementById('l' + index).innerText) || 0;
    var h = parseFloat(document.getElementById('h' + index).innerText) || 0;
    var tpcs = parseFloat(document.getElementById('tpcs' + index).innerText) || 0;
    var result = ((w * l * h) / 1000000) * tpcs;
    document.getElementById('calculationResult' + index).innerText = result.toFixed(4) || '0.0';
}


function openPopup() {
    // Display the pop-up
    document.getElementById('popup').style.display = 'block';
}

function submitForm() {
    // Retrieve values from input fields
    var productId = document.getElementById('productId').value;
    var productName = document.getElementById('productName').value;
    var warehouse = document.getElementById('warehouse').value;

    // Add other variables for the remaining input fields

    // You can perform further actions with the data, such as sending it to a server or logging it
    console.log('Product ID:', productId);
    console.log('Product Name:', productName);
    console.log('Warehouse:', warehouse);

    // Close the pop-up after submission
    document.getElementById('popup').style.display = 'none';
}
