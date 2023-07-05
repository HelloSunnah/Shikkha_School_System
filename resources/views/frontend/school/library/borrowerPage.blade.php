@extends('layouts.school.master')

@section('content')
<main class="page-content">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <h2 style="margin:10px; text-align:center; ">{{__('app.b_info')}}</h2>
                <div class="row">
                    <div class="col-lg-5">
                    </div>
                    <div class="col-lg-5"></div>
                    <div class="col-lg-2"><a href="{{route('borrower.Create')}}" class="btn btn-primary">{{__('app.add')}}</a></div>
                </div>


                <div class="card-body">

                    <div class="card-body table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{__('app.Id')}}</th>
                                    <th>{{__('app.member')}}</th>
                                    <th>{{__('app.Book_name')}}</th>
                                    <th>{{__('app.borrow_date')}}</th>
                                    <th>{{__('app.p_return_date')}}</th>
                                    <th>{{__('app.return_date')}}</th>
                                    <th colspan="2">{{__('app.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($borrowlist as $key=>$borrowrer)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td>{{ $borrowrer->studentRelation?->name}}</td>
                                        <td>{{ $borrowrer->bookRelation?->book_name}}</td>
                                        <td>{{ $borrowrer->borrow_date}}</td>
                                        <td>{{ $borrowrer->possible_borrow_date}}</td>
                                        <td>{{ $borrowrer->return_date}}</td>

                                        @if(is_null($borrowrer->return_date))
                                            <td><a href="{{route('borrower.Edit',$borrowrer->id)}}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Are You sure?')){ location.replace('{{route('borrower.delete',$borrowrer->id)}}') }">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <button disabled type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#delete">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button disabled type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                    @empty
                                        
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>

@endsection

@push('js')
<script>
    $(document).ready( function () {
        $("#example").dataTable().fnDestroy();
    } );
    </script>
    
@endpush