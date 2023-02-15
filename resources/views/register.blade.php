<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="register, signup">

    <title>{{$title}}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{url('login/css/core.min.css')}}" rel="stylesheet">
    <link href="{{url('login/css/app.min.css')}}" rel="stylesheet">
    <link href="{{url('login/css/style.min.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets/images/favicon.ico">
    <link rel="icon" href="../assets/images/favicon.ico">
  </head>

  <body>


    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(../assets/images/gallery/regs.png)" data-overlay="3">



      </div>



      <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">
        <div class="px-80 py-30">
          <h2>Register an account</h2>
          <p><small>All fields are required.</small></p>
          <br>

          <form class="form-type-material" method="post" action="{{url('accounts/store')}}">
		  @csrf
			@if ($errors->any())
				<div class="alert alert-info">
					@foreach ($errors->all() as $error)
						<span style="display:block">&bull; {{ $error }}</span>
					@endforeach
				</div>
			@endif
		  <div class="form-group">
				<input type="text" name="surname" class="form-control" value="{{old('surname')}}" placeholder="Surname" required>
			</div>

			<div class="form-group">
				<input type="text" name="firstname" class="form-control" value="{{old('firstname')}}" placeholder="First Name" required>
			</div>

			<div class="form-group">
				<input type="text" name="middlename" class="form-control" value="{{old('middlename')}}" placeholder="Middle Name">
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
				<!-- <input type="text" name="province" class="form-control" value="{{--old('province')--}}" placeholder="Province" required> -->
				
				<select class="form-control" id="province" name="province" required>
					<option>Select Province</option>
					@foreach($province as $data)
					<option value="{{ $data->provCode }}">{{ $data->provDesc }}</option>
					@endforeach
					
				</select>
			</div>

			<div class="form-group">
				<!-- <input type="text" name="city" class="form-control" value="{{-- old('city') --}}" placeholder="City" required> -->
				<select class="form-control" id="city" name="city" required>
					<option>Select City</option>
					
				</select>
			</div>
			
			<div class="form-group">
				<!-- <input type="text" name="barangay" class="form-control" value="{{-- old('barangay') --}}" placeholder="Barangay" required> -->
				<select class="form-control" id="barangay" name="barangay" required>
					<option>Select Barangay</option>
					
				</select>
			</div>

			<div class="form-group">
				<input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="Address" required>
			</div>

			<div class="form-group">
				<input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Email Address" required>
			</div>

			<div class="form-group">
				<input type="text" class="form-control" name="contact" value="{{old('contact')}}" placeholder="Contact" required>
			</div>

			<div class="form-group">
				<input type="text" class="form-control" placeholder="Username" name="username" required>
			</div>

			<div class="form-group">
				<input type="password" name="password" class="form-control" id="password" data-parsley-equalto="#confirm_password" placeholder="Password" required>
			</div>

			<div class="form-group">
				<input type="password" name="confirm_password" class="form-control" id="confirm_password" data-parsley-equalto="#password" placeholder="Confirm Password" required>
			</div>

            <br>
            <button class="btn btn-bold btn-block btn-primary" type="submit">Register</button>
          </form>

          <hr class="w-30px">

          <p class="text-center text-muted fs-13 mt-20">Already have an account? <a class="text-primary fw-500" href="{{url('login1')}}">Sign in</a><br/><a class="text-primary fw-500" href="{{url('/')}}">Back to Home</a></p>
		
        </div>
      </div>
    </div>




    <!-- Scripts -->
	<script src="{{url('login/js/core.min.js')}}"></script>
    <script src="{{url('login/js/app.min.js')}}"></script>
    <script src="{{url('login/js/script.min.js')}}"></script>

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


	$(document).ready(function(){
		$('#province').on('change', function(){
			var province = $(this).val();
			if(province){
				$.ajax({
					url: '/get-province/'+province,
					type: 'get',
					dataType: 'json',
					success: function(data){
						$('#city').empty();
						$('#barangay').empty();
						$.each(data, function(key, value){
							$('#city').append('<option value="'+value.citymunCode+'">'+value.citymunDesc+'</option>');
							//console.log(value);
						});
					}
				});
			}else{
				$('#city').empty();
        		$('#barangay').empty();
			}	
		});
		
		$('#city').on('change', function(){
			var city = $(this).val();
			if(city){
				$.ajax({
					url: '/get-city/'+city,
					type: 'get',
					dataType: 'json',
					success: function(data){
						$('#barangay').empty();
						$.each(data, function(key, value){
							$('#barangay').append('<option value="'+value.brgyCode+'">'+value.brgyDesc+'</option>');
							//console.log(value);
						});
					}
				});
			}else{
				$('#barangay').empty();
			}
		});
	});
</script>

  </body>
</html>

