@extends('employee.employee_dashboard')
@section('employee')
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

<div class="row profile-body">
  <!-- left wrapper start -->
  <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
    <div class="card rounded">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div>
            <!-- <img class="wd-100 rounded-circle" 
            src="{{(!empty($profileData->photo)) ? url ('upload/admin_images/'.$profileData->photo): url('upload/no_image.jpg') }}" alt="profile"> -->
            
            <span class="h4 ms-3">{{ $profileData->username }}</span>
          </div>
         
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
          <p class="text-muted">{{ $profileData->name }}</p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
          <p class="text-muted">{{ $profileData->email }}</p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
          <p class="text-muted">{{ $profileData->phone ? $profileData->phone : 'NA'}}</p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
          <p class="text-muted">{{ $profileData->address ? $profileData->address : 'NA'}}</p>
          <p class="text-muted">{{ $profileData->role_id ? $profileData->role_id : '000'}}</p>
        </div>
        <div class="mt-3 d-flex social-links">
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="github"></i>
          </a>
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="twitter"></i>
          </a>
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="instagram"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- left wrapper end -->
  <!-- middle wrapper start -->
  <div class="col-md-8 col-xl-8 middle-wrapper">
    <div class="row">
    <div class="card">
              <div class="card-body">

            <h6 class="card-title">Complaint: <strong>Legal Protection Services</strong></h6>

            <form class="forms-sample" method="POST" 
            action="{{route('complaint.lps.store')}}" enctype="multipart/form-data">
            @csrf

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i data-feather="message-circle" class="icon-md mb-1"></i>
                        </span>
                    </div>
                    <textarea class="form-control" id="description" name="description" autocomplete="off" placeholder="Report an Issue" required oninput="checkDescriptionValidity()"></textarea>
                </div>
                <div id="description-error" style="display: none; color: red; margin-top: 5px;" class="mb-3">Please provide more details about the issue.</div>
                <div class="mb-3">
                    <i data-feather="image" class="icon-md mb-1"></i>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <button type="submit" class="btn btn-primary me-2">Submit Report</button>
            </form>
              </div>
            </div>
    </div>
  </div>
  <!-- middle wrapper end -->
  <!-- right wrapper start -->
 
  <!-- right wrapper end -->
</div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    @if(session('success'))
        Swal.fire('Success', '{{ session('success') }}', 'success');
    @elseif(session('error'))
        Swal.fire('Error', '{{ session('error') }}', 'error');
    @endif
        function checkDescriptionValidity() {
        var description = document.getElementById('description').value;
        // Remove whitespace from description and check its length
        var descriptionLength = description.replace(/\s+/g, '').length;
        if (descriptionLength < 18) {
            document.getElementById('description').setCustomValidity(' ');
            document.getElementById('description-error').style.display = 'block';
        } else {
            document.getElementById('description').setCustomValidity('');
            document.getElementById('description-error').style.display = 'none';
        }
    }

    </script>

@endsection