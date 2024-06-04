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
						<li class="breadcrumb-item">Legal Service</li>
						<li class="breadcrumb-item active" aria-current="page">Awareness Session</li>
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
                      <h6 class="card-title mb-0">Awareness Sessions</h6>
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
                    @php
                      $countActivity = $activities->count();
                    @endphp
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-1" id = "activitiesCount">{{ $countActivity }}</h3>
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
                          <span style="display: block;" id="maleHost">Host: {{$countHostMale}}</span>
                          <span style="display: block;" id="maleRefugees">Refugess: {{$countRefugeesMale}}</span>
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
                          <span style="display: block;" id="femaleHost">Host: {{$countHostFemale}}</span>
                          <span style="display: block;" id="femaleRefugees">Refugees: {{$countRefugeesFemale}}</span>
                            
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
                          <span style="display: block;" id="totalHost">Host: {{$totalHost}}</span>
                          <span style="display: block;" id="totalRefugees">Refugees: {{$totalRefugees}}</span>
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
                  <!-- Session By District Search -->
                  <!-- {{-- <div class="col-md-2">
                      <select id="districtDropdown" class="form-select form-select-sm">
                          <option value="" selected> -- District -- </option>
                          @foreach ($districts as $district)
                              <option value="{{ $district->id }}">{{ $district->district }}</option>
                          @endforeach
                      </select>
                  </div> --}} -->
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
                    <form id="searchForm" action="{{ route('search.awrenessactivities') }}" method="POST">
                          @csrf 
                          <div class="form-group row">
                              <label for="date" class="col-form-label col-sm-1">From</label>
                              <div class="col-sm-3">
                                  <input type="date" class="form-control input-sm" name="fromDate" id="fromDate" required>
                              </div>
                              <label for="date" class="col-form-label col-sm-1">To</label>
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
                    <!-- @if (Auth::user()->role_id === 2) -->
                        <a href="{{ route('excel.export') }}">
                            <button type="button" class="btn btn-success btn-icon-text mb-2">
                                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                Excel
                            </button>
                        </a>
                  
                      <button class="btn mb-2" style="background-color: #AA2F33;" data-bs-toggle="modal" data-bs-target="#">
                          <i class="btn-icon-prepend fas fa-file-pdf" style="color: white;"></i>  <span style="color: #ffff;">&nbsp; PDF</span>
                      </button>
                    <!-- @endif -->
                      <!-- <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal"><i class="btn-icon-prepend" data-feather="download-cloud"></i></button> -->
                      <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal">Create Sessions</button>
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
                <h5 class="modal-title" id="addNewModalLabel">Create Awareness Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="validation-errors"></div>
                <form action="#" method="POST" id="add_employee_forms" data-storing-route="{{ route('activities.store') }}" data-success-message="Activity's Added Successfully!" enctype="multipart/form-data">
                   @csrf
                   <!-- Date and District Start -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                        <i data-feather="calendar" class="icon-md mb-1"></i> <label for="date" class="mb-1"><strong> &nbsp; Session Date</strong></label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <i data-feather="map-pin" class="icon-md mb-1"></i>
                          <label for="district" class="mb-1"><strong> &nbsp; District</strong></label>
                          <select class="form-select" id="district" name="district" required >
                              <option disabled selected value="">Select District</option>
                              @foreach($districts as $district)
                                  <option value="{{ $district->id }}">{{ $district->district }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <!-- Date and District Ends -->
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

                    <!-- Conducted and Participants Start -->
                    <div class="row">
                  <!-- <div class="col-md-3 mb-3">
                            <i data-feather="user" class="icon-md mb-1"></i>
                            <label for="conduct" class="mb-1"><strong> &nbsp; Conducted By</strong></label>
                            <select class="form-select" id="conduct" name="conduct" required >
                                <option disabled selected value="">-- Conducted By --</option>
                                @foreach($project_participants as $proj_participants)
                                <option value="{{ $proj_participants->id }}">{{ strip_tags($proj_participants->participant_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i data-feather="users" class="icon-md mb-1"></i>
                            <label for="teammembers" class="mb-1"><strong>&nbsp; Team Members</strong></label>
                            <select class="select2 tags form-select" id="tags" name="tags[]" multiple="multiple" required style="width: 100%; border: 1px solid #d3d3d3; height: 1.5rem;"></select>
                        </div> -->
                        <div class="col-md-12 mb-3">
                          <i data-feather="users" class="icon-md mb-1"></i>
                          <label for="teammembers" class="mb-1"><strong> &nbsp; Team Members*</strong></label><br>
                          <select name="title[]" id="favorite-cars" class="form-control w-100" multiple="multiple" required>
                            @foreach($ds as $proj_participants)
                              <option value="{{ $proj_participants->participant_name }}">{{ $proj_participants->participant_name }}<span>*</span> <br> </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <!-- Conducted and Participants Start -->
                      <div class="row" id="otherParticipantFields" style="display: none;">
                          <div class="col-md-5 mb-3">
                              <label for="other_participant_name[]" class="mb-1"> &nbsp; Name*</label>
                              <input type="text" class="form-control other_participant_name" name="other_participant_name[]">
                          </div>
                          <div class="col-md-5 mb-3">
                              <label for="other_participant_designation[]" class="form-label mb-1"> &nbsp; Designation*</label>
                              <input type="text" class="form-control other_participant_designation" name="other_participant_designation[]">
                          </div>
                          <div class="col-md-2 text-end">
                              <label  class="mb-1" style="color: white;"> &nbsp; Name*</label>
                              <button type="button" class="btn btn-sm btn-primary" id="addMoreFields"><i data-feather="plus-circle" class="icon-md"></i></button>
                          </div>
                      </div>
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                   <!-- Conducted and Participants Ends plus-circle -->
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
<!-- Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #8B0000;">
        <h5 class="modal-title" id="errorModalLabel">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-danger">Oops! Looks like you missed something.</p>
        <p>Please fill in both the <strong>Name</strong> and <strong>Designation</strong> fields before adding another.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
  //  here to past the script data after working

  $(document).ready(function () {
  //   $('#tags').on('change', function() {
  //   var selectedValues = $(this).val();
  //   console.log('Selected Values:', selectedValues);
  //   });
        $('#favorite-cars').select2({
            dropdownParent: $('#addNewModal'),
            placeholder: 'Team Members',
            allowClear: false,
            multiple: true,
            width: '100%',
            tags: true, // Enable tags
            tokenSeparators: [',', ' '],
        }).on('select2:select', function (e) {
            var selectedId = e.params.data.id;
        });

  //   if ($.fn.select2) {
  //     $('#tags').select2({
  //         dropdownParent: $('#addNewModal'),
  //         placeholder: 'Team Members',
  //         allowClear: false,
  //         multiple: true,
  //         tags: true, // Enable tags
  //         tokenSeparators: [',', ' '],
  //         ajax: {
  //             url: "{{ route('get-teammember') }}",
  //             type: "POST",
  //             dataType: 'json',
  //             delay: 450,
  //             data: function(params) {
          
  //                 if (!params.term) {
  //                     return {
  //                         "_token": "{{ csrf_token() }}",
  //                         all: true
  //                     };
  //                 }
  //                 return {
  //                     name: params.term,
  //                     "_token": "{{ csrf_token() }}"
  //                 };
  //             },
  //             processResults: function(data) {
     
  //                 var results = $.map(data, function(item) {
  //                     return {
  //                         id: item.id,
  //                         text: item.participant_name,
  //                         class: 'selected-from-db' // Add custom class for tags from database
  //                     };
  //                 });

  //                 // Display first two results by default
  //                 var defaultResults = results.slice(0, 2);

  //                 return {
  //                     results: defaultResults
  //                 };
  //             },
  //         },
  //         minimumInputLength: 0,
  //         escapeMarkup: function (markup) {
  //             return markup;
  //         },
  //         createTag: function(params) {

  //             var term = $.trim(params.term);
  //             if (term === '') {
  //                 return null;
  //             }
  //             return {
  //                 id: term,
  //                 text: term,
  //                 class: 'custom-tag' // Add custom class for custom tags
  //             };
  //         },
  //         language: {
  //             searching: function () {
  //                 return '';
  //             }
  //         }
  //     }).on('select2:select', function (e) {
  //         var selectedId = e.params.data.id;
  //         // $(this).find('option[value="' + selectedId + '"]').attr('disabled', true);
  //     });
  // } else {
  //     console.error('Select2 is not available.');
  // }

   // Participants of Other entries
    //  var maxFields = 2;
    //     var addedFields = 0;
    // $('#teammembers').change(function() {
    //         if ($(this).val() === 'other') {
    //             $('#otherParticipantFields').show();
    //             $('.other_participant_name').attr('required', 'required');
    //             $('.other_participant_designation').attr('required', 'required');
    //         } else {
    //             $('#otherParticipantFields').hide();
    //             $('.other_participant_name').removeAttr('required');
    //             $('.other_participant_designation').removeAttr('required');
    //         }
    //     });

    //     $('#addMoreFields').click(function() {
    //         if (addedFields < maxFields) {
    //             var lastFields = $('#otherParticipantFields').find('.col-md-5:last');
    //             // Check if both last fields are empty
    //             var isEmpty = true;
    //             lastFields.find('input').each(function() {
    //                 if ($(this).val().trim() !== '') {
    //                     isEmpty = false;
    //                     return false; // Exit loop early
    //                 }
    //             });

    //             if (!isEmpty) {
    //               var cloneFirstFields = $('#otherParticipantFields').find('.col-md-5').first().clone();
    //             var cloneLastFields = $('#otherParticipantFields').find('.col-md-5').last().clone();
    //             cloneFirstFields.find('.other_participant_name').val('');
    //             cloneFirstFields.find('.other_participant_designation').val('');
    //             cloneLastFields.find('.other_participant_name').val('');
    //             cloneLastFields.find('.other_participant_designation').val('');
    //             $('#otherParticipantFields').append(cloneFirstFields);
    //             $('#otherParticipantFields').append(cloneLastFields);
    //                 addedFields++;

    //                 if (addedFields === maxFields) {
    //                     $('#addMoreFields').attr('disabled', 'disabled');
    //                 }
    //             } else {
    //                 // Both fields are empty, do nothing
    //                 $('#errorModal').modal('show');
    //             }
    //         }
    //     });
        // END HERE
    $('#district').on('change', function(){
            var districtId = $(this).val();
            if(districtId){
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

        $('#camp').on('change', function(){
            var selectedCamp = $(this).val();
        });
    var roleId = {{ Auth::user()->role_id ?? 'null' }};
    if (roleId === 2) {
        // If role_id is 2, enable the select element
        $('#districtDropdown').prop('disabled', false);
    }
    // Call the function initially when the document is ready
    showOtherOption();
    // fetch
    function fetchAllTableDataa(){
      $.ajax({
        url: '{{route('fetchAwarenessSession')}}',
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
                $('#show_alls').html(response);
                
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

    // 
    $("#add_employee_forms").submit(function(e){
        e.preventDefault();
        const fd = new FormData(this);
        for (let entry of fd.entries()) {
            const [name, value] = entry;
            console.log(name, value);
          }
        $("#add_employee_btns").text('Adding...');
        $.ajax({
            url: '{{ route('activities.store') }}',
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
                    $("#add_employee_btns").text('Add Employee');
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
                url: `/getDistrictGenderCounts/${selectedDistrictId}`,
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
            fetchAllTableDataa(); // Fetch and update table data for all districts

        }
    }
    // Function to fetch table data based on selected district
      function fetchTableData(selectedDistrictId) {
          $.ajax({
              url: '/fetch-awareness-session/' + selectedDistrictId,
              method: 'GET',
              success: function (res) {
                  $("#show_alls").html(res);
                  // Reinitialize DataTable for the updated table data
                  if ($.fn.dataTable.isDataTable('#dataTableExample')) {
                      $('#dataTableExample').DataTable().destroy();
                  }

                  $("#dataTableExample").DataTable({
                      order: [2, 'asc'],
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

    // Optional Image Initial UI update 
    initializeUI();
      function addImageInput() {
          var imageContainer = document.getElementById('image-container');

          // Create a new div element with the specified HTML code
          var optionalImageDiv = document.createElement('div');
          optionalImageDiv.className = 'row';
          optionalImageDiv.innerHTML = '<div class="col-md-12 mt-3">' +
                                        '<div class="form-group id="image-container-optional">' +
                                        '<i data-feather="image" class="icon-md mb-1"></i> <label for="optional-images" class="form-label"><strong>  &nbsp; Other Images<strong/></label>' +
                                        '<input type="file" name="optional_images[]" class="form-control" accept="image/*">' +
                                        '</div>' +
                                        '</div>';

          // Append the new div element to the container
          imageContainer.appendChild(optionalImageDiv);
          // Initialize Feather Icons after adding the new content
          feather.replace();
      }

  });
 

</script>
@endsection
