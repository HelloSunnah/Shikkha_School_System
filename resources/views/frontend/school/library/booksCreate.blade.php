@extends('layouts.school.master')

@section('content')
    <main class="page-content">

        <form>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <h2 class="card-title">{{ __('app.book_list') }}</h2>
                            </center>
                            <div class="mb-2">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#delete_all_records">
                                    {{ __('app.deleteall') }}
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#book">
                                    {{ __('app.Add_book') }}
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#booktype">
                                    {{ __('app.Add_type') }}
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table  " style="width:100%">

                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select_all_ids"></th>
                                            <th scope="col">{{ __('app.Id') }}</th>
                                            <th scope="col">{{ __('app.Book_name') }}</th>
                                            <th scope="col">{{ __('app.Author_name') }}</th>
                                            <th scope="col">{{ __('app.rack') }}_</th>
                                            <th scope="col">{{ __('app.quantity') }}</th>
                                            <th scope="col">{{ __('app.available') }}</th>
                                            <th scope="col">{{ __('app.image') }}</th>
                                            <th colspan="2">{{ __('app.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $key => $data)
                                            <tr id="books_ids{{ $data->id }}">
                                                <td><input type="checkbox" class="check_id" name="ids"
                                                        value="{{ $data->id }}"></td>
                                                <td>{{ $key++ + 1 }} </td>
                                                <th scope="row">{{ $key++ + 1 }}</th>
                                                <td>{{ $data->book_name }}</td>
                                                <td>{{ $data->author_name }}</td>
                                                <td>{{ $data->rack_no }}</td>
                                                <td>{{ $data->quantity }}</td>
                                                <td>{{ $data->available }}</td>
                                                <td> <img width="50px"
                                                        src="{{ asset('uploads/library/' . $data->image) }}"
                                                        alt="img not added"></td>
                                                <td>


                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="if(confirm('Are You sure?')){ location.replace('{{ route('books.delete', $data->id) }}') }">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $key }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                </td>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    {{ __('app.Book') }} {{ __('app.Create') }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <form action="{{ route('books.edit.post', $data->id) }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <div class="form-group mb-4">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Book Name</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data->book_name }}" name="book_name"
                                                                            id="book_name" placeholder="Book Name">
                                                                        @error('book_name')
                                                                            <div class="alert alert-danger">{{ $message }}
                                                                            </div>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group mb-4">
                                                                        <label for="exampleInputPassword1"
                                                                            class="select-form">Book Type</label>
                                                                        <select class="form-control mb-3 js-select"
                                                                            name="book_type_id"
                                                                            value="{{ $data->book_type_id }}"
                                                                            id="book_type_id" class="form-control">
                                                                            @foreach ($bookTypes as $book)
                                                                                <option value="{{ $book->id }}">
                                                                                    {{ $book->book_type }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('book_type')
                                                                            <div class="alert alert-danger">{{ $message }}
                                                                            </div>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group mb-4">
                                                                        <label for="author_name" class="form-label">Author
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data->author_name }}"
                                                                            id="author_name" name="author_name"
                                                                            placeholder="Author Name">
                                                                        @error('author_name')
                                                                            <div class="alert alert-danger">{{ $message }}
                                                                            </div>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group mb-4">
                                                                        <label for="rack_no" class="form-label">Rack
                                                                            No</label>
                                                                        <input type="number" class="form-control"
                                                                            value="{{ $data->rack_no }}" name="rack_no"
                                                                            id="rack_no" placeholder="Rack No">
                                                                        @error('rack_no')
                                                                            <div class="alert alert-danger">
                                                                                {{ $message }}</div>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group mb-4">
                                                                        <label for="rack_no"
                                                                            class="form-label">Quantity</label>
                                                                        <input type="number" class="form-control"
                                                                            value="{{ $data->quantity }}" name="quantity"
                                                                            id="quantity" placeholder="Rack No">
                                                                        @error('quantity')
                                                                            <div class="alert alert-danger">
                                                                                {{ $message }}</div>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label for="image">Image</label>
                                                                        <input type="file" class="form-control"
                                                                            name="image" id="image"
                                                                            placeholder="image">
                                                                        <img width="150"
                                                                            src="{{ asset($data->image) }}"
                                                                            alt="{{ $data->image }}" class="img-fluid">
                                                                        @error('image')
                                                                            <div class="alert alert-danger">
                                                                                {{ $message }}</div>
                                                                        @enderror

                                                                    </div>
                                                                    <br>
                                                                    <div class="text-center">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save</button>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>




















                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
    </main>

    <!-- delete checkbox Modal -->
    <div class="modal fade" id="delete_all_records" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:blueviolet;">
                    <h4 class="modal-title" id="exampleModalLabel" style="color:white;">{{ __('app.book_list') }}
                        {{ __('app.Record') }}</h4>
                    <button type="button" class="btn-close btn-white" style="color:white;" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>
                        {{ __('app.checkdelete') }}
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('app.no') }}</button>
                    <button type="button" id="all_delete" class="btn btn-primary"
                        style="background-color:blueviolet !important;border-color:blueviolet !important;">{{ __('app.yes') }}</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="book" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('app.newBook') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @if (\Session::has('insert'))
                                    <div id="" class="alert alert-success">
                                        {!! Session::get('insert') !!}
                                    </div>
                                @endif
                                <!-- error message -->
                                @if (\Session::has('error'))
                                    <div id="" class="alert alert-danger">
                                        {!! Session::get('error') !!}
                                    </div>
                                @endif

                                <form action="{{ route('books.create.post') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3 mt-4">
                                        <label class="form-label">{{ __('app.Book_name') }}</label>
                                        <input type="text" class="form-control" value="{{ old('book_name') }}"
                                            name="book_name" id="book_name" required>
                                        @error('book_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="select-form">{{ __('app.Book_type') }}</label>
                                        <select class="form-select mb-3 js-select" name="book_type_id" id="book_type_id"
                                            value="{{ old('book_type_id') }}" class="form-control">
                                            <option value="">{{ __('app.select') }}</option required>
                                            @foreach ($bookType as $book)
                                                <option value="{{ $book->id }}">{{ $book->book_type }}</option>
                                            @endforeach
                                        </select>
                                        @error('book_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="form-label" for="author_name">{{ __('app.Author_name') }}</label>
                                        <input type="text" class="form-control" value="{{ old('author_name') }}"
                                            id="author_name" name="author_name" required>
                                        @error('author_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="form-label" for="rack_no">{{ __('app.rack') }}</label>
                                        <input type="number" class="form-control" value="{{ old('rack_no') }}"
                                            name="rack_no" id="rack_no" required>
                                        @error('rack_no')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="rack_no" class="form-label">{{ __('app.quantity') }}</label>
                                        <input type="number" class="form-control" value="{{ old('quantity') }}"
                                            name="quantity" id="quantity" required>
                                        @error('quantity')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label class="form-label">{{ __('app.available') }}</label>
                                        <input type="number" class="form-control" value="{{ old('available') }}"
                                            name="available" id="available" required>
                                        @error('available')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="image">{{ __('app.image') }}</label>
                                        <input type="file" accept="image/*" class="form-control"
                                            value="{{ old('image') }}" name="image" id="image"
                                            placeholder="image">
                                        @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-sm">{{ __('app.submit') }}</button>

                                </form>

                            </div>
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="booktype" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('app.Book_type') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body border mt-4 mb-4 ms-4 me-4">
                    <button type="button" class="btn btn-info btn-sm mb-4" data-bs-toggle="modal"
                        data-bs-target="#booktypeList">
                        <i class="bi bi-list-task"></i> Book List
                    </button>
                    <form action="{{ route('books.type.post') }}" method="post">
                        @csrf

                        <div>
                            <label class="form-label">{{ __('app.Book_type') }}</label>
                            <input type="book_type" value="{{ old('book_type') }}" class="form-control" required
                                name="book_type">

                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm mt-3">{{ __('app.save') }}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="booktypeList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Book List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('app.Id') }}</th>
                                <th scope="col">Book Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($bookType as $key => $data)
                                    <th scope="row">{{ $key++ + 1 }}</th>
                                    <td>{{ $data->book_type }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="if(confirm('Are You sure?')){ location.replace('{{ route('books.type.delete', $data->id) }}') }">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                    </td>
                            </tr>
                            @endforeach

                </div>
            </div>
        @endsection
        @push('js')
            <script>
                $(function(e) {
                    $("#select_all_ids").click(function() {
                        $('.check_id').prop('checked', $(this).prop('checked'));
                    });
                    $("#all_delete").click(function(e) {
                        e.preventDefault();
                        var all_ids = [];
                        $('input:checkbox[name=ids]:checked').each(function() {
                            all_ids.push($(this).val());
                        });
                        // console.log(all_ids);
                        $.ajax({
                            url: "{{ route('books.Check.delete') }}",
                            type: "DELETE",
                            data: {
                                ids: all_ids,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $.each(all_ids, function(key, val) {
                                    $('#books_ids' + val).remove();
                                    window.location.reload(true);
                                });
                            }
                        });

                    });
                });
            </script>
        @endpush
