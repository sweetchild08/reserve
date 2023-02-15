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
{{-- {{dd($errors)}} --}}

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
            class="btn btn-primary btn-sm">Add Product</a>
    </div>
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr data-id="{{$product->encryptedId()}}">
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->type}}</td>
                            <td>{{$product->getCategory()}}</td>
                            <td>{{$product->sku}}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0)" onclick="fill(event)" class="dropdown-item">Update</a>
                                            <a href="{{route('admin.inventory.products.delete',$product->encryptedId())}}"
                                                onclick="return confirm('Are you sure want to delete this product?');" class="dropdown-item">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add-product" action="{{route('admin.inventory.products.store')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name"><br>
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description"><br>
                            <label for="">Type</label>
                            <select name="type" class="form-control">
                                @foreach ($types as $type)
                                    <option value="{{$type}}">{{ucwords($type)}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="">Category</label>
                            <select name="prods_category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{ucwords($category->category_name)}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="">SKU</label>
                            <input type="number" class="form-control" name="sku"><br>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    {{-- update --}}
    <div class="modal" id="update_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-update-product" data-parsley-validate method="POST">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name"><br>
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description"><br>
                            <label for="">Type</label>
                            <select name="type" class="form-control">
                                @foreach ($types as $type)
                                    <option value="{{$type}}">{{ucwords($type)}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="">Category</label>
                            <select name="prods_category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{ucwords($category->category_name)}}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="">SKU</label>
                            <input type="number" class="form-control" name="sku"><br>
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
    $('#inventory-must-open').addClass('nav-item-open nav-item-expanded')
    $('#inventory-category').addClass('active')
</script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
<script>
    function fill(e){
        e.preventDefault()
        const row=$(e.target)[0].closest('tr')
        const updateform= $('#form-update-product')[0]
        updateform.action='{{route('admin.inventory.products.update',':id')}}'.replace(':id',row.dataset['id'])
        $(updateform).find('input[name=name]').val(row.children[0].textContent)
        $(updateform).find('input[name=description]').val(row.children[1].textContent)
        $(updateform).find('select[name=type]').val(row.children[2].textContent)
        // console.log(row.children[3].textContent)
        $(updateform).find('select[name=prods_category_id]').text(row.children[3].textContent)
        $(updateform).find('input[name=sku]').val(row.children[4].textContent)
        $('#update_product').modal();
    }

    function setSelected(el,text){
        for (var i = 0; i < el.options.length; i++) {
            if (el.options[i].text === textToFind) {
                el.selectedIndex = i;
                break;
            }
        }
    }
</script>
@endsection
