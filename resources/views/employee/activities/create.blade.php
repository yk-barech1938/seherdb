@extends('employee.employee_dashboard')
@section('employee')
<!-- resources/views/activities/create.blade.php -->

<div class="page-content">
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Legal Service</li>
        <li class="breadcrumb-item active" aria-current="page">CBPL</li>
    </ol>
</nav>

<div class="container">
    <h2>Create Activity</h2>

    <form action="" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="district_id">District ID</label>
            <input type="number" name="district_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="form-group" id="image-container">
            <label for="images">Upload Images</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        </div>

        <div class="form-group">
            <label for="optional_images">Optional Named Images</label>
            <input type="file" name="optional_images[]" class="form-control" accept="image/*">
            @error('optional_images')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="button" class="btn btn-success" onclick="addImageInput()">Add Another Image</button>
        <button type="submit" class="btn btn-primary">Create Activity</button>
    </form>
</div>


</div>
<script>
    function addImageInput() {
        var container = document.getElementById('image-container');
        var newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'images[]';
        newInput.className = 'form-control';
        newInput.accept = 'image/*';
        container.appendChild(newInput);
    }
</script>
@endsection