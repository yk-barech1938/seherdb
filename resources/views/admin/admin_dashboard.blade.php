<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<title>Admin Panel - Seher</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->
	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('../assets/vendors/core/core.css')}}">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' /> -->
	<link rel="stylesheet" href="{{asset('../../../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css')}}">
	<!-- End plugin css for this page -->



	<!-- Plugin css for this page -->
	<link rel="stylesheet" href="{{asset('../assets/vendors/flatpickr/flatpickr.min.css')}}">
	<!-- End plugin css for this page -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{asset('../assets/fonts/feather-font/css/iconfont.css')}}">
	<link rel="stylesheet" href="{{asset('../assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
	<!-- endinject -->

  <!-- Layout styles -->  
	<link rel="stylesheet" href="{{asset('../assets/css/demo1/style.css')}}">
  <!-- End layout styles -->
  
  <link rel="shortcut icon" href="{{asset('../assets/images/favicon.png')}}" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
<!-- Add this line in the <head> section of your HTML document -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

 
</head>
<body>
	<div class="main-wrapper">

		<!-- partial:partials/_sidebar.html -->
		@include('admin.body.sidebar')
		<!-- partial -->
	
		<div class="page-wrapper">
			@include('admin.body.header')
			<!-- partial -->

			@yield('admin')

			<!-- partial:partials/_footer.html -->
			@include('admin.body.footer')
			<!-- partial -->
		
		</div>
	</div>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="{{asset('../assets/vendors/core/core.js')}}"></script>
	<script src="{{asset('../assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
	<script src="{{asset('../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js')}}"></script>
	<script src="{{asset('../assets/vendors/flatpickr/flatpickr.min.js')}}"></script>
	<script src="{{asset('../assets/vendors/apexcharts/apexcharts.min.js')}}"></script>
	<script src="{{asset('../assets/vendors/feather-icons/feather.min.js')}}"></script>
	<script src="{{asset('../assets/js/template.js')}}"></script>
	<script src="{{asset('../assets/js/dashboard-light.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="{{asset('../assets/js/data-table.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

      var fetchUrl = '{{ route('admin.fetchAllAwareness') }}';
          fetchAllTableData();
          function fetchAllTableData() {
          $.ajax({
              url: fetchUrl, // Use the variable here
              method: 'get',
              success: function (res) {
                  $("#show_all").html(res);

                  // Check if DataTable is already initialized on the table
                  if ($.fn.dataTable.isDataTable('#dataTableExample')) {
                      $('#dataTableExample').DataTable().destroy();
                  }

                  $("#dataTableExample").DataTable({
                      responsive: true,
                      order: [0, 'asc'],
                  });
              }
          });
      }
      // Function to change the fetch URL based on the current page
      function updateFetchUrl(url) {
          fetchUrl = url;
          fetchAllTableData(); // Fetch data with the new URL
      }
      $(document).ready(function () {
          updateFetchUrl('{{ route('admin.fetchAllAwareness') }}'); // Initial fetch
      });
      // UPDATE Session Request
      $("#edit_employee_form").submit(function (e) {
          e.preventDefault();
          $("#edit_employee_btn").text('Updating...');
          const formData = new FormData(this);
          if ($('#editEmployeeModal').hasClass('show')) {
              $('#editEmployeeModal').modal('hide');
          }
          $.ajax({
              url: '{{ route('admin.awarenessUpdate') }}',
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function (res) {
                  if (res.status == 200) {
                      Swal.fire({
                          title: 'Updated!',
                          text: 'LAS Updated Successfully',
                          icon: 'success',
                      });
                      fetchAllTableData();
                      $('#edit_employee_btn').prop('disabled', false).text('Update LAS');
                      $('#edit_employee_form')[0].reset();
                      $('#editEmployeeModal').modal('hide');
                  }
              }
          });
      });

        // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          $.ajax({
            url: '{{route('admin.awarenessEdit')}}',
            method: 'GET',
            data:{
              id:id,
              _token:'{{csrf_token()}}'
            },
            success:function(res){
              $("#name").val(res.name);
              $("#father").val(res.father);
            // Set the selected gender option based on the received gender_id
              $("#gender option").each(function() {
                  if ($(this).val() == res.gender_id) {
                      $(this).prop("selected", true);
                  } else {
                      $(this).prop("selected", false);
                  }
              });
              $("#document_no").val(res.document_no);
              $("#contact").val(res.contact);
              // Set the selected district option based on the received district_id
              $("#district option").each(function() {
                  if ($(this).val() == res.district_id) {
                      $(this).prop("selected", true);
                  } else {
                      $(this).prop("selected", false);
                  }
              });
              $("#camp").val(res.camp);
              // Assuming res.session_date is in the format 'DD/MM/YYYY'
              var parts = res.session_date.trim().split('-');


                if (parts.length === 3) {
                  var datePart = parts[2].split(' ')[0];

                  var originalDate = new Date(parts[0], parts[1] - 1, datePart);

                  var nextDay = new Date(originalDate);
                  nextDay.setDate(originalDate.getDate() + 1);

                  // Check if the Date object is valid
                  if (!isNaN(nextDay.getTime())) {
                    console.log(nextDay.toISOString().split('T')[0]);
                  } else {
                    console.log("Invalid Date");
                  }
                } else {
                  console.log("Invalid date format");
                }
              var formattedDates = nextDay.toISOString().split('T')[0];
              $("#session_date").val(formattedDates);
              $("#id").val(res.id);
            }
          });
        
        });


      // Update the URL when navigating to the awareness session page
      // $(document).on('click', '.nav-link[href="{{ route('admin.legal.awareness') }}"]', function (e) {
      //     e.preventDefault();
      //     updateFetchUrl('{{ route('admin.fetchAllAwareness') }}');
      // });

        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch(type){
        case 'info':
        toastr.info(" {{ Session::get('message') }} ");
        break;

        case 'success':
        toastr.success(" {{ Session::get('message') }} ");
        break;

        case 'warning':
        toastr.warning(" {{ Session::get('message') }} ");
        break;

        case 'error':
        toastr.error(" {{ Session::get('message') }} ");
        break; 
        }
        @endif 
</script>

</body>
</html>    