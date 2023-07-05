@extends('layouts.school.master')

@section('content')
    <!--start content-->
    <!--start content-->
    <main class="page-content">
        <div class="row">
            @foreach(\App\Models\MessagePackage::all() as $messagePackage)
            <div class="col-xl-4">
                <!-- <form role="form" action="{{ route('school.message.post') }}" method="POST"> -->
                    <!-- @csrf -->
                    <input type="hidden" value="{{$messagePackage->id}}" name="message_package_id">
                    <div class="card radius-10" style="box-shadow:4px 3px 13px  .13px #d480fb;border-radius:5px;">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1 ">{{__('app.Message')}} {{__('app.package')}} {{$loop->iteration}}</p>
                                    <h4 class="mb-0 ">{{$messagePackage->price}} {{__('app.taka')}}</h4>
                                </div>
                                <div class="ms-auto fs-2 ">
                                    <i class="fadeIn animated bx bx-money"></i>
                                </div>
                            </div>
                            <hr class="my-2 border-top border-light">
                            <div class="d-flex justify-content-between text-center">
                                <small class="mb-0 "><span><p class="mb-1 ">{{__('app.package')}} {{__('app.name')}}</p> {{$messagePackage->package_name}}</span></small>
                                <hr class="my-2 border-top border-light">
                                <small class="mb-0 "><span><p class="mb-1 ">{{__('app.Message')}} {{__('app.Quantity')}}</p>  {{$messagePackage->quantity}}</span></small>
                            </div>

                            <br>
                            <hr>
                            <div class="col text-center">
                            <button class="btn btn-primary" onclick="showModal('{{ $messagePackage->id }}')">Checkout</button>

                            </div>
                        </div>
                    </div>
                <!-- </form> -->

            </div>
            @endforeach
        </div>
    </main>




        <!-- Modal -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height: 700px;">        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">

                </div>
            </div>
        </div>
    </div>
<script>
    function showModal(id) {
        // send AJAX request
        // console.log(messagePackageInfo);

        $.ajax({
            url: '/school/message/package/post',
            type: "POST",
            data: { 
                "_token"    : "{{csrf_token()}}",
                message_package_id: id 
            },
            success: function(response) {
                console.log(response);
                // update modal content
                $('#myModal .modal-body').html(response);
                // show modal
                $('#myModal').modal('show');
            },
            error: function(error){
                console.log(error);
            }
        });
    }
</script>
@endsection