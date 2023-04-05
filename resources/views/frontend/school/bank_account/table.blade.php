@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <!--start content-->
    <main class="page-content">
        <div class="row">
            <div class="col-xl-12"> 
                <div class="card-header bg-transparent">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">{{__('app.Bank Account')}}</h5>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">{{__('app.back')}}</button>
                            <a href="{{route('bankadd.create')}}" class="btn btn-primary"> <i class="bi bi-plus"></i> Bank Account</a>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    @forelse ($bankadd as $item)
                    <div class="col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body" style="color:black;">
                                <div class="my-3">
                                    <table class="table table-bordered">
                                        <tbody> 
                                            <tr>
                                                <td>{{__('app.Bank Name')}}</td>
                                                <td align="right">{{ $item->bank_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.Branch')}}</td>
                                                <td align="right">{{ $item->branch }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.Account Holder')}}</td>
                                                <td align="right">{{ $item->account_holder }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.Account Type')}}</td>
                                                <td align="right">{{ $item->account_type}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.Account Number')}}</td>
                                                <td align="right">{{ $item->account_number}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.Balance')}}</td>
                                                <td align="right" class="text-success"><h5 class="m-0">{{ $item->balance}} ৳</h5></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('app.action')}}</td>
                                                <td align="right">
                                                    <a href="{{ route('bankadd.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                            
                                                    <button class="btn btn-sm btn-primary" title="Delte"
                                                    onclick="if(confirm('Are you sure? you are going to delete this record')){ location.replace('delete/{{$item->id}}'); }">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    {{-- <h6><b>{{__('app.Bank Name')}}: </b><br>{{ $item->bank_name }}</h6>
                                    <h6><b>{{__('app.Branch')}}: </b><br>{{ $item->branch}}</h6>
                                    <h6><b>{{__('app.Account Holder')}}: </b><br>{{ $item->account_holder}}</h6>
                                    <h6><b>{{__('app.Account Type')}}: </b><br>{{ $item->account_type}}</h6>
                                    <h6><b>{{__('app.Account Number')}}: </b><br>{{ $item->account_number}}</h6>
                                    <h6><b>{{__('app.Account Balance')}}: </b><br>{{ $item->balance}}</h6>--}}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center">
                        <h4 class="text-muted"><b>{{__('app.No Account Added Yet')}}</b></h4>
                    </div>
                    @endforelse
               </div> 
            </div>
        </div>
    </main>
    <?php
    $tutorialShow = getTutorial('department-show');
    ?>
    @include('frontend.partials.tutorial')
@endsection