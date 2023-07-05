@extends('layouts.master')
@section('content')
<main class="page-content">

    <div class="row  mt-5">
            <div class="col-3"></div>
            <div class="col-6">
              <div class="card p-4">
                <form action="{{ route('billing.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                      <label>Month</label>
                      <select name="month" class="form-control">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $currentMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                    
                  </div>
                  <input type="hidden" name="school_id" value="{{$school->id}}">
                  <input type="hidden" name="ammount" value="{{$school->billing_add}}">
                  <input type="hidden" name="status" value="0">
                  <div class="text-center">
                      <button class="btn btn-sm btn-primary mb-5" type="submit">
                          <strong>Create</strong>
                      </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="col-3"></div>
    </div>
            <div class="card mt-5">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Month</th>
                            <th scope="col">School</th>
                            <th scope="col">Ammount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Status update Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($billing as $data)
                          <tr>
                            <th scope="row">1</th>
                            <td>{{DateTime::createFromFormat('!m', $data->month)->format('F')}}</td>
                            <td>{{$data->school_id}}</td>
                            <td>{{$data->ammount}}</td>
                            <td>
                              @if ($data->status ==0)
                              <a href="{{route('billing.status',$data->id)}}" class="btn btn-danger">Due</a>
                              @else
                              <a class="btn btn-primary text-white">Paid</a>
                              @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                          </tr>
                          @endforeach
                          <tr>
                        </tbody>
                      </table>
                </div>
    </div>
</main>
@endsection