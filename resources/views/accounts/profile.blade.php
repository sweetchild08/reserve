
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{$title}}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('limitless/assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('limitless/assets/css/all.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('assets/parsley/parsley.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				
				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">
					
					<!-- Login form -->
					<form class="login-form" method="POST" data-parsley-validate action="{{url('accounts/profile/update')}}">
						@csrf
						<input type="hidden" name="type" value="Profile">
						@if ($errors->any())
							<div class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<span style="display:block">&bull; {{ $error }}</span>
								@endforeach
							</div>
						@endif

						@if (Session::has('message'))
							<div class="alert alert-success">
								{{Session::get('message')}}
							</div>
						@endif
						<div class="card mb-0">

							<div class="card-body">
								<div class="text-center mb-3">
									<i class="icon-user icon-2x text-secondary border-secondary border-3 rounded-pill p-3 mb-3 mt-1"></i>
									<h5 class="mb-0">Profile Management</h5>
									<span class="d-block text-muted">Update your profile here</span>
								</div>

								<div class="form-group">
									<input type="text" name="surname" class="form-control" value="{{$query->surname}}" placeholder="Surname" required>
								</div>

								<div class="form-group">
									<input type="text" name="firstname" class="form-control" value="{{$query->firstname}}" placeholder="First Name" required>
								</div>

								<div class="form-group">
									<input type="text" name="middlename" class="form-control" value="{{$query->middlename}}" placeholder="Middle Name">
								</div>

								{{-- <div class="form-group">
									<select class="form-control" id="regionCode">
										<option value="">Region</option>
										@foreach($regions as $region)
										<option value="{{$region->regCode}}">{{$region->regDesc}}</option>
										@endforeach
									</select>
								</div>


								<div class="form-group">
									<select class="form-control" id="regCode" disabled></select>
								</div>

								<div class="form-group">
									<select class="form-control" id="provCode" disabled></select>
								</div>

								<div class="form-group">
									<select class="form-control" id="citymunCode" disabled></select>
								</div> --}}

								<div class="form-group">
									<input type="text" name="province" class="form-control" value="{{$query->province}}" placeholder="Province" required>
								</div>

								<div class="form-group">
									<input type="text" name="city" class="form-control" value="{{$query->city}}" placeholder="City" required>
								</div>
								
								<div class="form-group">
									<input type="text" name="barangay" class="form-control" value="{{$query->barangay}}" placeholder="Barangay" required>
								</div>

								<div class="form-group">
									<input type="text" name="address" class="form-control" value="{{$query->address}}" placeholder="Address" required>
								</div>

								<div class="form-group">
									<input type="email" class="form-control" name="email" value="{{$query->email}}" placeholder="Email Address" required>
								</div>

								<div class="form-group">
									<input type="text" class="form-control" name="contact" value="{{$query->contact}}" placeholder="Contact" required>
								</div>


								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
								</div>

								<div class="text-center">
									<a href="{{url('accounts/my-reservation')}}" class="btn btn-light btn-block">Back</a>
								</div>

							</div>
						</div>
					</form>
					<!-- /login form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
<!-- Core JS files -->
<script src="{{url('limitless/assets/js/main/jquery.min.js')}}"></script>
<script src="{{url('limitless/assets/js/main/bootstrap.bundle.min.js')}}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="{{url('limitless/assets/js/app.js')}}"></script>
<script src="{{url('assets/parsley/parsley.min.js')}}"></script>
<!-- /theme JS files -->
<script>
	// $('#regionCode').change( e => {
	// 	var regionCode = $('#regionCode').val();
	// 	$.ajax({
	// 		type:'POST',
	// 		url: "{{url('get-provinces')}}",
	// 		dataType:'JSON',
	// 		data: {
	// 			'_token'  : '{{csrf_token()}}',
	// 			regionCode : regionCode
	// 		},
	// 		success:function(data) {
	// 			$('#regCode').attr('disabled',false).find('option').remove();
	// 			$.each( data, function(key, val) {
	// 				$('#regCode').append('<option value="'+val.provCode+'">'+val.provDesc+'</option>');
	// 				$.ajax({
	// 					type:'POST',
	// 					url: "{{url('get-cities')}}",
	// 					dataType:'JSON',
	// 					data: {
	// 						'_token'  : '{{csrf_token()}}',
	// 						provCode : val.provCode
	// 					},
	// 					success:function(data) {
	// 						$('#provCode').attr('disabled',false).find('option').remove();
	// 						$.each( data, function(key, val) {
	// 							$('#provCode').append('<option value="'+val.citymunCode+'">'+val.citymunDesc+'</option>');
	// 							$.ajax({
	// 								type:'POST',
	// 								url: "{{url('get-cities')}}",
	// 								dataType:'JSON',
	// 								data: {
	// 									'_token'  : '{{csrf_token()}}',
	// 									citymunCode : val.citymunCode
	// 								},
	// 								success:function(data) {
	// 									$('#citymunCode').attr('disabled',false).find('option').remove();
	// 									$.each( data, function(key, val) {
	// 										$('#citymunCode').append('<option value="'+val.brgyCode+'">'+val.brgyDesc+'</option>');
	// 									});
	// 								}
	// 							});
	// 						});
	// 					}
	// 				});
	// 			});
	// 		}
	// 	});
	// })
</script>
</body>
</html>
