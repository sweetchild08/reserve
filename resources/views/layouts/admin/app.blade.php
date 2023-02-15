
<!DOCTYPE html>
<html lang="en" class="layout-static">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Santorenz Bay Resort</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{url('admin/assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{url('admin/assets/css/all.min.css')}}" rel="stylesheet" type="text/css">
	<!-- <link href="{{url('admin/assets/css/pos.css')}}" rel="stylesheet" type="text/css"> -->
	<link href="{{url('assets/parsley/parsley.css')}}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	@livewireStyles
	<!-- /global stylesheets -->


</head>
<style type="text/css">
@media (min-width: 992px) {
  .modal-lg,
  .modal-xl {
    max-width: 900px; 
  } 
  .modal-xxl{
      max-width: 1400px !important; 
  } 
}

@media (min-width: 1200px){
  .modal-xl{
      max-width: 1140px; 
  } 
  .modal-xxl{
      max-width: 1400px !important; 
  } 
}
.gap-1 > *{
	margin:.5rem;
}
</style>
<body>

	<!-- Page content -->
	<div class="page-content">

		@include('layouts.admin.sidebar')
		<!-- Main content -->
		<div class="content-wrapper">

			@include('layouts.admin.topbar')


			@yield('container')


			@include('layouts.admin.footer')

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
	<script src="{{url('assets/parsley/parsley.min.js')}}"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<!-- /theme JS files -->
    @yield('custom')
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <x-livewire-alert::scripts />
  <x-livewire-alert::flash />
</body>
</html>


