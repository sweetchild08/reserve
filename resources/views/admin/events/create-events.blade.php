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
  
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Room Details</h5>
                </div>
        
                <div class="card-body">
                    <form method="POST" action="{{url('admin/events/store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Featured Image</label>
                            <div class="col-lg-10">
                                <input type="file" name="featured_image" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Title</label>
                            <div class="col-lg-10">
                                <input type="text" name="title" value="{{old('title')}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Category</label>
                            <div class="col-lg-10">
                                <select name="categories_id" class="form-control">
                                    @foreach($category as $cat)
                                        <option value="{{Crypt::encryptString($cat->id)}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea name="description" class="form-control" style="resize:none">{{old('description')}}</textarea>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Rate</label>
                            <div class="col-lg-10">
                                <input type="text" name="rate" value="{{old('rate')}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Pax</label>
                            <div class="col-lg-10">
                                <input type="text" name="pax" value="{{old('pax')}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Featured</label>
                            <div class="col-lg-10">
                                <select name="is_featured" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Comments</label>
                            <div class="col-lg-10">
                                <select name="is_comments" class="form-control">
                                    <option value="0">Enable</option>
                                    <option value="1">Disable</option>
                                </select>
                            </div>
                        </div>
        
                        <button tyoe="submit" class="btn btn-primary float-right  btn-sm">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- /basic card -->


</div>
<!-- /content area -->
@endsection
@section('custom')
    <script>
        $('#events-must-open').addClass('nav-item-open nav-item-expanded')
        $('#events-create').addClass('active')
    </script>
    <script src="{{asset('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection