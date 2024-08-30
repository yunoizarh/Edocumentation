    <div class="col-md-12">


        <div class="col-md-12 card p-3">
            <h3>Upload {{ $documents->file_name }}</h3>
            <form action="{{ route('upload_document') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- Include CSRF token for security -->
                <div class="mb-3">
                    <label for="formFile" class="form-label fs-5">Select Document</label>
                    <input type="hidden" name="documentId" value="{{ $documents->id }}">
                    <input class="form-control" type="file" name="document_file" id="document_file" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>


            @if($file)
            <div class="row mt-4">
                <h4>Preview Upload</h4>
                <div class="preview">
                    <img src="{{ asset($file->document_path) }}" alt="uploaded image" style="width: 100%; height: auto;" />
                </div>
            </div>
            @endif
        </div>








    </div>