@extends('layouts.school.master')

@section('content')


<main class="page-content">
    

    <div class="row justify-content-center">
         <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3 text-center">Change Book Details</h5>
                    @if(\Session::has('insert'))
                    <div id="" class="alert alert-success">
                        {!!Session::get('insert')!!}
                    </div>
                    @endif
                    <!-- error message -->
                    @if(\Session::has('error'))
                    <div id="" class="alert alert-danger">
                        {!!Session::get('error')!!}
                    </div>
                    @endif
                    <form action="{{route('books.edit.post',$booksEdit->id)}}" method="post" enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">Book Name</label>
                            <input type="text" class="form-control" value="{{$booksEdit->book_name}}" name="book_name" id="book_name" placeholder="Book Name">
                            @error('book_name')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputPassword1">Book Type</label>
                            <select  class="form-control mb-3 js-select" name="book_type_id" value="{{$booksEdit->book_type_id}}" id="book_type_id" class="form-control">
                                @foreach($bookTypes as $book)
                                <option value="{{$book->id}}">{{$book->book_type}}</option>
                                @endforeach
                            </select>
                            @error('book_type')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="author_name">Author Name</label>
                            <input type="text" class="form-control" value="{{$booksEdit->author_name}}" id="author_name" name="author_name" placeholder="Author Name">
                            @error('author_name')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="rack_no">Rack No</label>
                            <input type="number" class="form-control" value="{{$booksEdit->rack_no}}" name="rack_no" id="rack_no" placeholder="Rack No">
                            @error('rack_no')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="rack_no">Quantity</label>
                            <input type="number" class="form-control" value="{{$booksEdit->quantity}}" name="quantity" id="quantity" placeholder="Rack No">
                            @error('quantity')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="image">
                            <img width="150"  src="{{asset($booksEdit->image)}}" alt="{{$booksEdit->image}}" class="img-fluid">
                            @error('image')<div class="alert alert-danger">{{$message}}</div>@enderror

                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a class="btn btn-secondary" href="{{route('books.create')}}">Back</a>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection