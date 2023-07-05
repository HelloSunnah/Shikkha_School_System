@extends('layouts.school.master')
@section('content')
<style>
  @media print {

      @media print {
        .modal-footer {
            display: none !important;
        }
    }

      @media print {
            .graph-img img {
                display: inline;
            }
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }
        }
  }
</style>


<main class="page-content">
    <div class="card mt-5">
        <div class="card-body">
            <table class="table text-center table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Month</th>
                    <th scope="col">Price</th>
                    <th scope="col">date</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($billing as $key=>$data)
                  <tr>
                    <th scope="row">{{DateTime::createFromFormat('!m', $data->month)->format('F')}}</th>
                    <td>{{$data->ammount}}</td>
                    <td>{{$data->updated_at->format('Y-m-d')}}</td>
                    <td>
                      @if($data->status ==0)
                      <button class="btn btn-outline-danger btn-sm"><i class="bi bi-receipt"></i>due</button>
                      @else
                      <button class="btn btn-outline-success btn-sm"><i class="bi bi-receipt"></i>Paid</button>
                      @endif
                      <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#billing-{{ $key }}">
                        Invoice
                      </button>

                      <!-- Modal -->
<div class="modal fade" id="billing-{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="printDiv">
        <div class="modal-header text-white" style="background:blueviolet">
          <div class="container overflow-hidden">
            <div class="row ">
                <div class="col-6">
                  <div class="p-3 text-start">
                    {{-- <h1 style="font-size:50px;margin-bottom:-10px"><i class="bi bi-cash"></i></h1> --}}
                    <img src="{{ asset('frontend/assets/img/logo/logo.webp') }}" alt="" width="120" height="60" >
                    <h1 style="">Invoice</h1>
                  </div>
                </div>
                <div class="col-6">
                  <div class="p-3" style="text-align:end">
                    <h4 style="">SHIKKHA</h4>
                    <p style="margin-bottom:-4px">Mobile:+8801568405146 </p>
                    <p style="margin-bottom:-4px">Email:Support@shikkha.one</p>
                    <p style="margin-bottom:-4px">Head Office:Road-13,Sector-10</p>
                    <p style="">Uttara,Dhaka</p>
                  </div>
                </div>
            </div>
          </div>
        </div>
      <div class="modal-body">
           <div class="row" style="margin-top: -4px;">
            <div class="col-6">
              <div class="p-3" style="text-align:left">
                <h4 style="margin-bottom:-2px">{{$school->school_name}}</h4>
                <p style="margin-bottom:-2px">Mobile:{{$school->phone_number}}</p>
                <p style="margin-bottom:-2px">Email:{{$school->email}}</p>
                <p style="">Address:{{$school->address}}</p>
              </div>
            </div>
            <div class="col-6">
              <div class="text-end p-3">
                <h3 style="color:blueviolet;">Invoice Total</h3>
                <h5 >{{$data->ammount}} BDT</h5>
                <h6 >Date:{{$data->updated_at->format('Y-m-d')}}</h6>
              </div>
            </div>
           </div>
           <table class="table table-striped  mt-3 mb-2 text-center ">
            <thead>
              <tr>
                <th scope="col">Item</th>
                <th scope="col">Month</th>
                <th scope="col">PRICE (BDT)</th>
                <th scope="col">QTY.</th>
                <th scope="col">TOTAL AMOUNT (BDT)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td >Item 1</td>
                <td >{{DateTime::createFromFormat('!m', $data->month)->format('F')}}</td>
                <td >{{$data->ammount}} Taka</td>
                <td >1</td>
                <td >{{$data->ammount}} Taka</td>
              </tr>
              <tr>
                <th colspan="4">Grand Total</th>
                <th >{{$data->ammount}} Taka</th>
              </tr>
            </tbody>
          </table>
          <div class="row">
            <div class="col-lg-6">
              <div class="ms-3 ">
                <h6>Declaration:</h6>
                <p>We declare that this invoice shows the actual price of the goods described above and that all particulars are true and correct. The goods sold are intended for end user consumption and not for resale.</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class=" me-3 mt-4 text-end">
                <h4 style="">Status:<strong>
                  @if($data->status ==0)
                  Unpaid
                  @else
                  paid
                  @endif
                </strong>
                </h4>
              </div>
            </div>
          </div>
          {{-- <h6 style="text-align: center;font-weight:500">PoweredBy <img src="{{ asset('frontend/assets/img/logo/cc-logo-alt.png') }}" alt="" width="50" height="30"></h6> --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-arrow-left-square"></i> </button>
        <button type="button" id="print-modal" onclick="printDiv()" class="btn btn-primary btn-sm"><i class="bi bi-printer"></i></button>
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
</main>




<script>
  function printDiv(printDiv) {
      var printContents = document.getElementById('printDiv').innerHTML;
      var originalContents = document.body.innerHTML;
      

      document.body.innerHTML = printContents;
      var divToHide = document.querySelector('.modal-footer');
        divToHide.style.display = 'none';
      window.print();
      document.body.innerHTML = originalContents;

      setTimeout(function() {
                location.reload();
           }, 1000);
  }


</script>

@endsection
