@extends('AdminLayout')

@section('content')

@if(session('success'))
<div class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif


<div class="form-head d-flex mb-3 mb-md-4 align-items-start">
    <div class="input-group search-area ms-auto d-inline-flex me-2">
        <input type="text" class="form-control" placeholder="Search here">

    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive">
            <table id="example5" class="table shadow-hover doctor-list table-bordered mb-4 dataTablesCard fs-14">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Matric No</th>
                        <th>Department</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @php $sn = 1; @endphp
                    @foreach($students as $student)
                    <tr>
                        <td>{{$sn++}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->matric_no}}</td>
                        <td>{{$student->dept_title}}</td>
                        <td> <a href="#" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#assignModal" onclick="viewStudentDocuments('{{$student->id}}')">View </a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body row" id="loadDocuments">

            </div>

        </div>
    </div>
</div>


@endsection

<script>
    function viewStudentDocuments(student_id) {
        $.ajax({
            url: "{{ route('admin.view-students-documents') }}",
            type: "POST",
            data: {
                student_id: student_id,
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {
                // Clear the content of the div before appending new data
                $('#loadDocuments').empty();

                // Loop through the studentFiles array in the response
                response.studentDocs.forEach(function(studentDoc) {
                    // Create an HTML structure for each file and append it to the div
                    $('#loadDocuments').append(
                        '<div class="card col-md-6 mb-4" style="width: 14rem;">' +
                        '<div class = "card-body" >' +
                        '<p class = "" >' + studentDoc.file_name + ' </p>' +
                        '<a href = "' + studentDoc.document_path + '" target ="_blank" >' +
                        '<img src = "' + studentDoc.document_path + '" width = "150px" height = "150px" alt = "..." > ' +
                        '</a> ' +
                        '</div> </div>'
                    );

                });

            },
            error: function(xhr, status, error) {
                // Handle error
                alert("An error occurred: " + xhr.responseText);
            }
        });
    }
</script>