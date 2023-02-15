@extends('layouts.admin.app')
@section('container')
<!-- Page header -->
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content d-sm-flex">
        <div class="page-title">
            <h4>{{ $customer->surname }}, {{ $customer->firstname }} Reservations</h4>
        </div>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content pt-0 card">

    @if(Session::has('message'))
            <div class="alert alert-danger">
                {{Session::get('message')}}
            </div>
        @endif

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active" style="padding: .5em;"><a href="#rooms" aria-controls="rooms" role="tab" data-toggle="tab">Rooms</a></li>
              <li role="presentation" style="padding: .5em;"><a href="#cottages" aria-controls="cottages" role="tab" data-toggle="tab">Cottages</a></li>
              <li role="presentation" style="padding: .5em;"><a href="#foods" aria-controls="foods" role="tab" data-toggle="tab">Foods</a></li>
              <li role="presentation" style="padding: .5em;"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
              <li role="presentation" style="padding: .5em;"><a href="#activities" aria-controls="activities" role="tab" data-toggle="tab">Activities</a></li>
            </ul>
          
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="rooms">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <th>Reference</th>
                            <th>Description</th>
                            <th style="width:1px">Status</th>
                        </thead>
                        <tbody>
                            @if(!empty($rooms) && $rooms->count())
                                @foreach($rooms as $r)
                                    @php 
                                        $description = json_decode($r->description);
                                        if($r->booking_status == 'Pending') {
                                            $booking_type = 'warning';
                                        } elseif($r->booking_status == 'Reserved') {
                                            $booking_type = 'primary';
                                        } elseif($r->booking_status == 'Approved') {
                                            $booking_type = 'info';
                                        } elseif($r->booking_status == 'Completed') {
                                            $booking_type = 'success';
                                        } else {
                                            $booking_type = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$r->reference}} <br> <label class="label label-{{$booking_type}}">{{$r->booking_status}}</label></td>
                                        <td>
                                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br><a data-toggle="collapse" href="#{{$r->reference}}" role="button" aria-expanded="false" aria-controls="{{$r->reference}}" class="text-right">View Details</a>
                                            <div class="collapse" id="{{$r->reference}}">
                                                <div class="">
                                                    <div style="display:flex;">
                                                        <span class="m-1 mr-3">Adults: <b>{{$description->adults}}</b></span>
                                                        <span class="m-1 mr-3">Children: <b>{{$description->adults}}</b></span>
                                                        <span class="m-1 mr-3">Rates: <b>₱{{number_format($description->rates,2)}}</b></span>
                                                        <span class="m-1 mr-3">Days: <b>{{$description->counter}}</b></span>
                                                        <span class="m-1 mr-3">Partial Payment: <b>₱{{number_format($description->partial,2)}}</b></span>
                                                        <span class="m-1 mr-3">Total: <b>₱{{number_format($description->total,2)}}</b></span>
                                                    </div>
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $ctg)
                                                    <span class="m-1 mr-3">Cottage {{$i++}}: <b>{{$ctg->title.' | Pax: '.$ctg->pax}}</b></span>
                                                    @endforeach
                                                    @endif

                                                    @if(count($description->meals) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->meals as $meals)
                                                        <span class="m-1 mr-3">Meal {{$i++}}: <b>{{$meals->title.' | Pax: '.$meals->pax}}</b></span>
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->events as $events)
                                                    <span class="m-1 mr-3">Events {{$i++}}: <b>{{$events->title.' | Pax: '.$events->pax}}</b></span> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->activities) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->activities as $activities)
                                                    <span class="m-1 mr-3">Activities {{$i++}}: <b>{{$activities->title.' | Pax: '.$activities->pax}}</b></span>  
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{!!$r->payment_type.'<br>'.$r->status!!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center">No result found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $rooms->links('pagination')}}
                </div>
                <div role="tabpanel" class="tab-pane" id="cottages">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <th>Reference</th>
                            <th>Description</th>
                            <th style="width:1px">Status</th>
                        </thead>
                        <tbody>
                            @if(!empty($cottages) && $cottages->count())
                                @foreach($cottages as $c)
                                    @php 
                                        $description = json_decode($c->description);
                                        if($c->booking_status == 'Pending') {
                                            $booking_type = 'warning';
                                        } elseif($c->booking_status == 'Reserved') {
                                            $booking_type = 'primary';
                                        } elseif($c->booking_status == 'Approved') {
                                            $booking_type = 'info';
                                        } elseif($c->booking_status == 'Completed') {
                                            $booking_type = 'success';
                                        } else {
                                            $booking_type = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$c->reference}} <br> <label class="label label-{{$booking_type}}">{{$c->booking_status}}</label></td>
                                        <td>
                                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br><a data-toggle="collapse" href="#{{$c->reference}}" role="button" aria-expanded="false" aria-controls="{{$c->reference}}" class="text-right">View Details</a>
                                            @if($c->booking_status != 'Cancelled')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($c->id)}}/cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                            @endif
                                            @if($c->booking_status == 'Approved')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($c->id)}}/print" class="text-info text-right">Print Receipt</a>
                                            @endif
                                            <div class="collapse" id="{{$c->reference}}">
                                                <div class="card card-body">
                                                    Pax: <span>{{$description->pax}}</span> | Rates: <span>₱{{number_format($description->rates,2)}}</span> | Days: <span>{{$description->counter}}</span> | Partial Payment: <span>₱{{number_format($description->partial,2)}}</span> | Total: <span>₱{{number_format($description->total,2)}}</span>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <span>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->meals) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->meals as $meals)
                                                        Meal {{$i++}}: <span>{{$meals->title.' | Pax: '.$meals->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->events as $events)
                                                        Events {{$i++}}: <span>{{$events->title.' | Pax: '.$events->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->activities) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->activities as $activities)
                                                        Activities {{$i++}}: <span>{{$activities->title.' | Pax: '.$activities->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{!!$c->payment_type.'<br>'.$c->status!!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center">No result found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $cottages->links('pagination')}}
                </div>
                <div role="tabpanel" class="tab-pane" id="foods">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <th>Reference</th>
                            <th>Description</th>
                            <th style="width:1px">Status</th>
                        </thead>
                        <tbody>
                            @if(!empty($foods) && $foods->count())
                                @foreach($foods as $f)
                                    @php 
                                        $description = json_decode($f->description);
                                        if($f->booking_status == 'Pending') {
                                            $booking_type = 'warning';
                                        } elseif($f->booking_status == 'Reserved') {
                                            $booking_type = 'primary';
                                        } elseif($f->booking_status == 'Approved') {
                                            $booking_type = 'info';
                                        } elseif($f->booking_status == 'Completed') {
                                            $booking_type = 'success';
                                        } else {
                                            $booking_type = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$f->reference}} <br> <label class="label label-{{$booking_type}}">{{$f->booking_status}}</label></td>
                                        <td>
                                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br><a data-toggle="collapse" href="#{{$f->reference}}" role="button" aria-expanded="false" aria-controls="{{$f->reference}}" class="text-right">View Details</a>
                                            @if($f->booking_status != 'Cancelled')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($f->id)}}/cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                            @endif
                                            @if($f->booking_status == 'Approved')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($f->id)}}/print" class="text-info text-right">Print Receipt</a>
                                            @endif
                                            <div class="collapse" id="{{$f->reference}}">
                                                <div class="card card-body">
                                                    Pax: <span>{{$description->pax}}</span> | Rates: <span>₱{{number_format($description->rates,2)}}</span> | Days: <span>{{$description->counter}}</span> | Partial Payment: <span>₱{{number_format($description->partial,2)}}</span> | Total: <span>₱{{number_format($description->total,2)}}</span>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <span>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <span>{{$cottages->title.' | Pax: '.$cottages->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->events as $events)
                                                        Events {{$i++}}: <span>{{$events->title.' | Pax: '.$events->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->activities) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->activities as $activities)
                                                        Activities {{$i++}}: <span>{{$activities->title.' | Pax: '.$activities->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{!!$f->payment_type.'<br>'.$f->status!!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center">No result found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $foods->links('pagination')}}
                </div>

                <div role="tabpanel" class="tab-pane" id="events">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <th>Reference</th>
                            <th>Description</th>
                            <th style="width:1px">Status</th>
                        </thead>
                        <tbody>
                            @if(!empty($eventsQuery) && $eventsQuery->count())
                                @foreach($eventsQuery as $f)
                                    @php 
                                        $description = json_decode($f->description);
                                        if($f->booking_status == 'Pending') {
                                            $booking_type = 'warning';
                                        } elseif($f->booking_status == 'Reserved') {
                                            $booking_type = 'primary';
                                        } elseif($f->booking_status == 'Approved') {
                                            $booking_type = 'info';
                                        } elseif($f->booking_status == 'Completed') {
                                            $booking_type = 'success';
                                        } else {
                                            $booking_type = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$f->reference}} <br> <label class="label label-{{$booking_type}}">{{$f->booking_status}}</label></td>
                                        <td>
                                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br><a data-toggle="collapse" href="#{{$f->reference}}" role="button" aria-expanded="false" aria-controls="{{$f->reference}}" class="text-right">View Details</a>
                                            @if($f->booking_status != 'Cancelled')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($f->id)}}/cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                            @endif
                                            @if($f->booking_status == 'Approved')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($f->id)}}/print" class="text-info text-right">Print Receipt</a>
                                            @endif
                                            <div class="collapse" id="{{$f->reference}}">
                                                <div class="card card-body">
                                                    Pax: <span>{{$description->pax}}</span> | Rates: <span>₱{{number_format($description->rates,2)}}</span> | Days: <span>{{$description->counter}}</span> | Partial Payment: <span>₱{{number_format($description->partial,2)}}</span> | Total: <span>₱{{number_format($description->total,2)}}</span>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <span>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <span>{{$cottages->title.' | Pax: '.$cottages->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->foods) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->foods as $foods)
                                                        Foods {{$i++}}: <span>{{$foods->title.' | Pax: '.$foods->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->activities) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->activities as $activities)
                                                        Activities {{$i++}}: <span>{{$activities->title.' | Pax: '.$activities->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{!!$f->payment_type.'<br>'.$f->status!!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center">No result found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $eventsQuery->links('pagination')}}
                </div>

                <div role="tabpanel" class="tab-pane" id="activities">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <th>Reference</th>
                            <th>Description</th>
                            <th style="width:1px">Statuss</th>
                        </thead>
                        <tbody>
                            @if(!empty($activitiesQuery) && $activitiesQuery->count())
                                @foreach($activitiesQuery as $f)
                                    @php 
                                        $description = json_decode($f->description);
                                        if($f->booking_status == 'Pending') {
                                            $booking_type = 'warning';
                                        } elseif($f->booking_status == 'Reserved') {
                                            $booking_type = 'primary';
                                        } elseif($f->booking_status == 'Approved') {
                                            $booking_type = 'info';
                                        } elseif($f->booking_status == 'Completed') {
                                            $booking_type = 'success';
                                        } else {
                                            $booking_type = 'danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$f->reference}} <br> <label class="label label-{{$booking_type}}">{{$f->booking_status}}</label></td>
                                        <td>
                                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br><a data-toggle="collapse" href="#{{$f->reference}}" role="button" aria-expanded="false" aria-controls="{{$f->reference}}" class="text-right">View Details</a>
                                            @if($f->booking_status != 'Cancelled')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($f->id)}}/cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                                
                                            @endif
                                            @if($f->booking_status == 'Approved')
                                            | <a href="#" class="text-danger text-right">Print Receipt</a>
                                            @endif
                                            <div class="collapse" id="{{$f->reference}}">
                                                <div class="card card-body">
                                                    Pax: <span>{{$description->pax}}</span> | Rates: <span>₱{{number_format($description->rates,2)}}</span> | Days: <span>{{$description->counter}}</span> | Partial Payment: <span>₱{{number_format($description->partial,2)}}</span> | Total: <span>₱{{number_format($description->total,2)}}</span>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <span>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <span>{{$cottages->title.' | Pax: '.$cottages->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->foods as $foods)
                                                        Foods {{$i++}}: <span>{{$foods->title.' | Pax: '.$foods->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->events as $events)
                                                        Events {{$i++}}: <span>{{$events->title.' | Pax: '.$events->pax}}</span><br> 
                                                    @endforeach
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{!!$f->payment_type.'<br>'.$f->status!!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan=5 class="text-center">No result found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $activitiesQuery->links('pagination')}}
                </div>
            </div>
          
          </div>


</div>
<!-- /content area -->

<!-- ========== PAGE TITLE ========== -->
<!-- /content area -->
@endsection
@section('custom')
    <script>
        $('#customers').addClass('active')
    </script>
    <script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection