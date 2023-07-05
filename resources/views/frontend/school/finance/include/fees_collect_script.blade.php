<script>
    const svgIconOfTK = "TK";


    // load data table
    let loadDataTable = (data) => {
        let users = ``;

        if(data.length > 0)
        {
            data.forEach((item, index) => {
                let shift = "";

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
                        <td>
                            <button class="btn-sm btn-danger" onclick="collectFeesModal(${item['id']})"> <i class="fa fa-hand-holding-dollar"></i> </button>
                            <button class="btn-sm btn-primary" onclick="collectedFeesModal(${item['id']})"> <i class="fa fa-list-check"></i> </button>
                        </td>
                    </tr>`;
            });
        }
        else
        {
            users = `<tr align="center">
                    <td colspan="5" class="text-muted">No Record Found</td>
                </tr>`;
        }

        $("#userListId").html(users);
    }

    
    // init datatable
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

    initDataTable();

    /** -------------   calculate in total fees
     * =================================================== **/
    let calculateInTotalFees = () => {
        var newTotalAmount = 0;

        $(".feesTableAllAmount").each((i, sel) => {
            newTotalAmount += parseInt($(sel).text());
        });

        $("#totalAmountInFeesTable").text(`${newTotalAmount} ${svgIconOfTK}`);

        return newTotalAmount;
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

    /** -------------   load student information
     * =================================================== **/
    let studentShortINFO = (student) => {
        let shift = "";

        if(student.shift == 1)
        {
            shift = "Morning";
        }
        else if(student.shift == 2)
        {
            shift = "Day";
        }
        else if(student.shift == 3)
        {
            shift = "Evening";
        }
        
        return `<div class="col-2">
                <img src="/${student.image}" class="img-fluid rounded rounded-5" style="height: 90px">
            </div>
            <div class="col-6">
                <table>
                    <tbody>
                        <tr> 
                            <td>Student Name</td>
                            <td>: ${student.name}</td>
                        </tr>
                        <tr>
                            <td>Father Name</td>
                            <td>: ${student.father_name}</td>
                        </tr>
                        <tr>
                            <td>Mother Name</td>
                            <td>: ${student.mother_name}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>: ${student.phone}</td>
                        </tr>
                        <tr>
                            <td>Shift</td>
                            <td>: ${shift}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <table>
                    <tbody>
                        <tr>
                            <td>UID</td> 
                            <td>: ${student.unique_id}</td>
                        </tr>
                        <tr>
                            <td>Roll</td> 
                            <td>: ${student.roll_number}</td>
                        </tr>
                        <tr>
                            <td>{{__('app.class')}}</td>
                            <td>: ${student.class.class_name}</td>
                        </tr>
                        <tr>
                            <td>{{__('app.section')}}</td>
                            <td>: ${student.section.section_name}</td>
                        </tr>
                        <tr>
                            <td>Scholarship</td>   
                            <td>: ${student.discount} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>`;
    }

    /** -------------   add fees from menubar
     * =================================================== **/
    let addFees = (feesId, feesTitle, feesAmount, feesMonthName) => {
        
        if($("#feesTableRaw_"+feesId).length == 0)
        {
            $("#feesTableBody").append(`<tr id="feesTableRaw_${feesId}">
                            
                    <td class="actionColumnInFeesModalTable">
                        <input type="hidden" name="hiddenFeesId[]" value="${feesId}" />
                        <span style="cursor:pointer" onclick="customiseFee(${feesId})"><i class="bi bi-pencil-square"></i></span>    
                    </td>
                    <td>${feesTitle} (${feesMonthName})</td>
                    <td class="text-end" id="feesTableAmountTD_${feesId}">
                        <span id="feesTableAmount_${feesId}" class="feesTableAllAmount">${feesAmount}</span> ${svgIconOfTK}
                        <input type="hidden" name="feesAmount[]" id="hiddenFeesAmount" value="${feesAmount}" />
                    </td>
                </tr>`);

            calculateInTotalFees();
        }
        else
        {
            $("#feesTableRaw_"+feesId).remove();
            calculateInTotalFees()
        }
        
    }

    /** -------------   save customize fees
     * =================================================== **/
    let saveCustomizeFees = (feesId, oldFeeAmount) => {

        var customValue = $("#feesTableCustomizeAmount_"+feesId).val();
        $("#fee_collect_btn").attr('disabled', false);

        var element = ``;

        if(customValue < oldFeeAmount)
        {
            element += `<span class="oldFeeAmountStrke"><s class="me-5">${oldFeeAmount}</s></span>`;
        }
        
        element += `<span id="feesTableAmount_${feesId}" class="feesTableAllAmount">${customValue}</span> ${svgIconOfTK}
                    <input type="hidden" name="feesAmount[]" id="hiddenFeesAmount" value="${customValue}" />`;

        $("#feesTableAmountTD_"+feesId).html(element);

        calculateInTotalFees(element);      
    }


    let checkAmountValidity = (amount, key) => {
        var requiredAmount = $("#feesTableCustomizeAmount_"+key).val();
        
        if(requiredAmount > amount)
        {
            requiredAmount = requiredAmount.substring(0, requiredAmount.length - 3);
            $("#feesTableCustomizeAmount_"+key).val("");

            Swal.fire({
                icon: 'info',
                title: 'Invalid Amount',
                confirmButtonColor: '#7100A7',
            });
        }
    }

    
    /** -------------   Customize fees
     * =================================================== **/
    let customiseFee = (feesId, amount) => {

        if($("#feesTableAmount_"+feesId).length > 0)
        {
            var currentAmount = parseInt($("#feesTableAmount_"+feesId).text());

            $("#fee_collect_btn").attr('disabled', true);

            $("#feesTableAmountTD_"+feesId)
            .html(`
                <input type="number" onkeyup="checkAmountValidity(${amount}, ${feesId})" class="border border-primary p-1 text-end bg-none" id="feesTableCustomizeAmount_${feesId}" value="${currentAmount}" /> 
                <span title="Save" style="cursor:pointer" onclick="saveCustomizeFees(${feesId}, ${amount})"><i class="bi bi-files"></i></span>
            `);
        }
    }


    /** -------------   show fees table with data
     * =================================================== **/
    let FeesTable = (data) => {

        let amountInTotal = 0;
        let element = `<table class="table table-bordered text-light">
                            <thead>
                                <th width="10%" class="actionColumnInFeesModalTable">Action</th>
                                <th width="70%">Description</th>
                                <th width="20%" class="text-end">Amount</th>
                            </thead>
                            <tbody id="feesTableBody">`;

        if(data.length > 0)
        {
            data.forEach((val, key) => {
                element += `<tr id="feesTableRaw_${val['id']}">
                            
                            <td class="actionColumnInFeesModalTable">
                                <input type="hidden" name="hiddenFeesId[]" value="${val['id']}" />
                                <span style="cursor:pointer" onclick="customiseFee(${val['id']}, ${val['amount']})"><i class="bi bi-pencil-square"></i></span>    
                            </td>
                            <td>
                                ${val['title']} (${val['month_name']})
                            </td>
                            <td class="text-end" id="feesTableAmountTD_${val['id']}">
                                <span id="feesTableAmount_${val['id']}" class="feesTableAllAmount">${val['amount']}</span> ${svgIconOfTK}
                                <input type="hidden" name="feesAmount[]" id="hiddenFeesAmount" value="${val['amount']}" />
                            </td>
                        </tr>`;

                amountInTotal += val['amount'];
            });
        }

        element += `</tbody>
                        <tfoot>
                            <tr class="text-end">
                                <th class="actionColumnInFeesModalTable"></th>
                                <th>In Total</td>
                                <th id="totalAmountInFeesTable">${amountInTotal} ${svgIconOfTK}</th>
                            </tr>
                        </tfoot>
                    </table>`;

        return element;
    }


    /** --------  Open Modal with user payment history
     * =================================================== **/
    let collectFeesModal = (sid) => {
        $("#collectedFeesModal").modal('hide');

        $.ajax({
            url: "{{route('school.finance.userInfo.get')}}",
            type: "GET",
            data: {
                sid: sid
            },
            beforeSend: () => {
                
            },
            success: (resp) => {

                if(resp.data.allPaid == true)
                {
                    $("#collectFeesModal").modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'All Fees Are Paid',
                        confirmButtonColor: '#7100A7',
                    });
                }

                else if(resp.data.fees.length > 0)
                {
                    let element = `<ul class="list-unstyled">`;

                    resp.data.fees.forEach((items, index) => {
                        element += `<li><h6 class="text-white">${items['month_name']}</h6>
                                        <ul class="list-unstyled">`;
                                            
                        items['fees'].forEach((fees, key) => {
                            var selected = "";
                            if(fees['selected'] == true)
                            {
                                selected = "checked";
                            }

                            element += `<li>
                                            <div class="form-check">
                                                <input class="form-check-input me-3" type="checkbox" ${selected} id="check${index}${key}" onclick="addFees('${fees['id']}', '${fees['title']}', '${fees['amount']}', '${fees['month_name']}')">
                                                <label class="form-check-label" for="check${index}${key}">
                                                    ${fees['title']} (${fees['amount']})
                                                </label>
                                            </div>
                                        </li>`;
                        });

                        element += `</ul></li>`;
                    });

                    element += `</ul>`;
                    
                    $("#collectFeesModalLeftSide").html(element);
                    $("#studentInfoInShort").html(studentShortINFO(resp.data.student));
                    $("#feesTable").html(FeesTable(resp.data.records));
                    $("#collectFeesModal").modal('show');
                }

                else
                {
                    $("#collectFeesModal").modal('hide');

                    Swal.fire({
                        icon: 'info',
                        title: 'Record Not Found',
                        text: "Fees are not assign",
                        confirmButtonColor: '#7100A7',
                    });
                }                
            },
            error: (error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        })
    }


    /** -------------   collect fees
     * =================================================== **/
    let feesReceived = (e) => {
        e.preventDefault();

        let hiddenFeesId = $("input[name='hiddenFeesId[]']").map(function(){return $(this).val();}).get();
        let feesAmount = $("input[name='feesAmount[]']").map(function(){return $(this).val();}).get();

        Swal.fire({
            title: 'Are you sure?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7100A7',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{route('school.finance.collect.fees')}}",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}",
                        hiddenFeesId: hiddenFeesId,
                        feesAmount: feesAmount
                    },
                    beforeSend: () => {
                        $("#fee_collect_btn").attr('disabled', true)
                        .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Collecting...`);
                    },
                    success: (resp) => {
                        
                        $("#fee_collect_btn").attr('disabled', false)
                        .html("Received");

                        Swal.fire({
                            icon: 'success',
                            title: 'Great!',
                            text: resp.message,
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                // collectFeesModal(resp.data);
                                $(".table").removeClass("text-light");
                                printInvoice(resp.data);
                            }
                        });
                    },
                    error: (error) => {
                        $("#fee_collect_btn").attr('disabled', false)
                        .html("Received");

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: error.responseJSON.message,
                        });
                    }

                });
            }
        });

    }


    /** -------------   Print selected Element
     * =================================================== **/
    let printInvoice = (studentId) => {

        $(".actionColumnInFeesModalTable").remove();
        $(".oldFeeAmountStrke").remove();

        $.ajax({
            url: "/v2/dompdf",
            type: "POST",
            data: {
                "_token": "{{csrf_token()}}",
                "feesTable": $("#feesTable").html(),
                "studentId" : studentId,
            },
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: () => {
                $("#fee_collect_btn").attr('disabled', true)
                .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>PDF Generating...`);
            },
            success: (resp) => {
                var blob = new Blob([resp]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "cc-shikkha-receipt.pdf";
                link.click();
                collectFeesModal(studentId);

                $("#fee_collect_btn").attr('disabled', false).html("Received");
            },
            error: (error) => {
                $("#fee_collect_btn").attr('disabled', false).html("Received");
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        })
    }



    /** -------------   Load Collected Fees
     * =================================================== **/
    let collectedFeesModal = (studentId) => {
        
        $.ajax({
            url: '{{route("school.finance.collected.fees.show")}}',
            type: 'GET',
            data: {
                userId: studentId,
                schoolId: '{{Auth::id()}}',
            },
            beforeSend: () => {

            },
            success: (resp) => {
                var html = ``;

                html = ` <table class="table table-hover text-white">
                            <thead>
                                <tr>
                                    <th>{{__('app.Month')}}</th>
                                    <th>{{__('app.Description')}}</th>
                                    <th>{{__('app.Amount')}}</th>
                                    <th>{{__('app.Paid')}}</th>
                                    <th>{{__('app.Due')}}</th>
                                    <th>{{__('app.Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>`;

                resp.data.collectedFees.forEach((item,index) => {

                    var status = `<span class="badge bg-danger"> {{strtoupper(__('app.Due'))}} </span>`;
                    if(item['status'] == 2)
                    {
                        status = `<span class="badge bg-success"> {{strtoupper(__('app.Paid'))}} </span>`;
                    }

                    html += `<tr>
                                <td>${item['month_name']}</td>
                                <td>${item['title']}</td>
                                <td>${item['amount']}</td>
                                <td>${item['paid_amount']}</td>
                                <td>${parseInt(item['amount'] - item['paid_amount'])}</td>
                                <td>${status}</td>
                            </tr>`;
                });

                html += `</tbody></table>`;

                $("#studentInfoInShortInCollectedFees").html(studentShortINFO(resp.data.student));
                $("#collectedFeesTable").html(html);
                $("#collectedFeesModalFooter").html(`<button class="btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <button class="btn btn-light" onclick="collectFeesModal(${resp.data.student.id})">{{__('app.collect_fees')}}</button>`);
                $("#collectedFeesModal").modal('show');
            },
            error: (error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: error.responseJSON.message,
                });
            }
        })

    } 


    /** -------------   Print selected Element
     * =================================================== **/
    let printDiv = (targetElement) => {
        var printContents = document.getElementById(targetElement).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>