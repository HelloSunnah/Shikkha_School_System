<script>
    let feesTypeCreate = (e) => {
        e.preventDefault();

        $.ajax({
            url: "{{route('school.finance.schoolFees.create')}}",
            type: "POST",
            data: $("#feesTypeCreate").serialize(),
            beforeSend: () => {
                 $("#feesTypeCreateBtn").html(`
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>Creating...
                 `);
            },
            success: (resp) => {
                $("#feesTypeCreateBtn").html('Create');
                $("#newSchoolFees").modal('hide');
                loadClassFees('{{$classes->first()->id}}');
                toastr.success("Record created successfully");
            },
            error: (error) => {
                $("#feesTypeCreateBtn").html('Create');

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }

    let deleteFeesType = (feesTypeId, classId) => {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7100A7',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('school.finance.schoolFees.destroy')}}",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        feesTypeId: feesTypeId
                    },
                    beforeSend: () => {
                        $("#delete_row_"+feesTypeId).html(`
                            <span class="spinner-border spinner-border-sm text-warning" role="status"></span>Deleting...
                        `); 
                    },
                    success: (resp) => {
                        $("#delete_row_"+feesTypeId).html(`<i class="fa fa-trash-alt"></i>`); 
                        loadClassFees(classId);
                    },
                    error: (error) => {
                        $("#delete_row_"+feesTypeId).html(`<i class="fa fa-trash-alt"></i>`); 
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: error.responseJSON.message,
                        });
                    }
                });
            }
        })
    }

    /*  ---------   Class Fees
    ====================================================*/
    let loadClassFees = (classId) => {

        $.ajax({
            url: "{{url()->current()}}",
            type: "GET",
            data: {
                classId: classId
            },
            beforeSend: () => {
                $("#schoolFeesTBody").html(`
                    <tr class="text-center">
                        <td colspan="3">
                            <div class="spinner-border text-warning" role="status"></div><br>Loading...
                        </td>
                    </tr>
                `); 
            },
            success: (resp) => {
                var $html = ``;
                
                resp.data.forEach((element, index) => {
                    $("#classTitle").html(element['class_name']);
                    $html += `<tr>
                                <td>
                                    <span class="cursor-pointer" id="delete_row_${element['fees_type_id']}" onclick="deleteFeesType(${element['fees_type_id']}, ${classId})" title="Delete This Item"> <i class="fa fa-trash-alt"></i> </span>
                                </td>
                                <td>
                                    <h6>${element['title']}</h6>
                                    <input type="hidden" name="feesId[]" value="${element['id']}">
                                    <input type="hidden" name="classId" value="${classId}">
                                </td>
                                <td>
                                    <input type="number" onchange="storeClassFees(event)" class="form-control text-end" name="fees[]" min="0" value="${element['fees']}">
                                </td>
                            </tr>`;
                });

                $("#schoolFeesTBody").html($html); 

            },
            error: (error) => {
                console.log(error.responseJSON.message);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        })
    }

    /*  ---------  Init Class Fees
    ====================================================*/
    loadClassFees('{{$classes->first()->id}}');


    /*  ---------   Store Class Fees
    ====================================================*/
    storeClassFees = (event) => {
        event.preventDefault();
        
        $.ajax({
            url: "{{route('school.finance.schoolFees.store')}}",
            type: "POST",
            data: $("#schoolFeesForm").serialize(),
            beforeSend: () => {
                 $("#storeClassFeesBtn").attr('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>Saving...
                 `);
            },
            success: (resp) => {
                $("#storeClassFeesBtn").attr('disabled', false).html('Save Changes');
                toastr.success("Record save successfully");
            },
            error: (error) => {
                $("#storeClassFeesBtn").attr('disabled', false).html('Save Changes');

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        });

    }
</script>