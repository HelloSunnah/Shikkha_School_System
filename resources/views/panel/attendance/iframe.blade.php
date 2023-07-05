@extends('layouts.school.master')
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endpush
@section('content')
    <!--start content-->
    <main class="page-content">
        <x-page-title title='Device Login'/>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow p-0">
                    <div class="card-body p-0">
                        <iframe src="http://shikkha.one/login/school" style="height:100vh; width:100%"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </main>

@endsection