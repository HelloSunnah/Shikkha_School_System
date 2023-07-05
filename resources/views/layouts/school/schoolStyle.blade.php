<style>
    input[type=checkbox] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border: 2px solid #8a2be2;
        background: #ffff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="checkbox"]:checked {
        background: #8a2be2;
        cursor: pointer;
        font-size: 5px;
        color: rgb(255, 255, 255) !important;
    }

    .dropdown-item:hover {
        background: #9648ba !important;
        color: white !important;
    }



    /* .Bnswitch {
        font-size: 8px !important;
        margin-top: -8px;
        margin-right: 20px;
    } */

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: blueviolet;
        color: white;
    }

    a {
        text-decoration: none !important;
    }

    .imgbox {
        background: #ffff;
        color: blueviolet;
        border: 2px solid blueviolet;
        display: inline-block;
        padding: 0px 4px;
        border-radius: 50%;
        margin-right: 9px;
        margin-left: -10px;
    }

    .imgbox:hover {
        background: blueviolet;
        color: #ffffff;
        border: 2px solid blueviolet;
    }

    .imgbox i {
        font-size: 18px;
        margin-right: 0 !important;
    }

    .sidebar-wrapper .textmenu .list-group .list-group-item {
        background-color: transparent;
        /* border-bottom: 1px solid #e2e3e4; */
        color: blueviolet;
        font-size: 14px;
        font-weight: 500;
    }

    .sidebar2 a:active {
        background: blueviolet;
        color: #ffffff;
    }

    .list-group-item.active {
        border-color: blueviolet;
        background: blueviolet !important;
        color: white !important;
    }

    .list-group-item.active .imgbox {
        background: blueviolet;
        color: #ffffff;
        border: 2px solid rgb(255, 255, 255);
    }

    .btn-primary {
        background: blueviolet;
        border-color: blueviolet;
    }

    .btn-primary:hover {
        background: blueviolet;
        border-color: blueviolet;
    }

    .btn-primary:active {
        background: blueviolet;
        border-color: blueviolet;
    }

    .btn-outline-primary {
        border-color: blueviolet;
        color: blueviolet;
    }

    .btn-outline-primary:active {
        border-color: blueviolet;
        color: blueviolet;
    }

    .btn-outline-primary:hover {
        background: #9604d9;
        border-color: #9807da;
    }

    .text-primary {
        color: #7100a7 !important;
    }

    .form-control:focus {
        border-color: #d997f7 !important;
        box-shadow: 0 0 0 0.25rem rgba(224, 145, 249, 0.25);
    }

    .btn-primary:focus {
        color: #fff;
        background-color: blueviolet;
        border-color: blueviolet;
        box-shadow: 0 0 0 0.25rem rgba(171, 88, 244, 0.5);
    }

    .form-label {
        position: absolute;
        margin-top: -13px;
        background: white;
        margin-left: 12px;
        font-size: 15px;
        padding-left: 9px;
        padding-right: 9px;
    }

    .form-label-edit {
        position: absolute;
        margin-top: -13px;
        background: white;
        margin-left: 12px;
        font-size: 14px;
        padding-left: 9px;
        padding-right: 9px;
    }

    label.select-form {
        position: absolute;
        margin-top: -16px;
        z-index: 1;
        padding-left: 8px;
        background: white;
        padding-right: 8px;
        margin-left: 7px;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #ffffff;
    }

    .select2-container .select2-selection--single {
        height: 35px;
    }

    .top-header .navbar .dropdown-menu::after {
        display: none;
    }

    .btn:focus {
        border-color: blueviolet;
        box-shadow: 0 0 0 0.25rem rgba(171, 88, 244, 0.5);
    }

    table#example {
        border: 1px solid #ddd;
    }

    .page-item .page-link {
        border: 2px solid blueviolet;
        font-weight: 700;
        border-radius: 4px;
        margin-left: 3px;
        margin-right: 3px;
    }

    .page-link:focus {
        color: blueviolet;
        box-shadow: 0 0 0 0.25rem #c94ff9;
    }

    .paginate_button:active {
        color: #fff;
    }

    /* div#example_paginate {
                        display: flex;
                    } */
    .page-item.active .page-link {
        background-color: blueviolet;
        border-color: blueviolet;
    }

    /* i.fas.fa-search.data-search-icon {
                        margin-left:-110px
                        color: blueviolet;
                    } */

    .dataTables_wrapper .dataTables_filter select option:hover {
        background-color: #ff0000;
        /* Replace with your desired hover background color */
        color: #ffffff;
        /* Replace with the desired hover text color */
    }

    /* input#mySearchInput {
                            width: 80% !important;
                            background: #eeeeee !important;
                            } */
    div#example_info {
        display: none;
    }

    /* .custom-search-input-container {
                            margin-right: 19px;
                            padding-left: -20px;
                            margin-bottom: 8px
                        } */

    div#example_paginate {
        margin-top: 10px;
    }

    select.custom-select.custom-select-sm.form-control.form-control-sm {
        border: 2px solid blueviolet;
    }

    .table>:not(:last-child)>:last-child>* {
        border-bottom-color: #dddddd;
    }

    table.dataTable>thead {
        background: #f1eef2;
    }

    table.dataTable>thead .sorting:after,
    table.dataTable>thead .sorting_asc:after,
    table.dataTable>thead .sorting_desc:after,
    table.dataTable>thead .sorting_asc_disabled:after,
    table.dataTable>thead .sorting_desc_disabled:after {
        right: 0;
        content: "";
    }

    table.dataTable>thead .sorting:before,
    table.dataTable>thead .sorting_asc:before,
    table.dataTable>thead .sorting_desc:before,
    table.dataTable>thead .sorting_asc_disabled:before,
    table.dataTable>thead .sorting_desc_disabled:before {
        right: 0;
        content: "";
    }

    table.dataTable>thead>tr>th:not(.sorting_disabled),
    table.dataTable>thead>tr>td:not(.sorting_disabled) {
        padding-right: 10px !important;
    }

    .dataTables_wrapper table.dataTable tbody tr td {
        vertical-align: middle;
    }

    .custom-search-input {
        width: 280px !important;
        background: #f1eef2;
        height: 37px;
        border: none;
        font-weight: 600;
    }

    .custom-search-input:focus {
        background: #f1eef2;
        border: none;

    }

    div#example_filter {
        color: white;
    }


    i.fas.fa-search.search-icon {
        background: #f1eef2;
        color: blueviolet;
        font-size: 20px;
        margin-left: -22px;
        padding-right: 2px;
    }

    /* language toggle switch start*/

    .toggle-ln input[type="checkbox"] {
        width: 88px;
        height: 32px;
        background-color: #f2ecf0;
        border: 2px solid blueviolet;
        -webkit-appearance: none;
        border-radius: 20px;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        -ms-border-radius: 20px;
        -o-border-radius: 20px;
        outline: none;
        transition: .3s;
        -webkit-transition: .3s;
        -moz-transition: .3s;
        -ms-transition: .3s;
        -o-transition: .3s;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }


    .toggle-ln input:checked[type="checkbox"] {
        background-color: #fcf6fb;
        color: blueviolet;
    }

    .toggle-ln input[type="checkbox"]::before {
        position: absolute;
        content: "";
        left: 0;
        top: -3px;
        width: 36px;
        height: 36px;
        background-color: blueviolet;
        border-radius: 50%;
        border: 2px solid blueviolet;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        transform: scale(1.1);
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -ms-transform: scale(1.1);
        -o-transform: scale(1.1);
        box-shadow: 0 2px 5px rgba(238, 98, 251, 0.628);
    }



    .toggle-ln input:checked[type="checkbox"]::before {
        left: 60px;
    }

    .toggle-ln {
        position: relative;
        display: inline;
    }

    .toggle-ln label {
        position: absolute;
        color: blueviolet;
        font-weight: 700;
        pointer-events: none;

    }

    .onbtn {
        bottom: 12px;
        left: 15px;
        color: rgb(247, 236, 244);

    }

    .offbtn {
        bottom: 12px;
        right: 8px;
        color: rgb(240, 234, 245);
    }

    /* language toggle switch end*/
</style>
