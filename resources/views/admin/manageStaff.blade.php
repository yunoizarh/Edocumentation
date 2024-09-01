@extends('AdminLayout')

@section('content')

@if(session('success'))
<div class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif



<div class="form-head d-flex mb-3 mb-md-4 align-items-start">
    <div class="me-auto d-lg-block">
        <a href="#" class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add Staff</a>
    </div>
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
                        <th>Email</th>
                        <th>Department</th>
                        <th>Faculty</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $sn = 1; @endphp
                    @foreach($staffs as $staff)
                    <tr>
                        <td>{{$sn++}}</td>
                        <td>{{$staff->name}}</td>
                        <td>{{$staff->email}}</td>
                        <td>{{$staff->dept_title}}</td>
                        <td>{{$staff->faculty_code ?? ''}}</td>
                        <td><a href="#" style="color: green;" class="editStaffBtn" data-id="{{$staff->id}}">Edit</a></td>
                        <td><a href="#" style="color: red;" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteStaffmodal({{ $staff->id }})">Delete</a></td>
                        <td>
                            <div class="me-auto d-lg-block">
                                @if($staff->faculty_code)
                                <a href="#" style="color: red;" data-bs-toggle="modal" data-bs-target="#DeassignModal" onclick="setStaffId2({{ $staff->id }})">De-Assign</a>

                                @else
                                <a href="#" style="color: green;" data-bs-toggle="modal" data-bs-target="#assignModal" onclick="setStaffId({{ $staff->id }})">Assign</a>
                                @endif
                            </div>
                        </td>
                        <td>


                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


</div>
</div>


</div>


<!-- Add Staff modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.Add-staff') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h3 class="fs-3 mb-4">Add Staff</h3>

                    <div class="mb-3 fs-5">
                        <label for="basic-url" class="form-label">Full Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="fullname" aria-describedby="basic-addon3 basic-addon4">
                        </div>
                    </div>
                    <div class="mb-3 fs-5">
                        <label for="basic-url" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" aria-describedby="basic-addon3 basic-addon4">
                        </div>
                    </div>

                    <div class="mb-3 fs-5">
                        <label for="basic-url" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="phone" aria-describedby="basic-addon3 basic-addon4">
                        </div>
                    </div>

                    <label for="basic-url" class="form-label">Department</label>
                    <div class="input-group mb-3 fs-5">

                        <select class="form-select " id="inputGroupSelect01" name="dept">
                            <option selected>Choose...</option>
                            @foreach($depts as $dept)

                            <option value="{{$dept->dept_id}}">{{$dept->dept_title}}</option>

                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Assign staff Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h3 class="fs-3 mb-4">Assign Staff to Faculty</h3>
                <input type="hidden" id="staffId" name="staffId">

                <label for="basic-url" class="form-label">Faculty</label>
                <div class="input-group mb-3 fs-5">

                    <select class="form-select" id="selectedFaculty" name="faculty">
                        <option selected>Choose...</option>
                        @foreach($faculties as $faculty)

                        <option value="{{$faculty->faculty_id}}">{{$faculty->faculty_title}}</option>

                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" onclick="assignFaculty()">Assign</button>
            </div>

        </div>
    </div>
</div>


<!-- De-Assign staff Modal -->
<div class="modal fade" id="DeassignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h3 class="fs-3 mb-4">De-Assign Staff to Faculty</h3>
                <input type="hidden" id="staffId2" name="staffId">

                <label for="basic-url" class="form-label">Department</label>
                <div class="input-group mb-3 fs-5">

                    <select class="form-select " id="inputGroupSelect2" name="deptId">
                        <option selected>Choose department</option>
                        @foreach($depts as $dept)

                        <option value="{{$dept->dept_id}}">{{$dept->dept_title}}</option>

                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" onclick="DeassignFaculty()">De-Assign</button>
                </div>

            </div>

        </div>
    </div>
</div>


<!-- Delete staff Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h3 class="fs-3 mb-4">Delete Staff</h3>
                <input type="hidden" id="staffId3" name="staffId">
                <p>Are you sure you want to delete this staff ?? This action is irreveribles</p>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" onclick="deleteStaff()">Delete Staff</button>
                </div>

            </div>

        </div>
    </div>
</div>


<!-- Edit staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editStaffForm" action="{{route('admin.update-staff')}}" method="POST">
                @csrf
                <!-- Add a hidden input to hold the staff ID -->
                <input type="hidden" name="staff_id" id="editStaffId">

                <div class="modal-body">
                    <h3 class="fs-3 mb-4">Edit Staff</h3>

                    <div class="mb-3 fs-5">
                        <label for="editFullName" class="form-label">Full Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="fullname" id="editFullName">
                        </div>
                    </div>

                    <div class="mb-3 fs-5">
                        <label for="editEmail" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" id="editEmail">
                        </div>
                    </div>

                    <div class="mb-3 fs-5">
                        <label for="editPhone" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="phone" id="editPhone">
                        </div>
                    </div>

                    <label for="editDept" class="form-label">Department</label>
                    <div class="input-group mb-3 fs-5">
                        <select class="form-select" id="editDept" name="dept">
                            <option selected>Choose...</option>
                            @foreach($depts as $dept)
                            <option value="{{$dept->dept_id}}">{{$dept->dept_title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    if (typeof jQuery === 'undefined') {
        console.error('jQuery is not loaded');
    } else {
        console.log('jQuery is loaded');
    }

    function setStaffId(staffId) {
        document.getElementById('staffId').value = staffId;
    }

    function setStaffId2(staffId) {
        document.getElementById('staffId2').value = staffId;
    }

    function assignFaculty() {
        const staffId = document.getElementById('staffId').value;
        const faculty_id = document.getElementById('selectedFaculty').value;
        $.ajax({
            url: "{{ route('admin.assign-faculty') }}",
            type: "POST",
            data: {
                staffId: staffId,
                faculty_id: faculty_id,
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

    function DeassignFaculty() {
        const staffId = document.getElementById('staffId2').value;
        const deptId = document.getElementById('inputGroupSelect2').value;
        $.ajax({
            url: "{{ route('admin.Deassign-faculty') }}",
            type: "POST",
            data: {
                staffId: staffId,
                deptId: deptId,
                _token: '{{ csrf_token() }}'
            },

            success: function(response) {
                if (response.status == 'successful') {
                    window.location.reload();
                }

            },
            error: function(xhr, status, error) {
                // Handle error
                console.log("An error occurred: " + xhr.responseText);
            }
        });
    }

    function deleteStaffmodal(staffId) {
        document.getElementById('staffId3').value = staffId;
    }

    function deleteStaff() {
        const staffId = document.getElementById('staffId3').value;
        $.ajax({
            url: "{{ route('admin.delete-staff') }}",
            type: "POST",
            data: {
                staffId: staffId,
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

    //get staff data onclick edit
    $(document).ready(function() {
        $(document).on('click', '.editStaffBtn', function() {
            const staffId = $(this).data('id'); // Get the staff ID from the button's data-id attribute

            //Make an AJAX request to fetch staff data
            $.ajax({
                url: '/admin-edit-staff/' + staffId,
                type: 'GET',
                success: function(data) {
                    // Populate the modal fields with the fetched data
                    $('#editStaffId').val(data.id);
                    $('#editFullName').val(data.name);
                    $('#editEmail').val(data.email);
                    $('#editPhone').val(data.phone_no);
                    $('#editDept').val(data.dept_id);

                    // Show the modal
                    $('#editStaffModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                }
            });
        });
    });
</script>