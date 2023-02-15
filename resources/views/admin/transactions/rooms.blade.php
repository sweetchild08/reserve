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
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Description</th>
                        <th>Transaction Date</th>
                        <th style="width:1px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach($rooms as $r)
                        @php 
                            $description = json_decode($r->description);
                            if($r->booking_status == 'Pending') {
                                $booking_type = 'warning';
                            } elseif($r->booking_status == 'Approved') {
                                $booking_type = 'info';
                            } elseif($r->booking_status == 'Completed') {
                                $booking_type = 'success';
                            } else {
                                $booking_type = 'danger';
                            }
                        @endphp
                        <tr>
                            <td style="width:1px">{{$i++}}</td>
                            <td>{{$r->reference}} <br> <label class="badge badge-{{$booking_type}}">{{$r->booking_status}}</label></td>
                            <td><a href="{{ route('viewTransaction',[encrypt($r->customer_id)]) }}">{{$r->firstname.' '.$r->middlename.' '.$r->surname}}</a></td>
                            <td>
                                <div>Total: <b>₱{{number_format($description->total,2)}}</b></div>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} 
                                <br><a  data-toggle="modal" data-target="#ref{{$r->reference}}" class="text-right">View Details</a>
                                @if($r->booking_status == 'Pending')
                                | <a href="{{url('admin/transactions/rooms/status')}}/{{Crypt::encryptString($r->id)}}/Cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                | <a href="{{url('admin/transactions/rooms/status')}}/{{Crypt::encryptString($r->id)}}/Approve" onclick="return confirm('Are you sure want to approve this reservation?');" class="text-primary text-right">Approve</a>
                                @elseif($r->booking_status == 'Approved')
                                | <a href="{{url('admin/transactions/rooms/status')}}/{{Crypt::encryptString($r->id)}}/Complete" onclick="return confirm('Are you sure want to complete this reservation?');" class="text-success text-right">Complete</a>
                                @elseif($r->booking_status == 'Cancelled')
                                @endif
                            </td>
                            <td><?= date('M. d, Y <br\> h:i:s A',strtotime($r->created_at)) ?></td>
                            <td class="text-center">
                                {!!$r->payment_type.'<br>'.$r->status!!}
                                <a href="{{ route('adminReceipt',['OrderID' => $r->id]); }}">Receipt</a>
                            </td>
                        </tr>
                        <div class="modal" id="ref{{$r->reference}}" tabindex="-1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        Adults: <strong>{{$description->adults}}</strong> | Childrens: <strong>{{$description->adults}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                    @if(count($description->cottages) > 0)
                                    <br>
                                    @php $i=1; @endphp
                                    @foreach($description->cottages as $ctg)
                                        Cottage {{$i++}}: <strong>{{$ctg->title.' | Pax: '.$ctg->pax}}</strong><br> 
                                    @endforeach
                                    @endif

                                    @if(count($description->meals) > 0)
                                    <br>
                                    @php $i=1; @endphp
                                    @foreach($description->meals as $meals)
                                        Meal {{$i++}}: <strong>{{$meals->title.' | Pax: '.$meals->pax}}</strong><br> 
                                    @endforeach
                                    @endif

                                    @if(count($description->events) > 0)
                                    <br>
                                    <i class="fa fa-check"></i>
                                    @php $i=1; @endphp
                                    @foreach($description->events as $events)
                                        Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
                                    @endforeach
                                    @endif

                                    @if(count($description->activities) > 0)
                                    <br>
                                    @php $i=1; @endphp
                                    @foreach($description->activities as $activities)
                                        Activities {{$i++}}: <strong>{{$activities->title.' | Pax: '.$activities->pax}}</strong><br> 
                                    @endforeach
                                    @endif
                                </div>
                                <!-- <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
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
    
    <script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
    <script>
        $('#transactions-must-open').addClass('nav-item-open nav-item-expanded')
        $('#transactions-rooms').addClass('active')
    </script>
@endsection