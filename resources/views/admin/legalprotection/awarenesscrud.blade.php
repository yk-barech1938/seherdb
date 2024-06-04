@extends('admin.admin_dashboard')
@section('admin')

<!-- {{-- edit employee modal start --}} -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit L-AS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="name" style="color:gray;">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-lg">
              <label for="father">Father</label>
              <input type="text" name="father" id="father" class="form-control" placeholder="Father" required>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="gender" style="color:gray;">Gender</label>
              <select name="gender" id="gender" class="form-control" required>
                @foreach($genders as $gender)
                    <option value="{{ $gender->id }}" {{ $gender->gender  }}>
                        {{ $gender->gender }}
                    </option>
                @endforeach
            </select>
            </div>
            <div class="col-lg">
              <label for="district">District</label>
              <select name="district" id="district" class="form-control" required>
                @foreach($districts as $district)
                    <option value="{{ $district->id }}" {{ $district->district  }}>
                        {{ $district->district }}
                    </option>
                @endforeach
            </select>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="document_no" style="color:gray;">Document</label>
              <input type="text" name="document_no" id="document_no" class="form-control" placeholder="Document No" required>
            </div>
            <div class="col-lg">
              <label for="contact">Contact</label>
              <input type="text" name="contact" id="contact" class="form-control" placeholder="Contact" required>
            </div>
          </div>
          <div class="row">
            <div class="col-lg">
              <label for="camp" style="color:gray;">Camp</label>
              <input type="text" name="camp" id="camp" class="form-control" placeholder="Camp" required>
            </div>
            <div class="col-lg">
              <label for="session_date">Session</label>
              <input type="date" name="session_date" id="session_date" class="form-control" placeholder="Contact" required>
            </div>
          </div>
          <div class="my-2">
            <label for="remarks">Re-Marks</label>
            <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Re-Marks" required>
          </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Update LAS</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- {{-- edit employee modal end --}} -->
<div class="page-content">

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Legal Service</li>
        <li class="breadcrumb-item active" aria-current="page">Awareness</li>
    </ol>
</nav>
<!-- Chart  -->
<div class="row">
<div class="col-12 col-xl-12 stretch-card">
<div class="row flex-grow-1">
<div class="col-md-4 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-baseline">
      <h6 class="card-title mb-0">Males</h6>
      <div class="dropdown mb-2">
        <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 col-md-12 col-xl-5">
        <h3 class="mb-2">{{$countMale }}</h3>
        <div class="d-flex align-items-baseline">
          <p class="text-success">
          <i data-feather="user" class="icon-md mb-1"></i>
            <!-- <span>+3.3% - year</span> -->
          </p>
        </div>
      </div>
      <div class="col-6 col-md-12 col-xl-7">
        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-md-4 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-baseline">
      <h6 class="card-title mb-0">Females</h6>
      <div class="dropdown mb-2">
        <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 col-md-12 col-xl-5">
        <h3 class="mb-2">{{$countFemale }}</h3>
        <div class="d-flex align-items-baseline">
          <p class="text-success">
          <i data-feather="user" class="icon-md mb-1"></i>
            <!-- <span>+15.8%</span> -->
            
          </p>
        </div>
      </div>
      <div class="col-6 col-md-12 col-xl-7">
        <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-md-4 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-baseline">
      <h6 class="card-title mb-0">Registered</h6>
      <div class="dropdown mb-2">
        <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
          <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6 col-md-12 col-xl-5">
        <h3 class="mb-2">{{$total}}</h3>
        <div class="d-flex align-items-baseline">
          <p class="text-success">
          <i data-feather="users" class="icon-sm mb-1"></i>
            <span>Total in Awareness</span>
          </p>
        </div>
      </div>
      <div class="col-6 col-md-12 col-xl-7">
        <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div> <!-- row  end here -->

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
<div class="card">
<div class="card-body">
<div class="row">
  <div class="col-md-6">
      <h6 class="card-title">Awareness Table</h6>
  </div>
  <!-- <div class="col-md-6 text-end">
      <button class="btn mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal" style="background-color: #f5a638; color: white;">Add News</button>
  </div> -->
</div>
    <div class="table-responsive" id="show_all">
 </div>
</div>
</div>
    </div>
</div>

</div>

@endsection
