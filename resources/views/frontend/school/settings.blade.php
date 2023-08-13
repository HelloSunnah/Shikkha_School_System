@extends('layouts.school.master')

@section('content')
    <main class="page-content">

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Select your class and subject</h5>
                        @include('frontend.layouts.message')
                    </div>
                    <div class="card-body">
                        <form action="{{route('settings.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                @foreach ($data['classes'] as $key => $class)
                                <div class="col mb-3" id="customerServices">
                                    <div class="form-check">
                                        <input 
                                            type="checkbox"
                                            class="text-white" 
                                            name="class[]" 
                                            value="{{$class['id']}}"
                                            onchange="selectSubjects('{{$key}}')"
                                            @if(commonClassSelected(Auth::id(), $class['title'])) checked @endif
                                        />
                                        <label class="form-check-label" for="check{{$key}}"><b>{{$class['title']}}</b></label>
                                    </div>

                                    <div class="ms-3">
                                        @forelse ($class['subjects'] as $id => $subject)
                                        <div class="form-check">    
                                            <input 
                                                type="checkbox" 
                                                class="subject-check-{{$key}}"
                                                name="subjects[]"
                                                value="{{$subject->id}}"
                                                @if(commonSubjectSelected(Auth::id(), $class['title'], $subject->name)) checked @endif
                                            />
                                            <label class="form-check-label" for="subject{{$key.$id}}">{{$subject->name}}</label>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>

                                @if($key == 3 || $key == 7 || $key == 11 || $key == 15)
                                <div class="col-12"></div>
                                @endif

                                @endforeach
                            </div>
                            <button type="submit" class="btn-sm btn-outline-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
    </main>

@endsection

@push('js')

    <script>
        function selectSubjects(key) 
        {
            if($(".subject-check-"+key).is(':checked'))
            {
                $(".subject-check-"+key).prop('checked', false);
            }
            else
            {
                $(".subject-check-"+key).prop('checked', true);
            }
        }
    </script>
    
@endpush