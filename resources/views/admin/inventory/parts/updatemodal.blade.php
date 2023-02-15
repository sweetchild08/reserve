<form action="{{route('admin.inventory.deployments.bundle.update',$bundle->encryptedId())}}" data-parsley-validate method="POST">
 
    @method('put')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Bundle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" value="{{$bundle->name}}"><br>
                <label for="">Description</label>
                <input type="text" class="form-control" name="description" value="{{$bundle->description}}"><br>
                <label for="">Items </label>
                <span class="pull-right text-info" onclick="addItem(event)">add</span>
                <div class="add-items">
                    @php
                        $i=0;
                    @endphp
                    @foreach ($bundle->products as $bprod)
                        <div class="d-flex justify-content-left px-5 gap-1">
                            <select style="width: 60%" name="prod_id[{{$i}}]" class="form-control" value="{{$bprod->id}}">
                                @foreach ($prods as $prod)
                                    <option
                                    @if ($prod->id==$bprod->id)
                                        selected
                                    @endif
                                    value="{{$prod->id}}">{{ucwords($prod->name)}}</option>
                                @endforeach
                            </select>
                            <input style="width:30%" type="number" class="form-control" name="quantity[{{$i}}]" value="{{$bprod->pivot->quantity}}" placeholder="quantity">
                            <span type="button" class="btn btn-danger delete-item">X</span>
                        </div>
                        <br>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
                <label for="">Notes</label>
                <input type="test" class="form-control" name="notes" value="{{$bundle->notes}}"><br>
            </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Bundle</button>
    </div>
</form>