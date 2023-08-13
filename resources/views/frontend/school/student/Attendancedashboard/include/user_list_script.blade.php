<script>

    window.onload = () => {
        updateDeviceConnectedUsers();
    }

    /** -------------   Update connected Users
     * =================================================== **/
    const updateDeviceConnectedUsers = () => {
        $("#loader").modal('show');

        $.ajax({
            url: "/v2/update/device-conected-users",
            type: "POST",
            data: {
                "_token": "{{csrf_token()}}",
            },
            beforeSend: () => {
                $("#loader").modal('show');
            },
            success: (resp) => {
                $("#loader").modal('hide');
                console.log(resp);
                initDataTable();
            },
            error: (error) => {
                $("#loader").modal('hide');
                initDataTable();
                console.log(error.responseJSON.message);
            }
        });
    }


    
    /** -------------   Load Data table
     * =================================================== **/
    let loadDataTable = (data) => {
        let users = ``;
        var connectedUser = 0;
        var totalUser = data.length;
        var connectedArray = [];
        var disConnectedArray = [];

        if(data.length > 0)
        {
            data.forEach((item, index) => {
                let shift = "";
                let connected = `<span class="badge bg-danger text-uppercase">NONE</span>`;

                if(item['shift'] == 1)
                {
                    shift = "Morning";
                }
                else if(item['shift'] == 2)
                {
                    shift = "Day";
                }
                else if(item['shift'] == 3)
                {
                    shift = "Evening";
                }

                if(item['device_connected'])
                {
                    ++connectedUser;
                    connected = '<span class="badge bg-success text-uppercase">connected</span>'
                }
                else
                {
                    connectedArray.push()
                }
                
                users += `<tr>
                        <td>${item['roll_number']}</td>
                        <td>
                            <div class="d-flex gap-3 align-items-center">
                                <img src="/${item['image']}" alt="${item['name']}" style="height: 50px; width: 50px">
                                
                                <div>
                                    <p class="m-0">Name: ${item['name']}</p>
                                    <p class="m-0">Father: ${item['father_name']}</p>
                                    <p class="m-0">Mother: ${item['mother_name']}</p>
                                </div>
                            </div>    
                        </td>
                        <td>
                            ${item['class']['class_name']} <br>
                            ${item['section']['section_name']} <br>
                        </td>
                        <td>
                            <span class="badge bg-primary text-uppercase">${shift}</span>
                        </td>
                        <td>${item['unique_id']}</td>
                        <td>
                            ${connected}
                        </td>
                    </tr>`;
            });
        }
        else
        {
            users = `<tr align="center">
                    <td colspan="6" class="text-muted">No Record Found</td>
                </tr>`;
        }

        $("#userListId").html(users);
        $("#connected_user_card").text(connectedUser);
        $("#disconnected_user_card").text(totalUser - connectedUser);
    }

    
    // init datatable
    /** -------------   INIT DATATABLE
     * =================================================== **/
    let initDataTable = () => {
        $.ajax({
            url: "{{url()->current()}}",
            type: "GET",
            data: {
                classId: "{{array_key_first($classes->toArray())}}"
            },
            beforeSend: () => {

            },
            success: (resp) => {
                // console.log(resp.data.users);
                loadDataTable(resp.data.users);
            },
            error: (error) => {
                console.log(error.responseJSON.message);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }


    /** -------------   load section with class Id
     * =================================================== **/
    let loadSectionFromClass = (classId) => {
        submitFilterForm();
        $.ajax({
            url:"{{route('admin.show.section')}}",
            method:'POST',
            data:{
                '_token':"{{csrf_token()}}",
                "class_id": classId
            },
            success: function (response) {
                $('#section').html(response.html);
            },
            error: (error) => {
                console.log(error.responseJSON.message);
            }
        })
    }

    
    /** -------------   filtering user list
     * =================================================== **/
    let submitFilterForm = () => {
                
        $.ajax({
            url: "{{url()->current()}}",
            type: "GET",
            data: $("#filterFormData").serialize(),
            beforeSend: () => {

            },
            success: (resp) => {
                // console.log(resp.data.users);
                loadDataTable(resp.data.users);
            },
            error: (error) => {
                console.log(error.responseJSON.message);

                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        });
    }

    loadSectionFromClass({{array_key_first($classes->toArray())}});

</script>