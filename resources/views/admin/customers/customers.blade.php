@extends('layouts.admin.app')
@section('container')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-sm-flex">
        <div class="page-title">
            <h4>{{$title}}</h4>
        </div>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content pt-0">

    <!-- Basic card -->
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($users as $user)
                        
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$user->firstname.' '.$user->middlename.' '.$user->surname}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->contact}}</td>
                            <td>
                                @if(!empty($user->address) && !empty($user->barangay_detail->brgyDesc) && !empty($user->city_detail->citymunDesc) && !empty($user->province_detail->provDesc))
                                    {{$user->address.' '.$user->barangay_detail->brgyDesc.' '.$user->city_detail->citymunDesc.' '.$user->province_detail->provDesc}}
                                @endif;
                            </td>
                            <td>{{$user->is_active == 0 ? 'Inactive' : 'Active'}}</td>
                            <td>{{$user->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /basic card -->


</div>
<!-- /content area -->
@endsection
@section('custom')
    <script>
        $('#customers').addClass('active')
    </script>
    <script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection