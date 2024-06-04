@extends('employee.employee_dashboard')
@section('employee')
 
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
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Session</h6>
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
                        <h3 class="mb-2">{{$maleCount }}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i data-feather="user" class="icon-md mb-1"></i>
                            <span>+3.3% - year</span>
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
                        <h3 class="mb-2">{{$maleCount }}</h3>
                        <div class="d-flex align-items-baseline">
                          <p class="text-success">
                          <i data-feather="user" class="icon-md mb-1"></i>
                            <span>males - year</span>
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
                        <h3 class="mb-2">{{$femaleCount}}</h3>
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
              <div class="col-md-3 grid-margin stretch-card">
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
                            <span>Total in Session</span>
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
                      <h6 class="card-title">Session Table</h6>
                  </div>
                  <div class="col-md-6 text-end">
                      <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addNewModal">Add News</button>
                  </div>
                </div>
               
                <div class="table-responsive">
                <table id="dataTableExample" class="table table-striped table-bordered">
                    <thead class="table-primary">
                      <tr>
                        <th>Name</th>
                        <th>Father</th>
                        <th>Gender</th>
                        <th>Document</th>
                        <th>Contact</th>
                        <th>District</th>
                        <th>Camp</th>
                        <th>Session</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($awarenessSessions as $session)
                      <tr>
                        <td>{{$session->name}}</td>
                        <td>{{$session->father}}</td>
                        <td>{{$session->gender}}</td>
                        <td> <strong>Acc - </strong> {{$session->document_no}}</td>
                        <td>{{$session->contact}}</td>
                        <td>{{$session->district}}</td>
                        <td>{{$session->camp}}</td>
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
                <h5 class="modal-title" id="addNewModalLabel">Add New Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Customized form or content for adding a new session -->
                <form action="#" method="POST" id="add_employee_form">
                   @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="name" placeholder="Name..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="father" placeholder="Father..." required>
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
                            <select name="district" id="district" class="form-select">
                                <!-- <option value="" selected disabled>Select a district</option> -->
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->district }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="document_no" name="document_no" placeholder="Document No" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="camp" name="camp" placeholder="Camp" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" class="form-control" id="session_date" name="session_date" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



@endsection