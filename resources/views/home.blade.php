@extends('layouts.students.studentdashboard')

@section('content')

@if(session('success'))
<div class="alert alert-success" role="alert">
    {{session('success')}}
</div>
@endif



@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<!-- Content for the larger column -->
<div class="alert alert-info" role="alert">
    <h4>Welcome to the online file upload portal, please follow the instructions below to uplaod your files</h4>
    <ol class="list-group list-group-numbered fs-5">
        <li class="list-group-item">Upload JPEG format ONLY</li>
        <li class="list-group-item">Must be less than 30KB</li>
        <li class="list-group-item">Exactly 150px by 150px</li>
        <li class="list-group-item">Must be good quality</li>
        <li class="list-group-item">Must be plain white background</li>
    </ol>

</div>

<!-- @if(session('filePath'))
<div class="alert alert-light" role="alert">
    <h4>Submitted Document Preview</h4>
    <div class="preview">
        <img src="{{ asset(session('filePath')) }}" alt="uploaded image" style="width: 100%; height: auto;" />
    </div>
</div>
@endif -->


@endsection