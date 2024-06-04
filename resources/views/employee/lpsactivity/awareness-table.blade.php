@extends('employee.employee_dashboard')
@section('employee')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
						<li class="breadcrumb-item">Legal Service</li>
						<li class="breadcrumb-item active" aria-current="page">Awareness Session</li>
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
                    @php
                      $maleSessions = $awarenessSessions->where('gender', 'Male');
                      $maleCount = $maleSessions->count();

                      $femaleSessions = $awarenessSessions->where('gender', 'Female');
                      $femaleCount = $femaleSessions->count();
                      $total =  $maleCount + $femaleCount;
                    @endphp
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$maleCount}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i class="fa fa-male" aria-hidden="true" ></i>
                            <span style="display: block;"><strong>Host:</strong> [ {{$countHostMale}} ]</span>
                            <span style="display: block;"><strong>Refugees:</strong> [ {{$countRefugeesMale}} ]</span>
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
                        <h3 class="mb-2">{{$femaleCount}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="user" class="icon-md mb-1"></i> -->
                          <i class="fa fa-female" aria-hidden="true"></i>
                          <span style="display: block;"><strong>Host:</strong> [ {{$countHostFemale}} ]</span>
                          <span style="display: block;"><strong>Refugees:</strong> [ {{$countRefugeesFemale}} ]</span>
                            
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
                        <h3 class="mb-2">{{$total}}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <!-- <i data-feather="users" class="icon-sm mb-1"></i> -->
                          <i class="fa fa-users" aria-hidden="true"></i>
                          <span style="display: block;"><strong>Host:</strong> [ {{$totalHosts}} ]</span>
                          <span style="display: block;"><strong>Refugees:</strong> [ {{$totalRefugees}} ]</span>
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
                      <h6 class="card-title">{{$title}}</h6>
                  </div>
                  <div class="col-md-6 text-end">
                      <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal">Add Beneficiary</button>
                  </div>
                </div>
               
                <div class="table-responsive">
                <table id="dataTableExample" class="table table-striped table-bordered">
                    <thead style="background-color: #6571ff;">
                      <tr>
                        <th style="color: #f8f8ff;">Name</th>
                        <th style="color: #f8f8ff;">Father</th>
                        <th style="color: #f8f8ff;">Gender</th>
                        <th style="color: #f8f8ff;">Identity</th>
                        <th style="color: #f8f8ff;">Contact</th>
                        <th style="color: #f8f8ff;">District</th>
                        <th style="color: #f8f8ff;">Camp</th>
                        <th style="color: #f8f8ff;">Session</th>
                      </tr>
                    </thead>
                    <tbody>
                          @foreach($awarenessSessions as $session)
                            <tr>
                                <td>{{ $session->name }}</td>
                                <td>{{ $session->father }}</td>
                                <td>{{ $session->gender }}</td>
                                <td><strong>{{$session->identity_code}} - </strong>{{$session->document_no}}</td>
                                <td>{{ $session->contact }}</td>
                                <td>{{ $session->district }}</td>
                                <td>{{ $session->camp }}</td>
                                <td data-sort="{{ \Carbon\Carbon::parse($session->session_date)->format('Y-m-d') }}">
                                    {{ \Carbon\Carbon::parse($session->session_date)->format('d-m-Y') }}
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

			</div>
<!-- Enhanced Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNewModalLabel">Add {{$title}} Beneficiary </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Customized form or content for adding a new session -->
                <form action="#" method="POST" id="add_participants_awareness" class="needs-validation">
                    <!-- @csrf -->
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="name" name = "name" placeholder="Name..." required>
                            <div id="error-message" class="error"></div>
                          </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="father" name="father" placeholder="Father..." required>
                            <div id="error-message" class="error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                          <select name="gender" id="gender" class="form-select">
                          @foreach ($genders as $gender)
                            <option value="{{$gender->id}}">{{$gender->gender}}</option>
                             @endforeach
                          </select>

                            <!-- <input type="text" class="form-control" id="gender" placeholder="Gender..." required> -->
                        </div>
                        <div class="col-md-6 mb-3">
                          <select name="nationality" id="nationality" class="form-select">
                          <option value="" disabled selected style="color: gray;">-- Select Nationality --</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Afghanistan">Afghanistan</option>
                            {{-- <option value="Other">Other</option> --}}
                          </select>
                          <div id="error-message" class="error"></div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <select name="identity_code" id="identity_code" class="form-select">
                            <option value="">-- Identity Code --</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          {{-- <input type="text" class="form-control" id="document_no" name="document_no" placeholder="Identity Number" required disabled> --}}
                          <input type="text" class="form-control" id="identity" name="identity" placeholder="(xxxxx-xxxxxxx-x)" disabled>
                          <div id="error-message" class="error"></div>
                          <div id="default-message" class="default"></div>

                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <select name="countrycode" id="countrycode" class="form-select">
                          <option value="" class="text-light">-- Country Code --</option>
                          <option value="+92" data-icon="🇵🇰">Pakistan (+92)</option>
                          <option value="+93" data-icon="🇦🇫">Afghanistan (+93)</option>
                          <option value="+98" data-icon="🇮🇷">Iran (+98)</option>
                          <option value="N/A">N/A</option>
                          <!-- Add more countries if needed -->
                      </select>
                      <div id="error-message" class="error"></div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="312-1324567" required>
                        <div id="error-message" class="error"></div>
                    </div>

                    </div>

                    {{-- <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="camp" name="camp" placeholder="Camp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="session_date" name="session_date" required>
                        </div>
                    </div> --}}

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="add_employee_btns" class="btn btn-primary">Add Beneficiary</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#add_employee_btns').click(function(e){
        // Prevent the form from submitting
        e.preventDefault();

        // Clear previous error messages
        $('.error').text('').removeClass('error-active');

        // Define custom error messages
        var errorMessages = {
            'name': 'Please enter the name.',
            'father': 'Please enter father\'s name.',
            'identity': 'Invalid Identity Number',
            'countrycode': 'Please select country code.',
            'contact': 'Invalid Phone Number.',
            'POR': 'Invalid POR Number',
            'ACC': 'Invalid ACC Number'
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
            } else if ($(this).attr('name') === 'identity') {
                var identityType = $('#identity_code').val();
                if (identityType === 'CNIC' && $(this).val().length !== 15) {
                    isValid = false;
                    $(this).next('.error').text(errorMessages['identity']).addClass('error-active');
                } else if ((identityType === 'POR' || identityType === 'ACC') && $(this).val().length !== 11) {
                    isValid = false;
                    $(this).next('.error').text(errorMessages[identityType]).addClass('error-active');
                }
            }
        });
        // If any field is empty or contact length is not 10, prevent form submission
        if(!isValid){
            return false;
        }

        // If all fields are filled and contact length is 10, submit the form
        $('#add_participants_awareness').submit();
    });
});
  // Country Code disabled
  $('#countrycode').change(function() {
      var countryCode = $(this).val();
      if (countryCode === 'N/A') {
        $('#contact').val('123-4567890');
        $('#contact').prop('disabled', true);
      } else {
          $('#contact').prop('disabled', false);
          $('#contact').val('');
      }
  });
  $(function(){
    $("#add_participants_awareness").submit(function(e){
        e.preventDefault();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log('CSRF Token:', csrfToken);

        const fd = new FormData(this);
        fd.append('_token', csrfToken);
        $("#add_employee_btns").text('Adding...');
        console.log('Adding Run');
        $.ajax({
          url: '{{ route('awareness.participants') }}',
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
                $("#add_employee_btns").text('Add Beneficiary');
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
   // Get the input element
   var input = document.getElementById('identity');
var identityCodeSelect = document.getElementById('identity_code');

identityCodeSelect.addEventListener('change', function() {
    var selectedOption = identityCodeSelect.options[identityCodeSelect.selectedIndex].value;

    if (selectedOption === 'POR') {
      $('#identity').css('background-color', '');
      $('#default-message').text('').css({
            'font-size': '',
            'color': ''
        });
        input.placeholder = "POR - Number";
        input.value = "";
    } 
    else if(selectedOption === 'ACC'){
      $('#identity').css('background-color', '');
      $('#default-message').text('').css({
            'font-size': '',
            'color': ''
        });
      input.placeholder = "ACC - Number";
      input.value = "";
    }
    else {
        input.placeholder = "xxxxx-xxxxxxx-x";
        input.value = "";
    }
});

input.addEventListener('input', function(event) {
    var identity_code = identityCodeSelect.value;

    if (identity_code === 'CNIC') {
        var inputValue = event.target.value.replace(/\D/g, '');

        var formatPattern = [5, 7, 1]; // This represents the length of each group of numbers
        // Format the value according to the pattern
        var formattedValue = '';
        var currentIndex = 0;
        for (var i = 0; i < formatPattern.length; i++) {
            var currentLength = formatPattern[i];
            var currentSegment = inputValue.substring(currentIndex, currentIndex + currentLength);
            if (currentSegment) {
                formattedValue += currentSegment;
                currentIndex += currentLength;
                if (i < formatPattern.length - 1) {
                    formattedValue += '-';
                }
            }
        }
        event.target.value = formattedValue;
    } else if (identity_code === 'POR' || identity_code === 'ACC') {
        var inputValue = event.target.value.replace(/[^\d]/g, '').substring(0, 11); // Accept only 11 digits
        event.target.value = inputValue;
    }
});
    // Get the input element for Contact
    var inputContact = document.getElementById('contact');
    inputContact.addEventListener('input', function(event) {
      var inputValue = event.target.value.replace(/\D/g, '');

      var formatPattern = [3, 7]; // This represents the length of each group of numbers
      // Format the value according to the pattern
      var formattedValue = '';
      var currentIndex = 0;
      for (var i = 0; i < formatPattern.length; i++) {
          var currentLength = formatPattern[i];
          var currentSegment = inputValue.substring(currentIndex, currentIndex + currentLength);
          if (currentSegment) {
              formattedValue += currentSegment;
              currentIndex += currentLength;
              if (i < formatPattern.length - 1) {
                  formattedValue += '-';
              }
          }
      }
      event.target.value = formattedValue;
  });

    $('#nationality').change(function() {
    var nationality = $(this).val();
    $('#identity_code').empty(); // Clear existing options
    $('#identity').val(''); // Empty the input field

    if (nationality === 'Pakistan') {
        // Add CNIC option
        $('#identity_code').append('<option value="CNIC">CNIC</option>');
    } else if (nationality === 'Afghanistan') {
        // Add POR and ACC options
        $('#identity_code').append('<option value="POR">POR Card</option>');
        $('#identity_code').append('<option value="ACC">ACC</option>');
        $('#identity_code').append('<option value="Undocument">Undocument</option>');
    } 
});
 var identityInput = document.getElementById("identity");
 identityInput.value = "";
function setToNA() {
    identityInput.value = "N/A";
}
$('#nationality, #identity_code').change(function() {
    var nationality = $('#nationality').val();
    var identityCode = $('#identity_code').val();
    var isUndocumented = identityCode === 'Undocument'; // Assuming it's 'Undocument' based on your code snippet

    $('#identity').prop('disabled', nationality === '' || identityCode === '');

    if (nationality === '' || identityCode === '' || isUndocumented) {
        $('#identity').val('00000-0000000-0');
        $('#identity').css('background-color', '#f2f2f2');
        $('#default-message').text('Default N/A Number').css({
              'font-size': 'smaller',
              'color': 'gray'
          });
    }
});
});
</script>
@endsection