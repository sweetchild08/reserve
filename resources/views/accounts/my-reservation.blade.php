@extends('layouts.app')
@section('container')
<!-- ========== PAGE TITLE ========== -->
 <div class="page_title gradient_overlay" style="background: url({{asset('assets/images/page_title_bg.jpg')}});">
    <div class="container">
        <div class="inner">
            <h1>{{$title}}</h1>
        </div>
    </div>
</div>

<!-- ========== MAIN SECTION ========== -->
<main id="about_us_page">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{Session::get('message')}}
            </div>
        @endif

        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#rooms" aria-controls="rooms" role="tab" data-toggle="tab">Rooms</a></li>
              <li role="presentation"><a href="#cottages" aria-controls="cottages" role="tab" data-toggle="tab">Cottages</a></li>
              <li role="presentation"><a href="#foods" aria-controls="foods" role="tab" data-toggle="tab">Foods</a></li>
              <li role="presentation"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Events</a></li>
              <li role="presentation"><a href="#activities" aria-controls="activities" role="tab" data-toggle="tab">Activities</a></li>
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
                                            @if($r->booking_status != 'Cancelled')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($r->id)}}/cancel" onclick="return confirm('Are you sure want to cancel this reservation?');" class="text-danger text-right">Cancel</a>
                                            @endif
                                            @if($r->booking_status == 'Approved')
                                            | <a href="{{url('accounts/my-reservation')}}/{{Crypt::encryptString($r->id)}}/print" class="text-info text-right">Print Receipt</a>
                                            @endif
                                            <div class="collapse" id="{{$r->reference}}">
                                                <div class="card card-body">
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
                                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <strong>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</strong><br> 
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
                                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <strong>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <strong>{{$cottages->title.' | Pax: '.$cottages->pax}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
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
                                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <strong>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <strong>{{$cottages->title.' | Pax: '.$cottages->pax}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->foods) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->foods as $foods)
                                                        Foods {{$i++}}: <strong>{{$foods->title.' | Pax: '.$foods->pax}}</strong><br> 
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
                            <th style="width:1px">Status</th>
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
                                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                                    @if(count($description->rooms) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->rooms as $rooms)
                                                        Room {{$i++}} <strong>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->cottages) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->cottages as $cottages)
                                                        Cottages {{$i++}}: <strong>{{$cottages->title.' | Pax: '.$cottages->pax}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->foods as $foods)
                                                        Foods {{$i++}}: <strong>{{$foods->title.' | Pax: '.$foods->pax}}</strong><br> 
                                                    @endforeach
                                                    @endif
                                                    @if(count($description->events) > 0)
                                                    <br>
                                                    @php $i=1; @endphp
                                                    @foreach($description->events as $events)
                                                        Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
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
</main>

@endsection