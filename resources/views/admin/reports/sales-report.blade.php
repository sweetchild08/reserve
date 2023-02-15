@extends('layouts.admin.app')
@section('container')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4>{{$title}}</h4>
        </div>

        <div class="header-elements text-center mb-3 mb-lg-0">
            <div class="btn-group">
                <button id="print-report" class="btn btn-sm btn-success mx-2 btn-print-hide">Print</button>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_default" class="btn btn-indigo btn-print-hide">Search</a>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Modal -->
<form method="POST" action="{{url('admin/reports/search')}}" data-parsley-validate>
    @csrf
    <div id="modal_default" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Category</label>
                        <select name="booking_type" class="form-control">
                            <option value="All">All</option>
                            <option value="Rooms">Rooms</option>
                            <option value="Cottages">Cottages</option>
                            <option value="Foods">Foods</option>
                            <option value="Events">Events</option>
                            <option value="Activities">Activities</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Coverage</label>
                        <input type="" class="form-control" name="dates" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="">From</label>
                        <input type="date" class="form-control" name="search_from" value="{{isset($from) ? $from : ''}}" required>
                    </div>

                    <div class="form-group">
                        <label for="">To</label>
                        <input type="date" class="form-control" name="search_to" value="{{isset($to) ? $to : ''}}" required>
                    </div> -->
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /page header -->


<!-- Content area -->
<div class="content pt-0">

    <!-- Basic card -->
    <div class="card">
        <div class="card-header">
            {{-- <h5 class="card-title">Basic card</h5> --}}
        </div>

        <div class="card-body">
            <table class="table datatable-responsive">
                <thead>
                    <tr>
                        <th>Customer Details</th>
                        <th>Description</th>
                        <th>Transaction Details</th>
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
                            <td>{{$r->firstname.'  '.$r->surname}}</td>
                            <td>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                                <div class="collapse show" id="ref{{$r->reference}}">
                                    Adults: <strong>{{$description->adults}}</strong> | Childrens: <strong>{{$description->adults}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
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
                            <td>Transaction Date: <strong>{{$r->created_at}}</strong><br>
                               Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                            </td>
                        </tr>
                        @elseif($r->booking_type == 'Cottages') 
                        <tr>
                            <td>{{$r->firstname.'  '.$r->surname}}</td>
                            <td>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                                <div class="collapse show" id="ref{{$r->reference}}">
                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>
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
                            <td>Transaction Date: <strong>{{$r->created_at}}</strong><br>
                                Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                             </td>
                        </tr>
                        @elseif($r->booking_type == 'Foods') 
                        <tr>
                            <td>{{$r->firstname.'  '.$r->surname}}</td>
                            <td>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                                <div class="collapse show" id="ref{{$r->reference}}">
                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>

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
                            <td>Transaction Date: <strong>{{$r->created_at}}</strong><br>
                                Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                             </td>
                        </tr>
                        @elseif($r->booking_type == 'Events') 
                        <tr>
                            <td>{{$r->firstname.'  '.$r->surname}}</td>
                            <td>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                                <div class="collapse show" id="ref{{$r->reference}}">
                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>

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
                            <td>Transaction Date: <strong>{{$r->created_at}}</strong><br>
                                Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                             </td>
                        </tr>
                        @elseif($r->booking_type == 'Activities') 
                        <tr>
                            <td>{{$r->firstname.'  '.$r->surname}}</td>
                            <td>
                                {{$description->title}} | {{$description->from}} - {{$description->to}} <br>
                                <div class="collapse show" id="ref{{$r->reference}}">
                                    Pax: <strong>{{$description->pax}}</strong> | Rates: <strong>₱{{number_format($description->rates,2)}}</strong> | Days: <strong>{{$description->counter}}</strong> | Partial Payment: <strong>₱{{number_format($description->partial,2)}}</strong> | Total: <strong>₱{{number_format($description->total,2)}}</strong>

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
                            <td>Transaction Date: <strong>{{$r->created_at}}</strong><br>
                                Reference:  <strong>{{$r->reference}}</strong> <br>Payment Type: <strong>{!!$r->payment_type!!}</strong>
                             </td>
                        </tr>
                        @endif
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
    $('#sales-report').addClass('active')
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<style>
    @media print{
        .btn-print-hide{
            display: none;
        }
    }
</style>
<script>
    let btn = document.getElementById('print-report')
    btn.addEventListener('click', () =>{
        window.print()
    })
</script>

<script type="text/javascript">
var date = new Date();

$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('input[name="dates"]').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

$('').daterangepicker({
    "autoApply": false,
    autoUpdateInput: true,
    locale: {
        cancelLabel: 'Clear'
    },
    // isInvalidDate: function(ele) {
    //     var currDate = moment(ele._d).format('YYYY-MM-DD');
    //     return ["2022-06-27","2022-06-29","2022-06-30"].indexOf(currDate) != -1;
    // }
}).on('apply.daterangepicker', function(ev, picker) {
    var start = moment(picker.startDate.format('YYYY-MM-DD'));
    var end = moment(picker.endDate.format('YYYY-MM-DD'));
    var diff = start.diff(end, 'days'); // returns correct number
    var day = Math.abs(diff);
    var days = day == 0 ? 1 : day + 1;
});

$('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});

function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}
</script>
@endsection