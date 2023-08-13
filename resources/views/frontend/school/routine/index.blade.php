@extends('layouts.school.master')

@section('content')
<style>
        select {
        --selectHoverCol: #ff0505;
        --selectedCol: rgb(53, 253, 13);
        width: 100%;
        font-size: 1em;
        padding: 0.3em;
        background-color: #f76f3a;
        }

        select:focus {
        border-radius: 0px;
        border-color: red;
        background: #dbff10;
        outline: none;
        }

        .select-wrap {
        position: relative;
        }

        .select-wrap:focus-within select {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 10
        }

        option:hover {
        background-color: var(--selectHoverCol);
        color: #275981;
        }

        option:checked {
        box-shadow: 0 0 1em 100px var(--selectedCol) inset;
        }
</style>
    <!--start content-->
    <main class="page-content">
        <div class="row">
          <div class="col-12 text-center">
            <h5 class="mb-2 mb-sm-0">{{ __('app.Class') }} {{ __('app.Routine') }}</h5>
          </div>
          <div class="col-xl-6 mx-auto mt-5">
              <div class="card" style="box-shadow:4px 3px 13px  .13px #cf74f9;">
                  
                  <div class="card-body">
                      <form action="{{ route('routine.show') }}">
                          {{-- @csrf --}}

                          <div class="col-lg mb-3 mt-4">
                              <label class="select-form" for="">{{ __('app.Select') }} {{ __('app.shift') }}
                                    <small class="text-danger">*</small></label>

                              <select name="shift"  class="form-control mb-3 js-select selectHovercolor" required>
                                  <option value="">Select One</option>
                                  <option value="2">Day Shift</option>
                                  <option value="1">Morning Shift</option>
                                  <option value="3">Evening Shift</option>
                              </select>
                          </div>

                          <div class="col-lg mb-3 mt-4">
                              <label class="select-form" for="">{{ __('app.Select') }} {{ __('app.Class') }} <small
                                      class="text-danger">*</small></label>
                              <select name="class" class="form-control mb-3 js-select" id="class_id" onchange="loadSection()" required>
                                  <option value="">Select One</option>

                                  @foreach ($classes as $class)
                                      <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-lg mb-3 mt-4">
                              <label class="select-form" for="">{{ __('app.Select') }} {{ __('app.Section') }} <small
                                      class="text-danger">*</small></label>
                              <select name="section" class="form-control mb-3 js-select"id="section_id" required>
                                  <option value="" selected disabled>Select Class First</option>
                              </select>
                          </div>

                          {{-- <div class="mb-3">
                              <label for="">Select Shift</label>
                                  <select name="shift" class="form-control mb-3 js-select" class="form-select" required>
                                  <option value="1" {{ ($row->shift == 1) ? 'selected' : '' }}>Morning Shift</option>
                                  <option value="2" {{ ($row->shift == 2) ? 'selected' : '' }}>Day Shift</option>
                                  <option value="3" {{ ($row->shift == 3) ? 'selected' : '' }}>Evening Shift</option>
                              </select>
                          </div> --}}

                          <button class="btn btn-primary"> {{ __('app.Routine') }} {{ __('app.Show') }}</button>

                      </form>
                  </div>
              </div>
          </div>
        </div>
    </main>
@endsection


@push('js')
    <script>
        function loadSection() {
            let class_id = $("#class_id").val();

            $.ajax({
                url: '{{ route('admin.show.section') }}',
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    class_id: class_id
                },

                success: function(response) {
                    // console.log(response.class.class_name);

                    $('#section_id').html(response.html);


                }
            });

        }


        setSelectHover();

function setSelectHover(selector = "select") {
  let selects = document.querySelectorAll(selector);
  selects.forEach((select) => {
    let selectWrap = select.parentNode.closest(".select-wrap");
    // wrap select element if not previously wrapped
    if (!selectWrap) {
      selectWrap = document.createElement("div");
      selectWrap.classList.add("select-wrap");
      select.parentNode.insertBefore(selectWrap, select);
      selectWrap.appendChild(select);
    }
    // set expanded height according to options
    let size = select.querySelectorAll("option").length;

    // adjust height on resize
    const getSelectHeight = () => {
      selectWrap.style.height = "auto";
      let selectHeight = select.getBoundingClientRect();
      selectWrap.style.height = selectHeight.height + "px";
    };
    getSelectHeight(select);
    window.addEventListener("resize", (e) => {
      getSelectHeight(select);
    });

    /**
     * focus and click events will coincide
     * adding a delay via setTimeout() enables the handling of
     * clicks events after the select is focused
     */
    let hasFocus = false;
    select.addEventListener("focus", (e) => {
      select.setAttribute("size", size);
      setTimeout(() => {
        hasFocus = true;
      }, 150);
    });

    // close select if already expanded via focus event
    select.addEventListener("click", (e) => {
      if (hasFocus) {
        select.blur();
        hasFocus = false;
      }
    });

    // close select if selection was set via keyboard controls
    select.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        select.removeAttribute("size");
        select.blur();
      }
    });

    // collapse select
    select.addEventListener("blur", (e) => {
      select.removeAttribute("size");
      hasFocus = false;
    });
  });
}
    </script>
@endpush
