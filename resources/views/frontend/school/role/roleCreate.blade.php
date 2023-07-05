@extends('layouts.school.master')
<style>
    .underline {
        text-decoration: underline;
    }

    .row {
        margin-bottom: 10px;
    }
</style>

@section('content')
<main class="page-content">

    <section class="mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12  mt-4 ">
                    @if (!isset($roleEdit))

                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('Userrole.post')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input type="text" name='role' required class="form-control" placeholder="Role Name">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-center">
                                            <button type="submit" class="btn btn-primary">Create Role</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs- col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Permissions</strong>
                                        <br />
                                        <br>

                                        <div class="col-12">

                                            <button class="accordion-button" name="dashboard" type="button" data-bs-toggle="collapse" data-bs-target="#dashboard" aria-expanded="true" aria-controls="collapseOne">
                                                Dashboard
                                            </button>
                                            </h2>
                                            <div id="dashboard" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Dashboard
                                                                    <input name="dashboard" hidden type="checkbox" value="1">
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[dashboard_create]" type="checkbox" value="1">Create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[dashboard_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[dashboard_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[dashboard_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="dashboard_onAdmi">Online Admission</td>
                                                                <td>
                                                                    <input checked name="permissions[admission_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="permissions[dashboard][delete]">Admission Request</td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" name="class" type="button" data-bs-toggle="collapse" data-bs-target="#class" aria-expanded="false" aria-controls="collapseTwo">
                                                    Class </button>
                                            </h2>
                                            <div id="class" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Class<input type="checkbox" hidden value="1"></td>

                                                                <td>
                                                                    <input name="permissions[class_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="class_section">Section</td>
                                                                <td>
                                                                    <input name="permissions[class_section_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="class_syllabus">Syllabus</td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_subject">Subject</td>
                                                                <td>
                                                                    <input name="permissions[class_subject_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_period">Class Period</td>
                                                                <td>
                                                                    <input name="permissions[class_period_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_routine">Class Routine</td>
                                                                <td>
                                                                    <input name="permissions[class_routine_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="school_routine">School Routine</td>
                                                                <td>
                                                                    <input name="permissions[school_routine_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" name="student" data-bs-target="#student" aria-expanded="false" aria-controls="collapseThree">
                                                    Student </button>
                                            </h2>
                                            <div id="student" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td name="student_show"> Student Show</td>
                                                                <td>
                                                                    <input name="permissions[student_show_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="student_create">Student Create</td>
                                                                <td>
                                                                    <input name="permissions[student_create_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#teacher" aria-expanded="false" aria-controls="collapseThree">
                                                    Teacher </button>
                                            </h2>
                                            <div id="teacher" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Teacher Show</td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Teacher Assign</td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#staff" aria-expanded="false" aria-controls="collapseThree">
                                                    Staff </button>
                                            </h2>
                                            <div id="staff" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Staff List</td>
                                                                <td>
                                                                    <input name="permissions[staff_list_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Stafd Type</td>
                                                                <td>
                                                                    <input name="permissions[staff_type_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_type_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_type_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_delete]" checked type="checkbox" value="1">Delete
                                                                </td>


                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#attendence" aria-expanded="false" aria-controls="collapseThree">
                                                    Attendance </button>
                                            </h2>
                                            <div id="attendence" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Student Attendence </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>All Attendence</td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Get Attendence</td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Input Attendence</td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Auto Attendence</td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finance" aria-expanded="false" aria-controls="collapseThree">
                                                    Finance </button>
                                            </h2>
                                            <div id="finance" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Dashboard</td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>School Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Assign Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Collect Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Staff Salary</td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Teacher Salary</td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Bank Amount</td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Expenses</td>
                                                                <td>
                                                                    <input checked name="permissions[expense_create]" type="checkbox" value="1">Create
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Expenses List</td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Funds</td>
                                                                <td>
                                                                    <input checked name="permissions[fund_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Funds List</td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Accesories</td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sms" aria-expanded="false" aria-controls="collapseThree">
                                                    SMS </button>
                                            </h2>
                                            <div id="sms" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Sms Student</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Sms Teacher</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Sms Employee</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sms Purchase</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exam" aria-expanded="false" aria-controls="collapseThree">
                                                    Exam </button>
                                            </h2>
                                            <div id="exam" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Exam Terms</td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Exam Routine Create</td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Question Create</td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Question Show </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#result" aria-expanded="false" aria-controls="collapseThree">
                                                    Result </button>
                                            </h2>
                                            <div id="result" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Result</td>
                                                                <td>
                                                                    <input checked name="permissions[result_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Result Sms</td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>See Result</td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <td>Mark Type</td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#notice" aria-expanded="false" aria-controls="collapseThree">
                                                    Notice </button>
                                            </h2>
                                            <div id="notice" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Notice</td>
                                                                <td>
                                                                    <input checked name="permissions[notice_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#library" aria-expanded="false" aria-controls="collapseThree">
                                                    Library </button>
                                            </h2>
                                            <div id="library" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Borrowe Info</td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Book Info</td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="collapseThree">
                                                    Settings </button>
                                            </h2>
                                            <div id="settings" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Class</td>
                                                                <td>
                                                                    <input checked name="permissions[settings_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>FingerPrint</td>
                                                                <td>
                                                                    <input checked name="permissions[FingerPrint_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[FingerPrint_manage]" type="checkbox" value="1">Manage
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addon" aria-expanded="false" aria-controls="collapseThree">
                                                    Addons </button>
                                            </h2>
                                            <div id="addon" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Addon</td>
                                                                <td>
                                                                    <input checked name="permissions[addon_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>

                    </div>
                    @else
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('Userrole.edit.post',$roleEdit->id)}}" method="post">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input type="text" name='role' value="{{$roleEdit->role}}" required class="form-control" placeholder="Role Name">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="col-xs-4 col-sm-4 col-md-4 text-center">
                                            <button type="submit" class="btn btn-primary">Update Role</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs- col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Permissions</strong>
                                        <br />
                                        <br>
                                        <div class="col-12">

                                            <button class="accordion-button" name="dashboard" type="button" data-bs-toggle="collapse" data-bs-target="#dashboard" aria-expanded="true" aria-controls="collapseOne">
                                                Dashboard
                                            </button>
                                            </h2>
                                            <div id="dashboard" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Dashboard
                                                                    <input name="dashboard" hidden type="checkbox" value="1">
                                                                </td>
                                                                <td>
                                                                <input type="checkbox" name="permissions[dashboard_create]" value="1">Create

                                                                </td>
                                                                <td>
                                                                <input type="checkbox" name="permissions[dashboard_read]" value="1">Read
                                                                </td>
                                                                <td>
                                                                <input type="checkbox" name="permissions[dashboard_update]" value="1">Update
                                                                </td>
                                                                <td>
                                                                <input type="checkbox" name="permissions[dashboard_delete]" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="dashboard_onAdmi">Online Admission</td>
                                                                <td>
                                                                    <input checked name="permissions[admission_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="permissions[dashboard][delete]">Admission Request</td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[admission_req_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" name="class" type="button" data-bs-toggle="collapse" data-bs-target="#class" aria-expanded="false" aria-controls="collapseTwo">
                                                    Class </button>
                                            </h2>
                                            <div id="class"class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td>Class<input type="checkbox" hidden value="1"></td>

                                                                <td>
                                                                    <input name="permissions[class_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="class_section">Section</td>
                                                                <td>
                                                                    <input name="permissions[class_section_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_section_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="class_syllabus">Syllabus</td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_syllabus_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_subject">Subject</td>
                                                                <td>
                                                                    <input name="permissions[class_subject_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_subject_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_period">Class Period</td>
                                                                <td>
                                                                    <input name="permissions[class_period_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_period_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="class_routine">Class Routine</td>
                                                                <td>
                                                                    <input name="permissions[class_routine_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[class_routine_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td name="school_routine">School Routine</td>
                                                                <td>
                                                                    <input name="permissions[school_routine_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[school_routine_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" name="student" data-bs-target="#student" aria-expanded="false" aria-controls="collapseThree">
                                                    Student </button>
                                            </h2>
                                            <div id="student" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td name="student_show"> Student Show</td>
                                                                <td>
                                                                    <input name="permissions[student_show_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_show_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td name="student_create">Student Create</td>
                                                                <td>
                                                                    <input name="permissions[student_create_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_create_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#teacher" aria-expanded="false" aria-controls="collapseThree">
                                                    Teacher </button>
                                            </h2>
                                            <div id="teacher" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Teacher Show</td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_show_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Teacher Assign</td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[teacher_assign_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#staff" aria-expanded="false" aria-controls="collapseThree">
                                                    Staff </button>
                                            </h2>
                                            <div id="staff" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Staff List</td>
                                                                <td>
                                                                    <input name="permissions[staff_list_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Stafd Type</td>
                                                                <td>
                                                                    <input name="permissions[staff_type_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_type_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_type_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[staff_list_delete]" checked type="checkbox" value="1">Delete
                                                                </td>


                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#attendence" aria-expanded="false" aria-controls="collapseThree">
                                                    Attendance </button>
                                            </h2>
                                            <div id="attendence" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Student Attendence </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[student_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>All Attendence</td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[all_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Get Attendence</td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[get_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Input Attendence</td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[input_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Auto Attendence</td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_create]" checked type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_read]" checked type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_update]" checked type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input name="permissions[auto_attendance_delete]" checked type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#finance" aria-expanded="false" aria-controls="collapseThree">
                                                    Finance </button>
                                            </h2>
                                            <div id="finance" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Dashboard</td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[finance_dashboard_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>School Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[school_fees_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Assign Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[assign_fess_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Collect Fees</td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[collect_fees_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Staff Salary</td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[staff_salary_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Teacher Salary</td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[teacher_salary_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Bank Amount</td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[bank_amount_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Expenses</td>
                                                                <td>
                                                                    <input checked name="permissions[expense_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Expenses List</td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[expense_list_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Funds</td>
                                                                <td>
                                                                    <input checked name="permissions[fund_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Funds List</td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[fund_list_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Accesories</td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[accesories_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sms" aria-expanded="false" aria-controls="collapseThree">
                                                    SMS </button>
                                            </h2>
                                            <div id="sms" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Sms Student</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_student_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Sms Teacher</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_teacher_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Sms Employee</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_employee_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sms Purchase</td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[sms_purchase_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#exam" aria-expanded="false" aria-controls="collapseThree">
                                                    Exam </button>
                                            </h2>
                                            <div id="exam" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Exam Terms</td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_term_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Exam Routine Create</td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[exam_routine_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Question Create</td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_create_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Question Show </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[question_show_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#result" aria-expanded="false" aria-controls="collapseThree">
                                                    Result </button>
                                            </h2>
                                            <div id="result" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>
                                                            <tr>
                                                                <td>Result</td>
                                                                <td>
                                                                <input checked name="permissions[result_create]" type="checkbox" value="1">Update


                                                                </td>
                                                                <td>
                                                                <input checked name="permissions[result_read]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>Result Sms</td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[result_sms_delete]" type="checkbox" value="1">Delete
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>See Result</td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[see_result_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <td>Mark Type</td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[mark_type_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#notice" aria-expanded="false" aria-controls="collapseThree">
                                                    Notice </button>
                                            </h2>
                                            <div id="notice" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Notice</td>
                                                                <td>
                                                                    <input checked name="permissions[notice_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[notice_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#library" aria-expanded="false" aria-controls="collapseThree">
                                                    Library </button>
                                            </h2>
                                            <div id="library" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Borrowe Info</td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[borrow_book_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Book Info</td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[book_info_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false" aria-controls="collapseThree">
                                                    Settings </button>
                                            </h2>
                                            <div id="settings" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Class</td>
                                                                <td>
                                                                    <input checked name="permissions[settings_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[settings_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>FingerPrint</td>
                                                                <td>
                                                                    <input checked name="permissions[FingerPrint_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[FingerPrint_manage]" type="checkbox" value="1">Manage
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#addon" aria-expanded="false" aria-controls="collapseThree">
                                                    Addons </button>
                                            </h2>
                                            <div id="addon" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <table class="table table-borderless">

                                                        <tbody>

                                                            <tr>
                                                                <td>Addon</td>
                                                                <td>
                                                                    <input checked name="permissions[addon_create]" type="checkbox" value="1">
                                                                    create
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_read]" type="checkbox" value="1">Read
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_update]" type="checkbox" value="1">Update
                                                                </td>
                                                                <td>
                                                                    <input checked name="permissions[addon_delete]" type="checkbox" value="1">Delete
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>


                            </form>
                        </div>

                    </div>
                    @endif




                </div>
            </div>
        </div>

    </section>

</main>
@endsection