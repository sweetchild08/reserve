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
            class="btn btn-primary btn-sm">Restock</a>
    </div>
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>    
                        <th>Product</th>
                        <th>Description</th>
                        <th>SKU</th>
                        <th>Type</th>
                        <th>Category</th>
                        {{-- <th>Price</th> --}}
                        <th>Stocks</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                    <tr data-id="{{$stock->encryptedId()}}">
                        <td>{{$stock->name}}</td>
                        <td>{{$stock->description}}</td>
                        <td>{{$stock->sku}}</td>
                        <td>{{$stock->type}}</td>
                        <td>{{$stock->category_name}}</td>
                        {{-- <td>{{$stock->tprice}}</td> --}}
                        <td>{{$stock->tstocks}}</td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0)" class="dropdown-item">History</a>
                                        {{-- <a href="javascript:void(0)" onclick="fill(event)" class="dropdown-item">Edit</a>
                                        <a href="{{route('admin.inventory.category.delete',$stock->encryptedId())}}"
                                            onclick="return confirm('Are you sure want to complete this category?');" class="dropdown-item">Delete</a> --}}
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Product Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.inventory.stocks.store')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Product</label>
                            <select name="prod_id" class="form-control">
                                @foreach ($prods as $prod)
                                    <option value="{{$prod->id}}">{{ucwords($prod->name)}}</option>
                                @endforeach
                            </select>
                            <br>
                            
                            <label for="">Quantity</label>
                            <input type="number" class="form-control" name="quantity"><br>
                            <label for="">Price Per Unit</label>
                            <input type="number" class="form-control" name="price_per_unit"><br>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Stocks</button>
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
</script>
@endsection
