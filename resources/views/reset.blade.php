
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
					<form class="login-form" method="POST" data-parsley-validate action="{{url('accounts/retrieve')}}">
						@csrf
						@if ($errors->any())
							<div class="alert alert-info">
								@foreach ($errors->all() as $error)
									<span style="display:block">&bull; {{ $error }}</span>
								@endforeach
							</div>
						@endif

						@if(Session::has('message'))
							<div class="alert alert-info">
								{{Session::get('message')}}
							</div>
						@endif
						<input type="hidden" name="email" value="{{$email}}">
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<i class="icon-reading icon-2x text-secondary border-secondary border-3 rounded-pill p-3 mb-3 mt-1"></i>
									<h5 class="mb-0">Reset your password</h5>
									<span class="d-block text-muted">Enter your new password</span>
								</div>

								<div class="form-group form-group-feedback form-group-feedback-left">
									<input type="password" class="form-control" name="password" placeholder="Password" id="password" data-parsley-equalto="#confirm_password" required>
									<div class="form-control-feedback">
										<i class="icon-lock text-muted"></i>
									</div>
								</div>

								<div class="form-group form-group-feedback form-group-feedback-left">
									<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm_password" data-parsley-equalto="#password" required>
									<div class="form-control-feedback">
										<i class="icon-lock text-muted"></i>
									</div>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Submit</button>
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
