@extends('AdminLayout')

@section('content')


<div class="row">
    <div class="col-md-3 card" style="height: 75vh; overflow:auto;">
        <ul class="list-group list-group-flush fs-5 mt-2">

            @if($recentlySubmitted->isEmpty())

            <p class="mt-2 fs-5">No recently Submitted Documents</p>

            @else
            @foreach($recentlySubmitted as $submitted)
            <li class="list-group-item" onclick="getStudentFiles({{$submitted->student_id}})"><a href="#">{{$submitted->matric_no}}</a></li>
            @endforeach
            @endif
        </ul>
    </div>
    <div class=" col-md-9 ">

        <div class="alert alert-info row" role="alert" id="load_content">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
            @endif


            <h4>Welcome Admin , Your students recently submitted files are on your left , click on any of the matric numbers to view the files</h4>

        </div>
    </div>
</div>


<!-- Admin Comment Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.reject-documents') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h3 class="fs-3">Comment</h3>
                    <label for="formFile" class="form-label fs-5">Briefly describe why you're rejecting these document</label>

                    <textarea name="comment" class="form-control" aria-label="With textarea"></textarea>
                </div>
                <div class="modal-footer">

                    <!-- Hidden input field to store the student_id -->
                    <input type="hidden" name="student_id" id="modal-student-id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>



@endsection


<script>
    function getStudentFiles(student_id) {
        $.ajax({
            url: "{{ route('admin.getSubmittedFiles') }}",
            type: "POST",
            data: {
                student_id: student_id,
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {
                // Clear the content of the div before appending new data
                $('#load_content').empty();
                $('#load_content').append(
                    '<div class="btn-group mb-4" role="group" aria-label="Basic example">' +
                    '<button type = "button" class = "btn btn-success fs-4" onclick="ApproveDocument(' + student_id + ')">' + 'Approve' + ' </button> ' +
                    '<button type = "button"  class = "btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="rejectDocument(' + student_id + ')">' + 'Reject' + '</button>' +
                    '</div>'
                );

                // Loop through the studentFiles array in the response
                response.getFiles.forEach(function(getFile) {
                    // Create an HTML structure for each file and append it to the div
                    $('#load_content').append(
                        '<div class="col-md-4 mb-4">' +
                        '<div class="file-item">' +
                        '<p class="fs-4 "> ' + getFile.file_name + '</p>' +
                        '<a href="' + getFile.document_path + '" target="_blank"><img src="' + getFile.document_path + '" style="width:200px; height:200px;"/></a>' +
                        '<p class=" mt-2">Uploaded on: ' + getFile.updated_at + '</p>' +
                        '<hr>' + // Add a horizontal line to separate entries
                        '</div>' +
                        '</div>'
                    );

                });

            },
            error: function(xhr, status, error) {
                // Handle error
                alert("An error occurred: " + xhr.responseText);
            }
        });
    }

    function ApproveDocument(student_id) {
        $.ajax({
            url: "{{ route('admin.approve-Documents') }}",
            type: "POST",
            data: {
                student_id: student_id,
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {
                if (response.status == 'successful') {
                    window.location.reload();
                }

            },
            error: function(xhr, status, error) {
                // Handle error
                alert("An error occurred: " + xhr.responseText);
            }
        });
    }

    function rejectDocument(student_id) {
        document.getElementById("modal-student-id").value = student_id;
    }
</script>