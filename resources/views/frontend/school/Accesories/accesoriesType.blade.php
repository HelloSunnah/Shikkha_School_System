@extends('layouts.school.master')

@section('content')


<main class="page-content">
  <center>
    <h1>{{__('app.Accesories')}} {{__('app.List')}}</h1>

  </center>
  <a class="btn btn-secondary" href="{{route('reciept.create')}}">Back</a>

  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="border p-3">

            <form action="{{route('accesoriesType.post')}}" method="post">
              @csrf

              <div class="row">
                <div class="col-md">
                  <input type="text" class="form-control" name="accesories" placeholder="Accesories Name">
                </div>
                <div class="col-md">
                  <input type="number" class="form-control" name="price" placeholder="Enter Price">
                </div>

                <div class="col-md">
                  <button class="btn btn-outline-primary">{{__('app.Create')}}</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>



    <div class="col">
      <div class="card">
        <div class="card-body">
          <div class="border p-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">{{__('app.Id')}}</th>
                  <th scope="col">{{__('app.Accesories')}} {{__('app.Name')}}</th>
                  <th scope="col">{{__('app.Price')}}</th>
                  <th scope="col">{{__('app.action')}}</th>

                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $accesories)
                <tr>
                  <th>{{++$key}}</th>
                  <td>{{$accesories->accesories}}</td>
                  <td>{{$accesories->price}}</td>
                  <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$key}}">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$accesories->id}}"><i class="bi bi-trash-fill"></i></button>

                  </td>
                </tr>
                <!-- dellete -->
                <div class="modal fade" id="deleteModal{{$accesories->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('app.Delete')}} {{__('app.Student')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form method="get" action="{{route('accesories.delete',['id'=>$accesories->id])}}">
                        <div class="modal-body">
                          {{__('app.surecall')}} ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('app.no')}}</button>
                          <button type="submit" class="btn btn-primary">{{__('app.yes')}}</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
                <!-- delete -->

                <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{route('accesoriesType.edit.post',$accesories->id)}}" method="post">
                          @method('put')
                          @csrf

                          <div class="row">
                            <div class="col-md">
                              <label for="">Accesories Name</label>
                              <input type="text" class="form-control" value="{{$accesories->accesories}}" name="accesories" placeholder="Accesories Name">
                            </div>
                            <label for="">Price</label>
                            <div class="col-md">
                              <input type="number" class="form-control" value="{{$accesories->price}}" name="price" placeholder="Enter Price">
                            </div>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- Button trigger modal -->


<!-- Modal -->

@endsection