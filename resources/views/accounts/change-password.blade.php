
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
						<input type="hidden" name="type" value="Password">
						@if ($errors->any())
							<div class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<span style="display:block">&bull; {{ $error }}</span>
								@endforeach
							</div>
						@endif

						@if(Session::has('message'))
							<div class="alert alert-success">
								{{Session::get('message')}}
							</div>
						@endif
						
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<i class="icon-lock icon-2x text-secondary border-secondary border-3 rounded-pill p-3 mb-3 mt-1"></i>
									<h5 class="mb-0">Change password details</h5>
									<span class="d-block text-muted">Verify and enter your new password here</span>
								</div>

								<div class="form-group ">
									<input type="password" class="form-control" name="old_password" placeholder="Old Password" required>
								</div>

                                <div class="form-group ">
									<input type="password" class="form-control" name="password" data-parsley-equalto="#confirm_password" id="password"  placeholder="New Password" required>
								</div>

                                <div class="form-group ">
									<input type="password" class="form-control" name="confirm_password" id="confirm_password" data-parsley-equalto="#password"  placeholder="Confirm New Password" required>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Change Password</button>
								</div>


                                <div class="form-group">
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
	<!-- /theme JS files -->
	
	<script src="{{url('assets/parsley/parsley.min.js')}}"></script>

</body>
</html>
