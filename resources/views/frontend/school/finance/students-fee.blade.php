@extends('layouts.school.master')

@push('js')
    @include('frontend.school.finance.include.fees_collect_script')
@endpush

@section('content')
    <main class="page-content">
        <h4 class="mb-4 text-primary">Collect Fees</h4>

        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body bg-primary text-light">
                        <form id="filterFormData" onsubmit="event.preventDefault()">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select name="shift" class="form-control js-select" id="filter_shift"
                                            onchange="submitFilterForm()">
                                            <option value=""></option>
                                            <option value="1"
                                                @isset(request()->shift) {{ request()->shift == 1 ? 'selected' : '' }} @endisset>
                                                Morning</option>
                                            <option value="2"
                                                @isset(request()->shift) {{ request()->shift == 2 ? 'selected' : '' }} @endisset>
                                                Day</option>
                                            <option value="3"
                                                @isset(request()->shift) {{ request()->shift == 3 ? 'selected' : '' }} @endisset>
                                                Evening</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="classId" class="form-control js-select" id="filter_class"
                                            onchange="loadSectionFromClass(this.value)">
                                            @foreach ($classes as $classId => $className)
                                                <option value="{{ $classId }}"
                                                    @isset(request()->classId) {{ request()->classId == $classId ? 'selected' : '' }} @endisset>
                                                    {{ $className }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- @if (isset(request()->classId) && !empty(request()->classId) && isset($sections) && count($sections) > 0) --}}
                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Section</label>
                                        <select name="sectionId" class="form-control js-select" id="section"
                                            onchange="submitFilterForm()">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                {{-- @endif --}}

                                <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                                    <div class="form-group">
                                        <label for="">Roll Number</label>
                                        <input type="number" class="form-control" id="filter_roll"
                                            onkeyup="submitFilterForm()" name="roll"
                                            @if (isset(request()->roll) && !empty(request()->roll)) value="{{ request()->roll }}" @endif>
                                    </div>
                                </div>

                                {{-- <div class="col-12 mt-4">
                                <div class="row justify-content-center">
                                    <div class="col-4 d-grid">
                                        <button type="submit" class="btn btn-outline-light"> <i class="bi bi-search"></i> Search</button>
                                    </div>
                                </div>
                                <button onclick="event.preventDefault()" class="btn-sm btn-outline-secondary border-0"> <i class="bi bi-x-square"></i> Reset</button>
                            </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body table-responsive">
                        {{-- <div class="row mb-3 align-items-center">
                        <div class="col-3">
                            Show 
                            <select name="" id="" style="border: 1.5px solid blueviolet">
                                <option value="">10</option>    
                                <option value="">25</option>    
                                <option value="">50</option>    
                                <option value="">100</option>    
                            </select> 
                            Entries
                        </div>

                        <div class="col-5">
                            <input type="text" placeholder="Search for student" name="serachKey" class="form-control" />
                        </div>

                        <div class="col-4 align-self-center">
                            <nav aria-label="Page navigation example" class="my-auto">
                                <ul class="pagination justify-content-end align-items-center">
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div> --}}

                        <table class="table table-hover table-bordered" id="example">
                            <thead>
                                <th>Roll</th>
                                <th>Student</th>
                                <th>Class / Section</th>
                                <th>Shift</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="userListId">

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Collect fees --}}
    <div class="modal fade" id="collectFeesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white justify-content-between bg-primary">
                    <h4 class="modal-title">{{ __('app.collect_fees') }}</h4>
                    <button type="button" class="border-0 btn" data-bs-dismiss="modal" aria-label="Close"> <i
                            class="bi bi-x-lg text-white"></i> </button>
                </div>
                <div class="modal-body bg-primary text-light" id="collectFeesModalBody">
                    <div class="row">
                        <div class="col-md-4 border-light border-end" id="collectFeesModalLeftSide">

                        </div>
                        <div class="col-md">
                            {{-- <form id="feesCollectForm"> --}}
                            <div class="row m-0">
                                <div class="col-12">
                                    {{-- School Information --}}
                                    <div class="d-flex gap-3 justify-content-center" id="schoolInfo">
                                        {{-- @if (File::exists(public_path(Auth::user()->school_logo)) && !is_null(Auth::user()->school_logo))
                                        <img src="{{asset(Auth::user()->school_logo)}}" alt="school logo" class="img-fluid" style="width:80px; height:80px">
                                        @endif --}}
                                        <div class="text-center">
                                            <h5 class="m-0"> {{ strtoupper(Auth::user()->school_name) }} </h5>
                                            <p class="m-0">
                                                {{ Auth::user()->slogan != null ? '(' . Auth::user()->slogan . ')' : '' }}
                                            </p>
                                            <small class="m-0"> {{ Auth::user()->address }} </small>
                                        </div>
                                    </div>
                                    <hr style="margin-top: 0px;">
                                    <div class="row align-items-center" id="studentInfoInShort"></div>
                                    <hr>
                                </div>

                                <div class="col-12 mt-3 table-responsive text-white" id="feesTable">

                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-1 bg-primary">
                    {{-- <div class="">Loading</div> --}}
                    <button class="btn btn-light" id="fee_collect_btn" onclick="feesReceived(event)">Received</button>
                    <button class="btn btn-outline-light" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    {{-- history of collect fees --}}
    <div class="modal fade" id="collectedFeesModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white justify-content-between bg-primary">
                    <h4 class="modal-title">{{ __('app.collected_fees') }}</h4>
                    <button type="button" class="border-0 btn" data-bs-dismiss="modal" aria-label="Close"> <i
                            class="bi bi-x-lg text-white"></i> </button>
                </div>
                <div class="modal-body bg-primary text-light" id="collectedFeesModalBody">
                    <div class="row">
                        <div class="col-md">
                            <div class="row m-0">
                                <div class="col-12">
                                    <div class="row align-items-center" id="studentInfoInShortInCollectedFees"></div>
                                    <hr>
                                </div>

                                <div class="col-12 mt-3 table-responsive text-white" id="collectedFeesTable"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-1 bg-primary" id="collectedFeesModalFooter"></div>
            </div>
        </div>
    </div>
@endsection
