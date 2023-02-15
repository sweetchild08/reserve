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
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Activities Details</h5>
                </div>
        
                <div class="card-body">
                    <form method="POST" action="{{url('admin/activities/update')}}/{{Crypt::encryptString($activities->id)}}/activities" enctype="multipart/form-data">
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
                                <input type="text" name="title" value="{{$activities->title}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Category</label>
                            <div class="col-lg-10">
                                <select name="categories_id" class="form-control">
                                    @foreach($category as $cat)
                                        <option value="{{Crypt::encryptString($cat->id)}}" {{$cat->name == $activities->category_name ? 'selected': ''}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea name="description" class="form-control" style="resize:none">{{$activities->description}}</textarea>
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Rate</label>
                            <div class="col-lg-10">
                                <input type="text" name="rate" value="{{$activities->rate}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Pax</label>
                            <div class="col-lg-10">
                                <input type="text" name="pax" value="{{$activities->pax}}" class="form-control">
                            </div>
                        </div>
        
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Featured</label>
                            <div class="col-lg-10">
                                <select name="is_featured" class="form-control">
                                    <option value="0" {{$activities->is_featured == 0 ? 'selected' : ''}}>No</option>
                                    <option value="1" {{$activities->is_featured == 1 ? 'selected' : ''}}>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Comments</label>
                            <div class="col-lg-10">
                                <select name="is_comments" class="form-control">
                                    <option value="0" {{$activities->is_comments == 0 ? 'selected' : ''}}>Enable</option>
                                    <option value="1" {{$activities->is_comments == 1 ? 'selected' : ''}}>Disable</option>
                                </select>
                            </div>
                        </div>
        
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary   btn-sm">Save Changes</button>
                            <a href="{{url('admin/activities/delete')}}/{{Crypt::encryptString($activities->id)}}/activities" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this activities?');">Delete</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Cottages Gallery</h5>
                </div>
        
                <div class="card-body">
                    <form method="POST" action="{{url('admin/activities/gallery/store')}}" data-parsley-validate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="activities_id" value="{{Crypt::encryptString($activities->id)}}">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="file" name="activities_gallery[]" multiple class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-block btn-sm">Upload</button>
                        </div>
                        
                
                    </form>

                    <div class="row">
                        @foreach($gallery as $g) 
                        <div class="col-md-3 col-4">
                            <div class="card">
                                <div class="card-img-actions m-1">
                                    <img class="card-img img-fluid" style="width:100px;height:60px" src="{{asset('assets/images/activities')}}/{{$g->gallery}}">
                                </div>
                                <a class="text-center text-danger" href="{{url('admin/activities/images')}}/{{Crypt::encryptString($g->id)}}/delete">Delete</a>
                            </div>
                        </div>
                        @endforeach
                    </div>

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
        $('#activities-must-open').addClass('nav-item-open nav-item-expanded')
        $('#activities-create').addClass('active')
    </script>
    <script src="{{asset('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection