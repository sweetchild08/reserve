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
        <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#category"
            class="btn btn-primary btn-sm">Add Category</a>
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
                        <th>Category</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($categories as $cat)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$cat->name}}</td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0)" onclick="update('{{Crypt::encryptString($cat->id)}}','{{$cat->name}}')" class="dropdown-item">Update</a>
                                        <a href="{{url('admin/foods/delete')}}/{{Crypt::encryptString($cat->id)}}/category"
                                            onclick="return confirm('Are you sure want to complete this category?');" class="dropdown-item">Delete</a>
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


    <!-- Modal -->
    <div class="modal" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Room Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/foods/store/category')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Category</label>
                            <input type="text" class="form-control" name="name" required>
                            <input type="hidden" name="category" value="Foods">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    {{-- update --}}
    <div class="modal" id="update_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Room Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/foods/update/category')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Category</label>
                            <input type="text" class="form-control" id="category_update" name="name" required>
                            <input type="hidden" class="form-control" id="foods_id" name="foods_id">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /content area -->
@endsection
@section('custom')
<script>
    $('#foods-must-open').addClass('nav-item-open nav-item-expanded')
    $('#foods-category').addClass('active')

</script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
<script>
    function update(id,category) {
        $('#update_category').modal();
        $('#foods_id').val(id);
        $('#category_update').val(category);
    }
</script>
@endsection
