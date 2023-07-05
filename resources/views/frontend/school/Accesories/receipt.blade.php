@extends('layouts.school.master')
@section('content')
<main class="page-content">
  <center>
    <h1>Accesories History</h1>
  </center>   
   <a class="btn btn-secondary" href="{{route('reciept.create')}}">Back</a>

  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="border p-3">
          
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Student Name</th>

                <th scope="col">Class</th>
                <th scope="col">Section</th>
                <th scope="col">Roll</th>
                <th>Accesories</th>
                <th scope="col">Quatity</th>

                <th scope="col">Totall</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $key => $accesories)
              <tr>
                <th>{{++$key}}</th>
                <td>{{$accesories->name}}</td>

                <td>{{App\Models\InstituteClass::find($accesories->class)?->class_name}}</td>

                <td>{{App\Models\Section::find($accesories->section)?->section_name}}</td>
                <td>{{$accesories->roll}}</td>

                <td>{{$accesories->accesories}}</td>
                <td>{{$accesories->quantity}}</td>

                <td>{{$accesories->amount}}</td>

                <td>
                  <button type="button" class="btn btn-danger" onclick="if(confirm('Are You sure?')){ location.replace('{{route('receipt.delete',$accesories->id)}}') }">
                    <i class="bi bi-trash-fill"></i>
                  </button>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                </td>


                <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <form action="{{route('receipt.history.edit',$accesories->id)}}" method="post">
                          @method('put')
                          @csrf

                          <div>
                            <label for="">Student Name</label>
                            <input type="" placeholder="" value="{{$accesories->name}}" class="form-control" required name="name">

                          </div>

                          <div>
                            <label for="">class</label>
                            <input type="" placeholder="" value="{{$accesories->class_name}}" class="form-control" required name="class">

                          </div>
                          <div>
                            <label for="">Roll</label>
                            <input type="" placeholder="" value="{{$accesories->roll}}" class="form-control" required name="roll">

                          </div>
                          <div>
                            <label for="">Section</label>
                            <input type="" placeholder="" value="{{$accesories->section_name}}" class="form-control" required name="section">

                          </div>
                          <div>
                            <label for="">Accesories</label>
                            <input type="" placeholder="" value="{{$accesories->accesories}}" class="form-control" required name="accesories">

                          </div>
                          <div>
                            <label for="">Quantity</label>
                            <input type="" placeholder="" value="{{$accesories->quantity}}" class="form-control" required name="quantity">

                          </div>
                          <div>
                            <label for="">Total</label>
                            <input type="" placeholder="" value="{{$accesories->amount}}" class="form-control" required name="amount">

                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </div>
                    </form>
                  </div>

                </div>
        </div>
      </div>
      </tr>
      </tbody>
      </table>
      @endforeach

    </div>
  </div>
  </div>
  </div>

</main>

@endsection