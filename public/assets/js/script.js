$(document).ready(function() {
    let currentStep = 0;
    const steps = $('.step');

    $(document).on('click','#importModal',function() {
        getLists();
    });



    $(document).on('click','#deleteListBtn',function(e) {
        e.preventDefault();
        const id = $('#listId').val();
        // Create a FormData object
        const formData = new FormData();
        formData.append('id', id);
        // Send the AJAX request
        $.ajax({
            url: '/actions/deleteList.php', // Backend script to handle the file upload
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                // Handle the response from the server
                $('#deleteListModal').modal('hide');
                $('.list-group').find('#item-' + id).addClass('list-group-item-danger').fadeOut('slow',function (){
                    getLists();
                });
            },
            error: function () {
                $('#message').html('Error occurred while uploading the file.');
            }
        });


    });

    $(document).on('click','.delete',function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $('#listId').val(id);
        const currentTitle = $('.list-group').find('#item-' + id).text();
        $('#listTitle').html(currentTitle);

        $('#deleteListModal').modal('show');
    });

    $(document).on('click','.form-check-input',function() {
        const form = $('#importList')
        const checkboxes = form.find('input[type="checkbox"]');
        // Check if any checkbox is checked
        const isChecked = checkboxes.is(':checked');
        if (isChecked) {
            $('#listCheckbox').hide();
        }else{
            $('#listCheckbox').show();
        }


    });
    $(document).on('click','.edit',function() {
        alert('edit')
    });
    function showStep(index) {
        steps.removeClass('active').eq(index).addClass('active');
    }

    $(document).on('blur', '#title',function() {
        validateTitle();
    });

    $(document).on('keyup', '#title',function() {
        validateTitle();
    });

    $(document).on('keyup', '#msisdn',function() {
        validateMsisdn();
    });

    $(document).on('blur', '#msisdn',function() {
        validateMsisdn();
    });

    $(document).on('blur', '#date',function() {
        validateDate();
    });

    function validateTitle() {
        let $title = $('#title');
        const title = $title.val();
        if (title !== '') {
            $title
                .removeClass('is-invalid')
                .addClass('is-valid');
        } else {
            $title.removeClass('is-valid')
                .addClass('is-invalid');
        }
    }

    function validateMsisdn() {
        const $msisdn = $('#msisdn');
        const msisdn = $msisdn.val();
        if (msisdn !== '') {
            $msisdn
                .removeClass('is-invalid')
                .addClass('is-valid');
        } else {
            $msisdn.removeClass('is-valid')
                .addClass('is-invalid');
        }
    }

    function validateFile() {
        const $csvFile = $('#csvFile');
        const csvFile = $csvFile.val();
        if (csvFile !== '') {
            $csvFile
                .removeClass('is-invalid')
                .addClass('is-valid');
        } else {
            $csvFile.removeClass('is-valid')
                .addClass('is-invalid');
        }
    }
    function validateDate() {
        const $date = $('#date');
        const dateStr = $date.val();

        if (dateStr !== '') {
            const inputDate = new Date(dateStr);
            const today = new Date();

            today.setHours(0, 0, 0, 0);

            if (inputDate >= today) {
                $date.removeClass('is-invalid').addClass('is-valid');
                $('#dateErrorMsg').hide();

            } else {
                $date.removeClass('is-valid').addClass('is-invalid');
                $('#dateErrorMsg').html("The selected date is in the past. Please choose a date from today onwards.");
            }
        } else {
            $date.removeClass('is-valid').addClass('is-invalid');
        }
    }

    function checkDates(){
        $('#importFormFile').submit();
    }


    $(document).on('click','#nextToDate',function() {
        validateFile();
        const $csvFile = $('#csvFile');
        if (!$csvFile.hasClass('is_invalid')) {
            checkDates();

        }
    });

    $(document).on('change','#csvFile',function() {
        validateFile();
    });

    $(document).on('click','#backToFile',function() {
        currentStep--;
        showStep(currentStep);
    });

    showStep(currentStep);

    $('#importFormFile').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting the traditional way
        // Create a FormData object
        const formData = new FormData(this);

        // Send the AJAX request
        $.ajax({
            url: '/actions/multi_go.php', // Backend script to handle the file upload
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#dateErrorMsg').hide();
                // Handle the response from the server
                if(JSON.parse(response).error === 1){
                    let date = formData.get('date');
                    if(!date){
                        currentStep++;
                        showStep(currentStep);
                    }
                    $('#dateErrorMsg').html(JSON.parse(response).message + ' In lines ' + JSON.parse(response).rows + ' Please check and modify the file and upload again').show();

                }else{
                    $('#uploadModal').modal('toggle');
                    $('#successMessage').html('The CSV file imported successfully.');
                    $('#successAlert').removeClass('visually-hidden')
                }


            },
            error: function () {
                $('#message').html('Error occurred while uploading the file.');
            }
        });
    });

$(document).on('submit','#importList', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const checkboxes = $(this).find('input[type="checkbox"]');
        // Check if any checkbox is checked
        const isChecked = checkboxes.is(':checked');
        if(isChecked){
            $.ajax({
                url: '/actions/multi_go.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#uploadModal").modal('toggle');
                    $('#successMessage').html('The lists imported successfully.');
                    $('#successAlert').removeClass('visually-hidden')
                },
                error: function () {
                    $('#message').html('Error occurred while importing the file.');
                }
            });
        }else{
            $('#listCheckbox').show();
        }

    });
$(document).on('submit','#addList', function (e) {
    e.preventDefault();
    validateTitle();
    validateMsisdn();
    // Create a FormData object
    const formData = new FormData($(this)[0]);

    // Send the AJAX request
    $.ajax({
        url: '/actions/addList.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Handle the response from the server
            $('#addListModal').modal('toggle');
            $('#importModal').click();
            $('#addList').find('input, textarea').val('');
            $('#msisdn').removeClass('is-valid');
            $('#title').removeClass('is-valid');
        },
        error: function () {
            $('#message').html('Error occurred while uploading the file.');
        }
    });
});
    function getLists(){
        // Send the AJAX request
        $.ajax({
            url: '/actions/getLists.php',
            type: 'POST',
            contentType: false,
            processData: false,
            success: function (response) {
                // Handle the response from the server
                $('#listData').html(response);
            },
            error: function () {
                $('#message').html('Error occurred while creating the list.');
            }
        });
    }
});