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
        <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#product"
            class="btn btn-primary btn-sm">Add Products</a>
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
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th style="width:1px">Price</th>
                        <th style="width:1px">Stocks</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($inventories as $inventory)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$inventory->name}}</td>
                            <td>{{$inventory->sku}}</td>
                            <td>{{$inventory->category_name}}</td>
                            <td>{{$inventory->description}}</td>
                            <td>₱{{number_format($inventory->price,2)}}</td>
                            <td>{{number_format($inventory->stocks)}}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" onclick="update('{{Crypt::encryptString($inventory->id)}}','{{$inventory->name}}','{{$inventory->sku}}','{{$inventory->categories_id}}','{{$inventory->description}}','{{$inventory->price}}','{{$inventory->stocks}}')" class="dropdown-item">Update</a>
                                            <a href="{{url('admin/inventory/'.Crypt::encryptString($inventory->id).'/delete')}}" onclick="return confirm('Are you sure want to delete this item?');"  class="dropdown-item">Delete</a>
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
    <div class="modal" id="product" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/inventory/store')}}" data-parsley-validate method="POST">
                    @csrf
                     
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" value="{{old('name')}}" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="">SKU</label>
                        <input type="text" class="form-control" value="{{old('sku')}}" name="sku" required>
                    </div>

                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="text" class="form-control" value="{{old('price')}}" data-parsley-pattern="^\d+(.\d{1,2})?$" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="">Stocks</label>
                        <input type="text" class="form-control" value="{{old('stocks')}}" data-parsley-pattern="^\d+(.\d{1,2})?$" name="stocks" required>
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" style="resize:none" required rows="5">{{old('description')}}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="categories_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="update_product" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/inventory/update')}}" data-parsley-validate method="POST">
                    @csrf
                     
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                        <input type="hidden" class="form-control" name="id" id="id" required>
                    </div>

                    <div class="form-group">
                        <label for="">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" required>
                    </div>

                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="">Stocks</label>
                        <input type="text" class="form-control" id="stocks" name="stocks" required>
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" id="description" style="resize:none" rows="5"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="categories_id" id="cat_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
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
        $('#inventory-must-open').addClass('nav-item-open nav-item-expanded')
        $('#inventory-products').addClass('active')
    </script>
    <script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
    <script>
        function update(id,name,sku,cat_id,description,price,stocks) {
            $('#update_product').modal();
            $('#id').val(id);
            $('#name').val(name);
            $('#sku').val(sku);
            $('#cat_id').val(cat_id);
            $('#description').val(description);
            $('#price').val(price);
            $('#stocks').val(stocks);
        }
    </script>
@endsection