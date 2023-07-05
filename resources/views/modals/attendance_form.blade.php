<div class="modal" id="attendance-upload-modal" tabindex="-1" aria-label="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-white" style="background: #7c00a7;border-radious:40px;padding:18px;">
            {{-- <div class="modal-header">
                
            </div> --}}
            <div class="modal-body" style="border:1px dashed  white;border-radious:40px !important;">
                <div class="doded p-4">
                    <h3 class="modal-title pb-2">Attendance</h3>
                <form action="{{route('school.attendance.upload')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="" class="">Select File<span class="text-danger"><strong>*</strong></span></label>
                        <input 
                            type="file" 
                            class="form-control" 
                            name="file"
                            accept=".xlsx,.xls"
                            required
                        />
                    </div>

                    <button class="btn btn-outline-light">Upload</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
