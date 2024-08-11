$(document).ready(function () {



       $(document).on('change','select', function() {
            var classNames = $(this).attr('class'); 
            var attributeName = '';
            
            if(classNames == 'editable-survey')
            {
                attributeName = 'survey';
            }
            else if(classNames == 'editable-ntf_cs')
            {
                attributeName = 'ntf_cs';
            }
            else if(classNames == 'editable-cost')
            {
                attributeName = 'cost';
            }
            else if(classNames == 'editable-paisong_siji')
            {
                attributeName = 'paisong_siji';
            }
            else if(classNames == 'editable-log_status')
            {
                attributeName = 'log_status';
            }
            else if(classNames == 'editable-lc')
            {
                attributeName = 'lc';
            }
            
            if(attributeName != '')
            {
                var newValue = $(this).val();
                var productId = $(this).data('id');
    
                callAPI($(this), productId, attributeName, newValue);
            }

    
        });
        
        // handleAttributeChange('editable-survey', 'survey');
        // handleAttributeChange('editable-ntf_cs', 'ntf_cs');
        // handleAttributeChange('editable-cost', 'cost');
        // handleAttributeChange('editable-paisong_siji', 'paisong_siji');
        // handleAttributeChange('editable-log_status', 'log_status');
        // handleAttributeChange('editable-lc', 'lc');
    });


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

            $(this).addClass('editing');
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
                url: base_url+'/update-repack-remarks/' + id,
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
                url: base_url+'/update-repack-weight/' + id,
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
                url: base_url+'/update-repack-product-id/' + id,
                data: {
                    product_id: value,
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
                url: base_url+'/update-repack-product-name/' + id,
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




    // MAIN UPDATE CALL
    function handleEditableFieldBlur($element, attribute) {
        if ($element.text().trim() === originalContent) {
            return;
        }

        $element.addClass('editing');
        var id = $element.data('id');
        var value = $element.text().trim();

        callAPI($element, id, attribute, value);
    }


    function callAPI($element, id, attribute, value) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var requestData = {};
        requestData[attribute] = value;
        requestData['_token'] = csrfToken;

        var url = '/repacks/' + id + '/' + attribute;
        // console.log(url);

        // console.log(requestData);

        $.ajax({
            type: 'POST',
            url: base_url+url,
            data: requestData,
            success: function (response) {
                if (attribute == "log_status" && (value == 7 || value == 14 || value == 9 || value == 18)) {
                    window.location.reload();
                }
                $element.removeClass('editing');
                calculateWeight();
            },
            error: function (error) {
                console.log(error);
                alert("Error saving data please try again");
            }
        });
    }


    $('.editable-w, .editable-l, .editable-h, .editable-tpcs, .editable-ct_id, .editable-lc, .editable-print, .editable-cost, .editable-dbt, .editable-paisong_siji').on({
        focus: function () {
            originalContent = $(this).text().trim();
        },
        blur: function () {
            var attribute;
            if ($(this).hasClass('editable-w')) {
                attribute = 'w';
            } else if ($(this).hasClass('editable-l')) {
                attribute = 'l';
            } else if ($(this).hasClass('editable-h')) {
                attribute = 'h';
            } else if ($(this).hasClass('editable-ct_id')) {
                attribute = 'ct_id';
            }
            // else if ($(this).hasClass('editable-log_status')) {
            //     attribute = 'log_status';
            // }
            // else if ($(this).hasClass('editable-lc')) {
            //     attribute = 'lc';
            // }
            else if ($(this).hasClass('editable-print')) {
                attribute = 'print';
            }
            // else if ($(this).hasClass('editable-cost')) {
            //     attribute = 'cost';
            // }
            else if ($(this).hasClass('editable-dbt')) {
                attribute = 'dbt';
            }
            //  else if ($(this).hasClass('editable-ntf_cs')) {
            //     attribute = 'ntf_cs';
            // }
            // else if ($(this).hasClass('editable-paisong_siji')) {
            //     attribute = 'paisong_siji';
            // }
            //  else if ($(this).hasClass('editable-survey')) {
            //     attribute = 'survey';
            // }
            else if ($(this).hasClass('editable-tpcs')) {
                attribute = 'tpcs';
            } else {
                attribute = '';
            }
            handleEditableFieldBlur($(this), attribute);
        }
    });


    function handleAttributeChange(className, attributeName) {
        $('.' + className).on('change', function () {
            var newValue = $(this).val();
            var productId = $(this).closest('.' + className).data('id');
            callAPI($(this), productId, attributeName, newValue);
        });
    }

    handleAttributeChange('editable-survey', 'survey');
    handleAttributeChange('editable-ntf_cs', 'ntf_cs');
    handleAttributeChange('editable-cost', 'cost');
    handleAttributeChange('editable-paisong_siji', 'paisong_siji');
    handleAttributeChange('editable-log_status', 'log_status');
    handleAttributeChange('editable-lc', 'lc');






    $(document).on('click', '.editable-dbt', function () {
        var id = $(this).data('id');
        var $button = $(this);
        var attribute = "dbt";

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        var requestData = {};
        requestData[attribute] = "";
        requestData['_token'] = csrfToken;

        var url = '/repacks/' + id + '/' + attribute;
        $.ajax({
            type: 'POST',
            url: base_url+url,
            data: requestData,
            success: function (response) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
                alert("Error saving data please try again");
            }
        });
    });



    // handle file upload
    function handleImageUpload(id, attribute, td) {
        var fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.accept = 'image/*';

        fileInput.onchange = function () {
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append(attribute, file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            var url = '/repacks/' + id + '/' + attribute;
            $.ajax({
                type: 'POST',
                url: base_url+url,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    var imageUrl = response.image;
                    // var content = `<a href="#" class="view-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="/storage/${imageUrl}"><img src="picture.png" alt="Photo 1"></a>`;
                    var content = `<a href="#" class="view-image"><img src="check.png" alt="Photo 1"></a>`;
                    td.html(content);
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                    alert("Error uploading image, please try again");
                }
            });
        };

        fileInput.click();
    }


    $(document).on('click', '.upload-image',function () {
        var attribute = $(this).data('attribute');
        var id = $(this).data('id');
        var td = $(this).closest('td');
        handleImageUpload(id, attribute, td);

    });
