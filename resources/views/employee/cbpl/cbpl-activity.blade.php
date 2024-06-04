@extends('employee.employee_dashboard')
@section('employee')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
  
</style>
<!-- CBPL Dashboard main table's data -->

<div class="page-content">

	<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">Legal Service</li>
			<li class="breadcrumb-item active" aria-current="page">Community Based Para Legal</li>
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
                      <h6 class="card-title mb-0">CBPL's</h6>
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
                    <!-- @ p h p
                      $ cou ntActivity = $ acti vi ties->c oun t();
                    @ en d ph p -->
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-1" id = "activitiesCount">{{$countActivity}}</h3>
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
                        <h3 class="mb-1" id="maleCount">{{$countMale}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="user" class="icon-md mb-1"></i> -->
                          <i class="fa fa-male" aria-hidden="true" ></i>
                          <span style="display: block;" id="maleHost"><strong>Host:</strong> [ {{$countHostMale}} ]</span>
                          <span style="display: block;" id="maleRefugees"><strong>Refugess:</strong> [ {{$countRefugeesMale}} ]</span>
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
                        <h3 class="mb-1" id="femaleCount">{{$countFemale}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i class="fa fa-female" aria-hidden="true"></i>
                          <span style="display: block;" id="femaleHost"><strong>Host:</strong> [ {{$countHostFemale}} ]</span>
                          <span style="display: block;" id="femaleRefugees"><strong>Refugees:</strong> [ {{$countRefugeesFemale}} ]</span>
                            
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
                        <h3 class="mb-2"  id="totalCount">{{$total}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="users" class="icon-sm mb-1"></i> -->
                          <i class="fa fa-users" aria-hidden="true"></i>
                          <span style="display: block;" id="totalHost"><strong>Host:</strong> [ {{$totalHost}} ]</span>
                          <span style="display: block;" id="totalRefugees"><strong>Refugees:</strong> [ {{$totalRefugees}} ]</span>
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
                  <div class="col-md-2">
					            <select id="districtDropdown" class="form-select form-select-sm" disabled>
                        <option value="" selected> -- District -- </option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->district }}</option>
                        @endforeach
                      </select>
                </div>
                  <!-- Date Range Filter -->
                  <div class="col-md-7">
				  <form id="searchForm" action="{{ route('search.cbplactivities') }}" method="POST">
                          @csrf 
                          <div class="form-group row">
                              <label for="date" class="col-form-label col-sm-2">From</label>
                              <div class="col-sm-3">
                                  <input type="date" class="form-control input-sm" name="fromDate" id="fromDate" required>
                              </div>
                              <label for="date" class="col-form-label col-sm-2">To</label>
                              <div class="col-sm-3">
                                  <input type="date" class="form-control input-sm" name="toDate" id="toDate" required>
                              </div>
                              <div class="col-sm-2 align-self-center">
                                  <button type="submit" class="btn" name="search" title="Search">
                                      <img src="https://img.icons8.com/material-outlined/24/000000/search--v1.png" alt="Search icon" style="filter: invert(51%) sepia(1%) saturate(3122%) hue-rotate(203deg) brightness(91%) contrast(91%);">
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
                  <!-- Create & Excel Buttons -->
                  <div class="col-md-3 text-md-end">
                        <a href="{{ route('cbplexcel.export') }}">
                            <button type="button" class="btn btn-success btn-icon-text mb-2">
                                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                Excel
                            </button>
                        </a>
                      <button class="btn mb-2" style="background-color: #AA2F33;" data-bs-toggle="modal" data-bs-target="#">
                          <i class="btn-icon-prepend fas fa-file-pdf" style="color: white;"></i>  <span style="color: #ffff;">&nbsp; PDF</span>
                      </button>
                      <!-- <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal"><i class="btn-icon-prepend" data-feather="download-cloud"></i></button> -->
                      <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal">Create CBPL</button>
                  </div>
              </div>
                <div class="table-responsive" id="cbpl_parent">
                  <!-- Code is removed from here -->

                  <!-- Code is end here from desktop -->
                </div>
              </div>
            </div>
		</div>
	</div>
</div>
<!-- CBPL ENds Here  cbplactivity.store--> 
<!-- Bootstrap Modal PopUp Modal to add CBPL's -->
<!-- Enhanced Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNewModalLabel">Create CBPL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="validation-errors"></div>
                <form action="#" method="POST" id="add_employee_forms" data-storing-route="{{ route('cbplactivity.store') }}" data-success-message="Activity's Added Successfully!" enctype="multipart/form-data">
                   @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <i data-feather="calendar" class="icon-md mb-1"></i> <label for="date" class="mb-1"><strong> &nbsp; CBPL Date</strong></label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <i data-feather="map-pin" class="icon-md mb-1"></i>
                          <label for="camp" class="mb-1"><strong> &nbsp; District</strong></label>
                          <select class="form-select" id="district" name="district" required >
                              <option disabled selected value="">Select District</option>
                              @foreach($districts as $district)
                                  <option value="{{ $district->id }}">{{ $district->district }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <i data-feather="map-pin" class="icon-md mb-1"></i>
                          <label for="camp" class="mb-1"><strong> &nbsp; Camp</strong></label>
                          <select class="form-select" id="camp" name="camp" required onchange="showOtherOption()">
                              <option disabled selected value="">Select Camp</option>
                          </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="otherCamp" id="otherCampLabel" class="mb-1"><strong> &nbsp; Other Camp</strong></label>
                        <input type="text" class="form-control mt-2" id="otherCamp" name="otherCamp" placeholder="Enter Other Camp">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <i data-feather="image" class="icon-md mb-1"></i>
                        <label for="date" class="mb-1"><strong> &nbsp; Upload Images</strong></label>
                        <div class="form-group" id="image-container">
                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <i data-feather="file" class="icon-md mb-1"></i>
                        <label for="date" class="mb-1"><strong> &nbsp; Upload PDFs</strong></label>
                        <div class="form-group" id="pdf-container">
                            <input type="file" name="pdfs[]" class="form-control" accept=".pdf" multiple required>
                        </div>
                    </div>
                      </div>
                    <i data-feather="check-square" class="icon-md mb-1"></i> <label for="" class="mb-2"><strong> &nbsp; Mov's Uploaded ? &nbsp;</strong></label><br>
                    
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" name="movsCheckBox[]" value="Pictures" id="flexCheckDefault2">
                      <label for="flexCheckDefault2" class="form-check-label">
                        Pictures
                      </label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" name="movsCheckBox[]" value="Attendance" id="flexCheckDefault">
                      <label for="flexCheckDefault" class="form-check-label">
                        Attendance
                      </label>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" name="movsCheckBox[]" value="Report" id="flexCheckDefault3">
                      <label for="flexCheckDefault3" class="form-check-label">
                        Report
                      </label>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" onclick="addImageInput()">Other Images</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="add_employee_btns" class="btn btn-primary">Add Session</button>
                    </div>
                  

                </form>

            </div>
        </div>
    </div>
</div>
<script>
  // for camp selection
  function showOtherOption() {
            var select = document.getElementById("camp");
            var otherInput = document.getElementById("otherCamp");
            var otherLabel = document.getElementById("otherCampLabel");
            if (select.value === "other") {
                otherInput.style.display = "block";
                otherInput.required = true; // Optional: make the field required
                otherLabel.style.display = "block";
            } else {
                otherInput.style.display = "none";
                otherInput.required = false;
                otherLabel.style.display = "none";
            }
      }
	$(document).ready(function () {
    $('#district').on('change', function(){
            var districtId = $(this).val();
            if(districtId){
              $('#otherCampLabel').hide();
              $('#otherCamp').hide().prop('required', false);
                $.ajax({
                    url: '{{ route("fetch.camps") }}',
                    type: 'POST',
                    data: {
                        district_id: districtId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data){
                        $('#camp').empty();
                        $('#camp').append('<option disabled selected value="">Select Camp</option>');
                        $.each(data, function(key, value){
                            $('#camp').append('<option value="'+ value.id +'">'+ value.title +'</option>');
                        });
                        // Add "Other" option
                        $('#camp').append('<option value="other">Other</option>');
                    }
                });
            } else {
                $('#camp').empty();
                $('#camp').append('<option disabled selected value="">Select Camp</option>');


            }
        });

    // Handle change event for the camp dropdown
    $('#camp').on('change', function(){
            var selectValue = $(this).val();
            if (selectValue === "other") {
                $('#otherCampLabel').show();
                $('#otherCamp').show().prop('required', true);
            } else {
                $('#otherCampLabel').hide();
                $('#otherCamp').hide().prop('required', false);
            }
        });

    // Trigger change event for camp dropdown when page loads
    $('#camp').trigger('change');
    // Call the function initially for add new input field for camp name
		showOtherOption();
		// enabling the district dropdown for Role 2
		var roleId = {{ Auth::user()->role_id ?? 'null' }};
		if (roleId === 2) {
			// If role_id is 2, enable the select element
			$('#districtDropdown').prop('disabled', false);
		}

		// Add CBPL Form added
		$("#add_employee_forms").submit(function(e){
			e.preventDefault();
			const fd = new FormData(this);
			$("#add_employee_btns").text('Adding...');
			$.ajax({
				url: '{{ route('cbplactivity.store') }}',
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
						fetchAllTableData();
						$("#add_employee_btns").text('Add CBPL');
						$("#add_employee_forms")[0].reset();
						$("#addNewModal").modal('hide');
						$('body').removeClass('modal-open');
						$('.modal-backdrop').remove();
            $('#otherCampLabel').hide();
            $('#otherCamp').hide().prop('required', false);
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
					$("#add_employee_btns").text('Add Employee');
				}
			});
		});
    function displayValidationErrors(errors) {
        var errorHtml = '<ul>';
        $.each(errors, function (key, value) {
            errorHtml += '<li class="text-danger">' + value + '</li>';
        });
        errorHtml += '</ul>';

        // Append the errors to the element with the id 'validation-errors'
        $('#validation-errors').html(errorHtml);
    }
		// CBPL Form End Here
		// Fetch
		// Fetch CBPL Data
		function fetchAllTableData(){
			$.ajax({
				url: '{{route('fetchCBPL')}}',
				method:'get',
				success: function(res){
					$("#cbpl_parent").html(res);
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
		// End Fetch CBPL
		fetchAllTableData();
		// End Fetch

		// Date Range for CBPL to show only date range data 
		$('#searchForm').submit(function(event) {
			// Prevent default form submission
			event.preventDefault();
			
			// Serialize form data
			var formData = $(this).serialize();
			
			// Add selected district value
			var districtId = $('#districtDropdown').val();
			formData += '&district=' + districtId;
			
			// Send AJAX request
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: formData,
				success: function(response) {
					// Replace the existing table with the new one
					$('#cbpl_parent').html(response);
					
					// Reinitialize DataTable
					$('#dataTableExample').DataTable({
						"paging": true,
						"searching": true,
						"order": [[1, "asc"]]
						// Add other DataTable options here if needed
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});
		// Date Range filter End Here ======================================================
    //                       ----------------------------------------------
    // Search by District Dropdown on the table
    
    let defaultCountActivities = {{$countActivity}};
    let defaultCountMale = {{$countMale}};
    let defaultCountFemale = {{$countFemale}};
    let defaultTotal = {{$total}};
    let defaultcountHostMale = {{$countHostMale}};
    let defaultcountHostFemale = {{$countHostFemale}};
    let defaultcountRefugeesMale = {{$countRefugeesMale}};
    let defaultcountRefugeesFemale = {{$countRefugeesFemale}};
    let defaulttotalHost = {{$totalHost}};
    let defaulttotalRefugees = {{$totalRefugees}};

    let countActivities = {{$countActivity}};
    let countMale = {{$countMale}};
    let countFemale = {{$countFemale}};
    let total = {{$total}};
    // 
    let countHostMale = {{$countHostMale}};
    let countHostFemale = {{$countHostFemale}};
    let countRefugeesMale = {{$countRefugeesMale}};
    let countRefugeesFemale = {{$countRefugeesFemale}};
    let totalHost = {{$totalHost}};
    let totalRefugees = {{$totalRefugees}};
    // Function to update countMale based on selected district
    function updateCountMale(selectedDistrictId) {
      if (selectedDistrictId) {
            $.ajax({
                url: `/getByDistrictBeneficiaryCbpl/${selectedDistrictId}`,
                method: 'GET',
                success: function (data) {
                    countMale = data.countMale;
                    countFemale = data.countFemale;
                    total = data.total;
                    countActivities = data.countActivities;
                    countHostMale = data.countHostMale;
                    countHostFemale = data.countHostFemale;
                    countRefugeesMale = data.countRefugeesMale;
                    countRefugeesFemale = data.countRefugeesFemale;
                    totalHost = data.totalHost;
                    totalRefugees = data.totalRefugees;
                    updateUI(); // Update the UI with the new values
                    fetchTableData(selectedDistrictId); // Fetch and update table data
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        } else {
            // Reset to default values when no district is selected
            total = defaultTotal;
            countMale = defaultCountMale;
            countFemale = defaultCountFemale;
            countActivities = defaultCountActivities;
            countHostMale = defaultcountHostMale;
            countHostFemale = defaultcountHostFemale;
            countRefugeesMale = defaultcountRefugeesMale;
            countRefugeesFemale = defaultcountRefugeesFemale;
            totalHost = defaulttotalHost;
            totalRefugees = defaulttotalRefugees;

            updateUI();
            fetchAllTableData(); // Fetch and update table data for all districts

        }
    }
    // Function to fetch table data based on selected district
      function fetchTableData(selectedDistrictId) {
          $.ajax({
              url: '/fetch-cbpl/' + selectedDistrictId,
              method: 'GET',
              success: function (res) {
                  $("#cbpl_parent").html(res);
                  // Reinitialize DataTable for the updated table data
                  if ($.fn.dataTable.isDataTable('#dataTableExample')) {
                      $('#dataTableExample').DataTable().destroy();
                  }

                  $("#dataTableExample").DataTable({
                      order: [1, 'asc'],
                  });
              },
              error: function (error) {
                  console.error('Error fetching table data:', error);
              }
          });
      }
      function initializeUI() {
        updateUI(); // Use default values on initialization
      }

      // Function to update the UI with the new values
      function updateUI() {
        // Update the HTML elements with the new values
          $('#activitiesCount').text(countActivities);
          $('#maleCount').text(countMale);
          $('#femaleCount').text(countFemale);
          $('#totalCount').text(total);
          // 
          $('#maleHost').html('<b>Host:</b> '  +'[ ' +countHostMale +' ]');
          $('#femaleHost').html('<b>Host:</b> '  +'[ ' +countHostFemale +' ]');
          $('#maleRefugees').html('<b>Refugees:</b> ' +'[ ' +countRefugeesMale +' ]');
          $('#femaleRefugees').html('<b>Refugees:</b> ' +'[ ' +countRefugeesFemale +' ]');
          $('#totalHost').html('<b>Host:</b> '+'[ '  + totalHost +' ]');
          $('#totalRefugees').html('<b>Refugees:</b> ' +'[ '  + totalRefugees +' ]');
      }

      // Event listener for dropdown change
      $('#districtDropdown').change(function () {
        const selectedDistrictId = $(this).val();
        updateCountMale(selectedDistrictId);
      });

    // End Here:=>Search By District Dropdown 
	});
</script>

@endsection