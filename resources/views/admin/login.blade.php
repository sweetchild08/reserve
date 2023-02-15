
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{$title}}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('admin/assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('admin/assets/css/all.min.css')}}" rel="stylesheet" type="text/css">
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
					<form class="login-form" method="POST" data-parsley-validate action="{{url('admin/authenticate')}}">
						@csrf
						@if ($errors->any())
							<div class="alert alert-danger">
								@foreach ($errors->all() as $error)
									<span style="display:block">&bull; {{ $error }}</span>
								@endforeach
							</div>
						@endif

						@if(Session::has('message'))
							<div class="alert alert-danger">
								{{Session::get('message')}}
							</div>
						@endif
						
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<img class="logo" src="{{asset('assets/images/sbrlogo.png')}}" height="100" alt="Logo">
									<h5 class="mb-0">Administrator</h5>
									
								</div>

								<div class="form-group ">
									<input type="text" class="form-control" name="username" placeholder="Username" required>
									
								</div>

								<div class="form-group ">
									<input type="password" class="form-control" name="password" placeholder="Password" required>
								
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block">Sign in</button>
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
	<script src="{{url('admin/assets/js/main/jquery.min.js')}}"></script>
	<script src="{{url('admin/assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{url('admin/assets/js/app.js')}}"></script>
	<!-- /theme JS files -->
	
	<script src="{{url('assets/parsley/parsley.min.js')}}"></script>

</body>
</html>
