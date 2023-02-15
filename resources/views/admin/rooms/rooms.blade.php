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
    @if(Session::has('message'))
        <div class="form-group">
            <div class="alert alert-info">
                {{Session::get('message')}}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <span style="display:block">&bull; {{ $error }}</span>
            @endforeach
        </div>
    @endif

    <div class="form-group">
        <a href="{{url('admin/rooms/create-rooms')}}" class="btn btn-primary btn-sm">Add Rooms</a>
    </div>
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>
                        <th style="width:1px">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Services</th>
                        <th>Rate</th>
                        <th style="width:1px">Adults</th>
                        <th style="width:1px">Child</th>
                        <th style="width:1px">Featured</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $r)
                        <tr>
                            <td>{{$r->id}}</td>
                            <td>{{$r->title}}</td>
                            <td>{{$r->description}}</td>
                            <td>{{$r->services}}</td>
                            <td>₱{{number_format($r->rate,2)}}</td>
                            <td class="text-center">{{$r->adults}}</td>
                            <td class="text-center">{{$r->childrens}}</td>
                            <td class="text-center">{{$r->is_featured == 0 ? 'No' : 'Yes'}}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="{{url('admin/rooms/details')}}/{{Crypt::encryptString($r->id)}}" class="dropdown-item">Update</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
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
        $('#rooms-must-open').addClass('nav-item-open nav-item-expanded')
        $('#rooms-create').addClass('active')
    </script>
    <script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection
