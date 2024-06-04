@extends('employee.employee_dashboard')
@section('employee')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('../assets/css/demo1/custom-select2.css')}}">
<style>
  .error {
    color: rgba(201, 9, 9, 0.829); /* Change to your preferred color */
    font-size: 14px;
    margin-top: 5px;
    display: none;
}

.error-active {
    display: block;
}
</style>
	<!-- End custom js for this page -->
			<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">ALAC</li>
						<li class="breadcrumb-item active" aria-current="page">Helpline Calls</li>
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
                        <h3 class="mb-2"></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i class="fa fa-male" aria-hidden="true" ></i>
                           
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
                        <h3 class="mb-2"></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="user" class="icon-md mb-1"></i> -->
                          <i class="fa fa-female" aria-hidden="true"></i>
                          
                            
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
                        <h3 class="mb-2"></h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="users" class="icon-sm mb-1"></i> -->
                          <i class="fa fa-users" aria-hidden="true"></i>
                          
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
                      <h6 class="card-title">Helpline Calls - ALAC</h6>
                  </div>
                  <div class="col-md-6 text-end">
                      <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal">Add Beneficiary</button>
                  </div>
                </div>
               
                <div class="table-responsive">
                <table id="dataTableExample" class="table table-striped table-bordered">
                    <thead style="background-color: #6571ff;">
                      <tr>
                        <th style="color: #f8f8ff;">DateTime</th>
                        <th style="color: #f8f8ff;">Type</th>
                        <th style="color: #f8f8ff;">Caller</th>
                        <th style="color: #f8f8ff;">Father</th>
                        <th style="color: #f8f8ff;">Gender</th>
                        <th style="color: #f8f8ff;">Family Size</th>
                        <th style="color: #f8f8ff;">Adult</th>
                        <th style="color: #f8f8ff;">Card Holder</th>
                        <th style="color: #f8f8ff;">Present Address</th>
                        <th style="color: #f8f8ff;">COO</th>
                        <!-- <th style="color: #f8f8ff;">Arrival Date</th> -->
                        <th style="color: #f8f8ff;">Contact</th>
                        <th style="color: #f8f8ff;">Issue</th>
                        <th style="color: #f8f8ff;">Alac Response</th>
                        <!-- <th style="color: #f8f8ff;">Created By</th> -->
                        <th style="color: #f8f8ff;">User</th>
                      </tr>
                    </thead>
                    <tbody>
                          @foreach($activityCalls as $calls)
                            <tr>
                                <td data-sort="{{ \Carbon\Carbon::parse($calls->call_datetime)->format('Y-m-d H:i:s') }}">
                                <strong> {{ \Carbon\Carbon::parse($calls->call_datetime)->format('d-m-Y H:i:s') }} </strong>
                                </td>
                                <td>{{ $calls->respondent }}</td>
                                <td>{{ $calls->caller_name }}</td>
                                <td>{{ $calls->father }}</td>
                                <td>{{ $calls->gender }}</td>
                                <td>{{ $calls->family_size }}</td>
                                <td>{{ $calls->adultmember }}</td>
                                <td>{{ $calls->card_holder }}</td>
                                <td>{{ $calls->pre_address }}</td>
                                <td>{{ $calls->address_coo }}</td>
                                <!-- <td data-sort="{{ \Carbon\Carbon::parse($calls->arrival_date)->format('Y-m-d') }}">
                                    {{ \Carbon\Carbon::parse($calls->arrival_date)->format('d-m-Y') }}
                                </td> -->
                                <td>{{ $calls->contact }}</td>
                                <td>{{ $calls->issue }}</td>
                                <td>{{ $calls->response_alac }}</td>
                                <td>{{ $calls->user->name }}</td>
                            </tr>
                          @endforeach
                    </tbody>
                  </table>
               
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
                <h5 class="modal-title" id="addNewModalLabel">Add  Caller's Details </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Customized form or content for adding a new session -->
                <form action="#" method="POST" id="add_participants_awareness" class="needs-validation">
                    <!-- @csrf -->
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="caller_name" name="caller_name" placeholder="Caller Name" required>
                            <div id="error-message" class="error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="father" name="father" placeholder="Father/Husband" required>
                            <div id="error-message" class="error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled required selected>-- Gender --</option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select name="card_holder" id="card_holder" class="form-select">
                                <option value="" disabled required selected>-- Card Holder -- </option>
                                <option value="0">POR</option>
                                <option value="1">NoN-POR</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <select name="present" id="present" class="form-control w-100" multiple="multiple" required>
                            <option value="" disabled required selected>-- Present --</option>
                            @foreach($addresses as $address)
                              <option value="{{ $address['address'] }}">{{ $address['address'] }}<span>*</span> <br> </option>
                            @endforeach
                          </select>
                            <div id="error-message" class="error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="coo" name="coo" placeholder="Country of Origin" required>
                            <div id="error-message" class="error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control" id="familysize" name="familysize" min="0" maxlength="2" placeholder="Family Size" required>
                            <div id="error-message" class="error"></div>
                        </div>
                        <script>
                            document.getElementById("familysize").addEventListener("input", function() {
                                if (this.value.length > 2) {
                                    this.value = this.value.slice(0, 2);
                                }
                            });
                        </script>
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control" id="adultmember" name="adultmember" min="0" maxlength="2" placeholder="Adult Member" required>
                            <div id="error-message" class="error"></div>
                        </div>
                        <script>
                            document.getElementById("adultmember").addEventListener("input", function() {
                                if (this.value.length > 2) {
                                    this.value = this.value.slice(0, 2);
                                }
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <select name="calltype" id="calltype" class="form-select">
                                <option value="" disabled required selected>-- Intake/Hot --</option>
                                <option value="Hotline">Hotline</option>
                                <option value="Intake">Intake</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="number" class="form-control" id="contact" name="contact" placeholder="03123456789" min="0" maxlength="11" required>
                            <div id="error-message" class="error"></div>
                        </div>
                        <script>
                            document.getElementById("contact").addEventListener("input", function() {
                                if (this.value.length > 11) {
                                    this.value = this.value.slice(0, 11);
                                }
                            });
                        </script>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <select name="issue" id="issue" class="form-select">
                                <option value="" disabled required selected>-- Issue --</option>
                                @foreach($issueResponses as $issue)
                                <option value="{{$issue->id}}">{{$issue->issue}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <select name="response" id="response" class="form-select" disabled>
                              <option value="" disabled required selected>-- Response ALAC -- </option>
                          </select>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="add_employee_btns" class="btn btn-primary">Add Caller</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
  $('#present').select2({
      dropdownParent: $('#addNewModal'),
      placeholder: 'Present Address',
      allowClear: true,
      multiple: false,
      width: '100%',
      tags: true, // Enable tags
      tokenSeparators: [','], // Remove space from token separators
      createTag: function (params) {
        var term = $.trim(params.term);
        if (term === '') {
          return null;
        }
        // Capitalize the first letter of each word
        var capitalizedTerm = term.replace(/\b\w/g, function (char) {
          return char.toUpperCase();
        });
        return {
          id: capitalizedTerm,
          text: capitalizedTerm,
          newTag: true // add additional parameters
        }
      }
    }).on('select2:select', function (e) {
      var selectedId = e.params.data.id;
    });
  // Issue and Response data 
  $('#issue').on('change', function() {
            var selectedIssueId = $(this).val();
            var responseDropdown = $('#response');
            responseDropdown.empty(); // Clear existing options
            if (selectedIssueId) {
                // Make an AJAX request to fetch responses corresponding to the selected issue
                $.ajax({
                    url: '/get-responses',
                    type: 'GET',
                    data: { issueId: selectedIssueId },
                    success: function(response) {
                        // Update the response dropdown with the fetched responses
                        responseDropdown.empty(); // Clear existing options
                        $.each(response, function(index, responseData) {
                            responseDropdown.append($('<option></option>').attr('value', responseData.id).text(responseData.response));
                        });
                        responseDropdown.prop('disabled', false); // Enable the response dropdown
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching responses:', error);
                    }
                });
            } else {
                // If no issue is selected, disable the response dropdown
                responseDropdown.empty().prop('disabled', true);
            }
        });
    // validation
    $('#add_employee_btns').click(function(e){
        // Prevent the form from submitting
        e.preventDefault();

        // Clear previous error messages
        $('.error').text('').removeClass('error-active');

        // Define custom error messages
        var errorMessages = {
            'caller_name': 'Please enter the Name.',
            'father': 'Please enter Father\'s name.',
            'present': 'Please enter Present Address.',
            'coo': 'Please enter Country of Origin.',
            'familysize': 'Please enter Country of Origin.',
            'contact': 'Please enter Contact.',


        };

        // Check if any field is empty or contact length is not 10
        var isValid = true;
        $('input[type="text"], select').each(function(){
            if($(this).val() === ''){
                isValid = false;
                var fieldName = $(this).attr('name');
                var errorMessage = errorMessages[fieldName];
                $(this).next('.error').text(errorMessage).addClass('error-active');
            } else if ($(this).attr('name') === 'contact' && !$(this).prop('disabled') && $(this).val().length !== 11) {
              isValid = false;
              $(this).next('.error').text(errorMessages['contact']).addClass('error-active');
            } 
        });
        // If any field is empty or contact length is not 10, prevent form submission
        if(!isValid){
            return false;
        }

        // If all fields are filled and contact length is 10, submit the form
        $('#add_participants_awareness').submit();
    });
    $("#add_participants_awareness").submit(function(e){
        e.preventDefault();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log('CSRF Token:', csrfToken);

        const fd = new FormData(this);
        fd.append('_token', csrfToken);
        // Disable the button to prevent multiple submissions
        $("#add_employee_btns").prop('disabled', true).text('Adding...');
        // $("#add_employee_btns").text('Adding...');

        console.log('Adding Run');
        $.ajax({
          url: '{{ route('helplinecalls.callers') }}',
          method: 'POST',  // Ensure that the method is set to POST
          data: fd,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
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
                    );
                } else {
                  Swal.fire({
                    title: 'Errors',
                    html: res.errors,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                }
                // Enable the button and reset form after successful submission
                $("#add_employee_btns").prop('disabled', false).text('Add Beneficiary');
                // $("#add_employee_btns").text('Add Beneficiary');
                $("#add_participants_awareness")[0].reset();
                $("#addNewModal").modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            },
            error: function(xhr, status, error) {
              console.error('Ajax request failed', xhr, status, error);

                // Handle the error based on the status code or other information
                if (xhr.status === 419) {
                    Swal.fire(
                        'CSRF Token Mismatch!',
                        'Please refresh the page and try again.',
                        'error'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'An unexpected error occurred.',
                        'error'
                    );
                }
            }
        });
    });
  });

</script>
@endsection