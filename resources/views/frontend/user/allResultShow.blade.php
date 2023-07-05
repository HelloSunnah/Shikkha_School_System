@extends('layouts.user.master')

@section('content')

    <main class="page-content">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    @if(count($dataResult) > 0)
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Subject Name</th>
                        <th>written</th>
                        <th>MCQ</th>
                        <th>Practical</th>
                        <th>Term</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($dataResult as $key => $data)
                        <tr>
                            <td>{{$key++ +1}}</td>
                            <td>{{getSubjectNameAll($data->subject_id)?->subject_name ?? ''}}</td>
                            <td>{{$data->written}}</td>
                            <td>{{$data->mcq}}</td>
                            <td>{{$data->practical}}</td>
                            <td>{{getTermName($data->term_id)->term_name}}</td>
                        </tr>
                    @endforeach


                    </tbody>
                    @else
                        <p>No Data Found</p>
                    @endif
                </table>
            </div>
        </div>
    </main>
@endsection
