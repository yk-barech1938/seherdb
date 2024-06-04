@extends('employee.employee_dashboard')
@section('employee')
	<!-- End custom js for this page -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{asset('../assets/css/demo1/custom-select2.css')}}">
<style>
    /* Hide the default arrow icon in modern browsers */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        /* Add some custom styling to make it visually distinct */
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        /* Add any other styling you need */
    }

    /* Add some custom styling for the focused state */
    select:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
        border-color: #51cbea;
    }
    .form-check {
    display: inline-block; /* or inline-flex */
    margin-right: 10px; /* Adjust the margin as needed */
    margin-left:25px;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #d5600024;
    color:#474444;
    border:1px solid #fba206;
    border-radius:4px;
}
.select2-container--default.select2-container .select2-selection--multiple {
    border: solid #e9ecef 1px;
    line-height:1.8;
    outline: 0;
}

</style>
<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">ALAC</li>
						<li class="breadcrumb-item active" aria-current="page">HELPLINE CALLS</li>
					</ol>
				</nav>
        <!-- Chart  -->
        <div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Helpline Calls</h6>
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
                        <h3 class="mb-1" id = "activitiesCount">{{$totalActivities}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="activity" class="icon-md mb-1"></i> -->
                          <i class="fas fa-tasks"></i>
                            <span></span>
                          </p>
                        </div>
                      </div>
                      <div class="col-6 col-md-12 col-xl-7">
                        <div id="ordersChartForSession" class="mt-md-3 mt-xl-0"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
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
                        <h3 class="mb-1" id="maleCount">{{$maleCount}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="user" class="icon-md mb-1"></i> -->
                          <i class="fa fa-male" aria-hidden="true" ></i>
                          <span style="display: block;" id="totalHost"><Strong>POR: </Strong> [ {{$malePorCount}} ] </span>
                          <span style="display: block;" id="totalRefugees"><Strong>NoN-POR:</Strong> [ {{$maleNonPorCount}} ]</span>
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
              <div class="col-md-3 grid-margin stretch-card">
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
                        <h3 class="mb-1" id="femaleCount">{{$femaleCount}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i class="fa fa-female" aria-hidden="true"></i>
                          <span style="display: block;" id="totalHost"><Strong>POR: </Strong> [ {{$femalePorCount}} ]</span>
                          <span style="display: block;" id="totalRefugees"><Strong>NoN-POR:</Strong> [ {{$femaleNonPorCount}} ]</span>
                            
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
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Beneficiary</h6>
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
                        <h3 class="mb-2"  id="totalCount">{{$totalCount}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="users" class="icon-sm mb-1"></i> -->
                          <i class="fa fa-users" aria-hidden="true"></i>
                          <span style="display: block;" id="totalHost"><Strong>POR: </Strong> [ {{$totalPor}} ]</span>
                          <span style="display: block;" id="totalRefugees"><Strong>NoN-POR:</Strong> [ {{$totalNonPor}} ]</span>
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
        <!-- Table -->
				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="row">

                  <div class="col-md-12 text-md-end">
                      <button class="btn btn-primary mb-2" id ="buttontoHide" data-bs-toggle="modal" data-bs-target="#addNewModal">Create Helpline's Activity</button>
                  </div>
                </div>
                <div class="table-responsive" id="show_alls">
                  <!-- Code is removed from here -->
  
                  <!-- Code is end here from desktop -->
                </div>
              </div>
            </div>
					</div>
				</div>

			</div>
<!-- Enhanced Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNewModalLabel">Create Helpline Call's</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- <div id="validation-errors"></div> -->
                <form action="#" method="POST" id="add_employee_forms" data-storing-route="{{ route('helpactivity.store') }}" data-success-message="Caller's Added Successfully!" enctype="multipart/form-data">
                   @csrf
                   <!-- Date and District Start -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <i data-feather="calendar" class="icon-md mb-1"></i> <label for="date" class="mb-1"><strong> &nbsp; Date</strong></label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <i data-feather="map-pin" class="icon-md mb-1"></i>
                          <label for="data_user" class="mb-1"><strong> &nbsp; Create By:</strong></label>
                          <select class="form-select" id="data_user" name="data_user" required >
                              <option disabled selected value="">User Name</option>
                              @foreach ($users as $user)
                                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <!-- Date and District Ends -->
                    <!-- <div class="row">
                        <div class="col-md-12 mb-3">
                          <i data-feather="map-pin" class="icon-md mb-1"></i>
                          <label for="description" class="mb-1"><strong> &nbsp; Description</strong></label>
                          <input type="text" class="form-control mt-2" id="description" name="description" placeholder="Any Comment [Optional]">
                        </div> -->
                      
                    <br>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="add_employee_btns" class="btn btn-primary">Add Call's Activity</button>
                    </div>
                  

                </form>

            </div>
        </div>
        </div>
</div>
<!-- Modal -->
<script>
  fetch('/checkActivityExists')
        .then(response => response.json())
        .then(data => {
            if (data.activityExists) {
                document.getElementById('buttontoHide').style.display = 'none';
            }
        })
        .catch(error => console.error('Error checking activity:', error));


$(document).ready(function () {
  
  function fetchAllTableDataa(){
      $.ajax({
        url: '{{route('fetchhelpline.activity')}}',
        method:'get',
        success: function(res){
          $("#show_alls").html(res);
          // Check if DataTable is already initialized on the table
          if ($.fn.dataTable.isDataTable('#dataTableExample')) {
              $('#dataTableExample').DataTable().destroy();
          }
          $("#dataTableExample").DataTable({
              order: [2,'asc'],
          });
        }
              });
	  }
    
   // Fetch all table data on page load
   fetchAllTableDataa();
    $("#add_employee_forms").submit(function(e){
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_employee_btns").text('Adding...');
        $.ajax({
            url: '{{ route('helpactivity.store') }}',
            method: 'POST',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
              console.log('Ajax request successful', res);
              if(res.success === true){
                    Swal.fire(
                        'Added!',
                        res.message, // Use the message from the response
                        'success'
                    )
                    fetchAllTableDataa();
                    $("#buttontoHide").hide()
                    $("#add_employee_btns").text('Add Calls Activity');
                    $("#add_employee_forms")[0].reset();
                    $("#addNewModal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
              } else {
                    Swal.fire(
                        'Error!',
                        'Failed to add data.', // You can customize the error message
                        'error'
                    );
                }
            },
            error: function (xhr) {
                // Handle error response, including validation errors
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    displayValidationErrors(errors);
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to add data.', // You can customize the error message
                        'error'
                    );
                }
                $("#add_employee_btns").text('Add Calls Activity');
            }
        });
    });
  });
</script>
@endsection
