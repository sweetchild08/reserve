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
            class="btn btn-primary btn-sm">Add Bundles</a>
        <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-manual-deploy"
            class="btn btn-primary btn-sm">Manual Deploy</a>
        <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-return"
            class="btn btn-primary btn-sm">Return reusables</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Bundles</h5>
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>    
                        <th>Bundle Name</th>
                        <th>Description</th>
                        <th>Items</th>
                        <th>Notes</th>
                        <th style="width:1px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bundles as $bundle)
                    <tr data-id="{{$bundle->encryptedId()}}">
                        <td>{{$bundle->name}}</td>
                        <td>{{$bundle->description}}</td>
                        <td>
                            @php
                                $p=[];
                                foreach ($bundle->products as $prod) {
                                    array_push($p,$prod->pivot->quantity.' '.$prod->name);
                                }
                            @endphp
                            {{join(', ',$p)}}
                        </td>
                        <td>{{$bundle->notes}}</td>
                        <td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0)" onclick="deploy(event)" class="dropdown-item">Deploy</a>
                                        <a href="javascript:void(0)" onclick="fill(event)" class="dropdown-item">Edit</a>
                                        <a href="{{route('admin.inventory.deployments.bundle.delete',$bundle->encryptedId())}}"
                                            onclick="return confirm('Are you sure want to delete this bundle?');" class="dropdown-item">Delete</a>
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
    <div class="modal" id="modal-manual-deploy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Manual Deployment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.inventory.deployments.deploy')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="d-flex justify-content-left px-5 gap-1">
                                <select style="width: 60%" name="prod_id" class="form-control">
                                    @foreach ($prods as $prod)
                                        <option
                                        value="{{$prod->id}}">{{ucwords($prod->name)}}</option>
                                    @endforeach
                                </select>
                                <input style="width:30%" type="number" class="form-control" name="quantity" placeholder="quantity">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Delay Product</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Bundle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.inventory.deployments.bundle.store')}}" data-parsley-validate method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name"><br>
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description"><br>
                            <label for="">Items </label>
                            <span class="pull-right text-info" onclick="addItem(event)">add</span>
                            <div class="add-items"></div>
                            <label for="">Notes</label>
                            <input type="test" class="form-control" name="notes"><br>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Bundle</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Modal -->
    <div class="modal" id="modal-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bundle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Bundle</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal" id="modal-deploy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bundle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Bundle</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="modal-return" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <form action="{{route('admin.inventory.deployments.return')}}" data-parsley-validate method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Return reusables</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Items </label>
                            <span class="pull-right text-info" onclick="addItem(event)">add</span>
                            <div class="add-items"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Return</button>
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
    let ind=0
    function fill(e){
        e.preventDefault()
        const row=$(e.target)[0].closest('tr')
        const modal=$('#modal-update').find('div.modal-content')[0];
        $.ajax({
            url:'{{route('admin.inventory.deployments.bundle.update.modal',':id')}}'.replace(':id',row.dataset['id']),
            success:(res)=>{
                modal.innerHTML=res
               setIndex( $(modal).find('.add-items').children('div').length)
            }
        })
        // const row=$(e.target)[0].closest('tr')
        // const updateform= $('#form-update-category')[0]
        // updateform.action='{{route('admin.inventory.category.update',':id')}}'.replace(':id',row.dataset['id'])
        // $(updateform).find('input[name=category_name]').val(row.children[0].textContent)
        // $(updateform).find('input[name=description]').val(row.children[1].textContent)
        $('#modal-update').modal();
    }
    function deploy(e){
        e.preventDefault()
        const row=$(e.target)[0].closest('tr')
        const modal=$('#modal-deploy').find('div.modal-content')[0];
        console.log(modal)
        $.ajax({
            url:'{{route('admin.inventory.deployments.bundle.deploy.modal',':id')}}'.replace(':id',row.dataset['id']),
            success:(res)=>{
                modal.innerHTML=res
               setIndex( $(modal).find('.add-items').children('div').length)
            }
        })
        // const row=$(e.target)[0].closest('tr')
        // const updateform= $('#form-update-category')[0]
        // updateform.action='{{route('admin.inventory.category.update',':id')}}'.replace(':id',row.dataset['id'])
        // $(updateform).find('input[name=category_name]').val(row.children[0].textContent)
        // $(updateform).find('input[name=description]').val(row.children[1].textContent)
        $('#modal-deploy').modal();
    }

    function addItem(e){
        e.preventDefault()
        const d=$(e.target).siblings('.add-items')[0]
        
        const el=`
        <div class="d-flex justify-content-left px-5 gap-1">
            <select style="width: 60%" name="prod_id[${ind}]" class="form-control">
                @foreach ($prods as $prod)
                    <option value="{{$prod->id}}">{{ucwords($prod->name)}}</option>
                @endforeach
            </select>
            <input style="width:30%" type="number" class="form-control" name="quantity[${ind}]" placeholder="quantity">
            <span type="button" class="btn btn-danger delete-item">X</span>
        </div>
        <br>
        `
        d.innerHTML+=el
        $('.delete-item').click(element=>{
            console.log(element.target.parentElement.parentElement)
            element.target.parentElement.parentElement.removeChild(element.target.parentElement.nextElementSibling)
            element.target.parentElement.parentElement.removeChild(element.target.parentElement)
        })
        ind++;
    }
    function setIndex(index){
        ind=index
    }
</script>
@endsection
