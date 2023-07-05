@extends('layouts.school.master')

@section('content')
<style>
    .box {
        max-width: 400px;
        width: 100%;
    }

    .box .search-box {
        position: relative;
        height: 40px;
        max-width: 50px;
        margin: auto;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.25);
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    #check:checked~.search-box {
        max-width: 380px;
    }

    .search-box input {
        position: absolute;
        height: 100%;
        width: 100%;
        border-radius: 25px;
        background: #fff;
        outline: none;
        border: none;
        padding-left: 20px;
        font-size: 18px;
    }

    .search-box .icon {
        position: absolute;
        right: -2px;
        top: 0;
        width: 50px;
        background: #FFF;
        height: 100%;
        text-align: center;
        line-height: 42px;
        color: #7100a7;
        font-size: 20px;
        border-radius: 25px;
    }

    #check:checked~.search-box .icon {
        background: #7100a7;
        color: #FFF;
        width: 60px;
        border-radius: 0 25px 25px 0;
    }

    #check {
        display: none;
    }
</style>
<main class="page-content">

    <section class="mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12  mt-4 ">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">

                                    <div class="box">
                                        <input type="checkbox" id="check">
                                        <div class="search-box">
                                            <input type="text" placeholder="Type here...">
                                            <label for="check" class="icon">
                                                <i class="fas fa-search"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>

                                <div class="col-2">
                                    <a href="{{route('user.role.create')}}" class="btn btn-primary">Create Role</a>
                                </div>
                                <div class="col-2"> <a href="{{route('assign.role')}}" class="btn btn-primary">Assign Role</a>
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Members</th>
                                            <th>Edit</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $data)
                                        <tr>
                                            <td> <i style="color: #7100a7;" class="bi bi-shield-fill-check"></i>{{$data->role}}</td>
                                            <td><i   style="color: #7100a7;" class="bi bi-person-fill"></i>tmi </td>
                                            <td>
                                                <a href="{{route('Userrole.edit',$data->id)}}"><i class="bi bi-pencil-fill"></i></a>
                                                <a href="{{route('Userrole.delete',$data->id)}}"><i class="bi bi-trash-fill"></i></a>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection