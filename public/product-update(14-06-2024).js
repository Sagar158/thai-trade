$(document).ready(function () {
    var editingTimeout;
    var originalContent;

    // Handle contenteditable field focus and blur events
    $('.editable-remarks').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            console.log("Finish Editing ");

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
                    alert("Error saving data please try again");
                }
            });
            // }, 1500); // Adjust the timeout duration as needed
        }
    });


    // For W
    // Handle contenteditable field focus and blur events
    $('.editable-w').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-w/' + id,
                data: {
                    w: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });

    // FOR L
    // Handle contenteditable field focus and blur events
    $('.editable-l').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-l/' + id,
                data: {
                    l: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });


    // FOR H
    // Handle contenteditable field focus and blur events
    $('.editable-h').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-h/' + id,
                data: {
                    h: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });


    // FOR tpcs
    // Handle contenteditable field focus and blur events
    $('.editable-tpcs').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-tpcs/' + id,
                data: {
                    tpcs: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });


    // FOR weight
    // Handle contenteditable field focus and blur events
    $('.editable-weight').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-weight/' + id,
                data: {
                    weight: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });

    // FOR Product id
    // Handle contenteditable field focus and blur events
    $('.editable-product-id').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }

            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-product-id/' + id,
                data: {
                    product_id: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    window.location.reload();
                    // $this.removeClass('editing');
                    // calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });


    // FOR Product iname
    // Handle contenteditable field focus and blur events
    $('.editable-product-name').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }
            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-product-name/' + id,
                data: {
                    name: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });

    // FOR Product CS DID
    // Handle contenteditable field focus and blur events
    $('.editable-cs-did').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var $this = $(this);
            if ($this.text().trim() === originalContent) {
                return;
            }
            $(this).addClass('editing');;
            // console.log("Finish Editing ");
            var id = $this.data('id');
            var value = $this.text();

            // Get the CSRF token value from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'PATCH',
                url: '/update-product-csdid/' + id,
                data: {
                    cs_did: value,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function (response) {
                    $this.removeClass('editing');
                    calculateWeight();
                },
                error: function (error) {
                    console.log(error);
                    alert("Error saving data please try again");
                }
            });
        }
    });

});
