<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>
</head>
<body onload="print()">
    <div style="margin:auto;width:100%;">
        <h3 style="font-family:'century gothic';text-align:center">
            SANTORENZ BAY RESORT AND HOTEL <br> 
            TRANSACTION REPORT <br>
            As of {{date('F j, Y',strtotime($from))}} - {{date('F j, Y',strtotime($to))}} <br>
            <small>{{$reports->count()}} RESULTS FOUND </small>
        </h3>
        <table cellspacing=0 style="width:100%">
            <thead>
                <tr>
                    <th style="padding:10px;border:1px solid #000;text-align:left">Customer Details</th>
                    <th style="padding:10px;border:1px solid #000;text-align:left">Description</th>
                    <th style="padding:10px;border:1px solid #000;text-align:left;width:1px">Category</th>
                    <th style="padding:10px;border:1px solid #000;text-align:left">Transaction Details</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp
                @foreach($reports as $r)
                    @php 
                        $description = json_decode($r->description);
                    @endphp
                    @if($r->booking_type == 'Rooms') 
                    <tr>
                        <td style="padding:10px;border:1px solid #000">{{$r->firstname.'  '.$r->surname}} <br> {{$r->contact}}</td>
                        <td style="padding:10px;border:1px solid #000">
                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                            <div class="collapse show" id="ref{{$r->reference}}">
                                Adults: <strong>{{$description->adults}}</strong> | Childrens: <strong>{{$description->adults}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                <br>
                                @if(count($description->cottages) > 0)
                                <br>
                                @php $i=1; @endphp
                                @foreach($description->cottages as $ctg)
                                    Cottage {{$i++}}: <strong>{{$ctg->title.' | Pax: '.$ctg->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->meals) > 0)
                                @php $i=1; @endphp
                                @foreach($description->meals as $meals)
                                    Meal {{$i++}}: <strong>{{$meals->title.' | Pax: '.$meals->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->events) > 0)
                                @php $i=1; @endphp
                                @foreach($description->events as $events)
                                    Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->activities) > 0)
                                @php $i=1; @endphp
                                @foreach($description->activities as $activities)
                                    Activities {{$i++}}: <strong>{{$activities->title.' | Pax: '.$activities->pax}}</strong><br> 
                                @endforeach
                                @endif
                            </div>
                        </td>
                        <td style="padding:10px;border:1px solid #000">{!!$r->booking_type!!}</strong>
                        </td>

                        <td style="padding:10px;border:1px solid #000">Transaction Date: <strong>{{$r->created_at}}</strong><br>
                           Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                        </td>
                    </tr>
                    @elseif($r->booking_type == 'Cottages') 
                    <tr>
                        
                        <td style="padding:10px;border:1px solid #000">{{$r->firstname.'  '.$r->surname}} <br> {{$r->contact}}</td>
                        <td style="padding:10px;border:1px solid #000">
                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                            <div class="collapse show" id="ref{{$r->reference}}">
                                Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                <br>
                                @if(count($description->rooms) > 0)
                                @php $i=1; @endphp
                                @foreach($description->rooms as $rooms)
                                    Room {{$i++}} <strong>{{$rooms->title.' | Adults: '.$rooms->adults.' | Childrens: '.$rooms->childrens.' | Description: '. $rooms->description}}</strong><br> 
                                @endforeach
                                @endif
                                @if(count($description->meals) > 0)
                                @php $i=1; @endphp
                                @foreach($description->meals as $meals)
                                    Meal {{$i++}}: <strong>{{$meals->title.' | Pax: '.$meals->pax}}</strong><br> 
                                @endforeach
                                @endif
                                @if(count($description->events) > 0)
                                @php $i=1; @endphp
                                @foreach($description->events as $events)
                                    Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->activities) > 0)
                                @php $i=1; @endphp
                                @foreach($description->activities as $activities)
                                    Activities {{$i++}}: <strong>{{$activities->title.' | Pax: '.$activities->pax}}</strong><br> 
                                @endforeach
                                @endif
                            </div>
                        </td>
                        <td style="padding:10px;border:1px solid #000">{!!$r->booking_type!!}</strong>
                            <td style="padding:10px;border:1px solid #000">Transaction Date: <strong>{{$r->created_at}}</strong><br>
                            Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                         </td>
                    </tr>
                    @elseif($r->booking_type == 'Foods') 
                    <tr>
                        
                        <td style="padding:10px;border:1px solid #000">{{$r->firstname.'  '.$r->surname}} <br> {{$r->contact}}</td>
                        <td style="padding:10px;border:1px solid #000">
                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                            <div class="collapse show" id="ref{{$r->reference}}">
                                Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                <br>

                                @if(count($description->rooms) > 0)
                                @php $i=1; @endphp
                                @foreach($description->rooms as $rooms)
                                    Rooms {{$i++}}: Adults: <strong>{{$rooms->adults}}</strong> | Childrens: <strong>{{$rooms->adults}}</strong></strong> <br>
                                @endforeach
                                @endif

                                @if(count($description->cottages) > 0)
                                @php $i=1; @endphp
                                @foreach($description->cottages as $ctg)
                                    Cottage {{$i++}}: <strong>{{$ctg->title.' | Pax: '.$ctg->pax}}</strong><br> 
                                @endforeach
                                @endif

                                

                                @if(count($description->events) > 0)
                                @php $i=1; @endphp
                                @foreach($description->events as $events)
                                    Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->activities) > 0)
                                @php $i=1; @endphp
                                @foreach($description->activities as $activities)
                                    Activities {{$i++}}: <strong>{{$activities->title.' | Pax: '.$activities->pax}}</strong><br> 
                                @endforeach
                                @endif

                            </div>
                        </td>
                        <td style="padding:10px;border:1px solid #000">{!!$r->booking_type!!}</strong>
                        <td style="padding:10px;border:1px solid #000">Transaction Date: <strong>{{$r->created_at}}</strong><br>
                            Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                         </td>
                    </tr>
                    @elseif($r->booking_type == 'Events') 
                    <tr>
                        
                        <td style="padding:10px;border:1px solid #000">{{$r->firstname.'  '.$r->surname}} <br> {{$r->contact}}</td>
                        <td style="padding:10px;border:1px solid #000">
                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                            <div class="collapse show" id="ref{{$r->reference}}">
                                Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                <br>

                                @if(count($description->rooms) > 0)
                                @php $i=1; @endphp
                                @foreach($description->rooms as $rooms)
                                    Rooms {{$i++}}: Adults: <strong>{{$rooms->adults}}</strong> | Childrens: <strong>{{$rooms->adults}}</strong></strong> <br>
                                @endforeach
                                @endif

                                @if(count($description->cottages) > 0)
                                @php $i=1; @endphp
                                @foreach($description->cottages as $ctg)
                                    Cottage {{$i++}}: <strong>{{$ctg->title.' | Pax: '.$ctg->pax}}</strong><br> 
                                @endforeach
                                @endif

                                

                                @if(count($description->foods) > 0)
                                @php $i=1; @endphp
                                @foreach($description->foods as $foods)
                                    Foods {{$i++}}: <strong>{{$foods->title.' | Pax: '.$foods->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->activities) > 0)
                                @php $i=1; @endphp
                                @foreach($description->activities as $activities)
                                    Activities {{$i++}}: <strong>{{$activities->title.' | Pax: '.$activities->pax}}</strong><br> 
                                @endforeach
                                @endif

                            </div>
                        </td>
                        <td style="padding:10px;border:1px solid #000">{!!$r->booking_type!!}</strong>
                        <td style="padding:10px;border:1px solid #000">Transaction Date: <strong>{{$r->created_at}}</strong><br>
                            Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                         </td>
                    </tr>
                    @elseif($r->booking_type == 'Activities') 
                    <tr>
                        
                        <td style="padding:10px;border:1px solid #000">{{$r->firstname.'  '.$r->surname}} <br> {{$r->contact}}</td>
                        <td style="padding:10px;border:1px solid #000">
                            {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                            <div class="collapse show" id="ref{{$r->reference}}">
                                Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
                                <br>

                                @if(count($description->rooms) > 0)
                                @php $i=1; @endphp
                                @foreach($description->rooms as $rooms)
                                    Rooms {{$i++}}: Adults: <strong>{{$rooms->adults}}</strong> | Childrens: <strong>{{$rooms->adults}}</strong></strong> <br>
                                @endforeach
                                @endif

                                @if(count($description->cottages) > 0)
                                @php $i=1; @endphp
                                @foreach($description->cottages as $ctg)
                                    Cottage {{$i++}}: <strong>{{$ctg->title.' | Pax: '.$ctg->pax}}</strong><br> 
                                @endforeach
                                @endif

                                

                                @if(count($description->foods) > 0)
                                @php $i=1; @endphp
                                @foreach($description->foods as $foods)
                                    Foods {{$i++}}: <strong>{{$foods->title.' | Pax: '.$foods->pax}}</strong><br> 
                                @endforeach
                                @endif

                                @if(count($description->events) > 0)
                                @php $i=1; @endphp
                                @foreach($description->events as $events)
                                    Events {{$i++}}: <strong>{{$events->title.' | Pax: '.$events->pax}}</strong><br> 
                                @endforeach
                                @endif

                            </div>
                        </td>
                        <td style="padding:10px;border:1px solid #000">{!!$r->booking_type!!}</strong>
                        <td style="padding:10px;border:1px solid #000">Transaction Date: <strong>{{$r->created_at}}</strong><br>
                            Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                         </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
    </div>
   
</body>
</html>