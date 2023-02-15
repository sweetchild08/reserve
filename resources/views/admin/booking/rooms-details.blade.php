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

    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('services/reservation/addons_set_a')}}" method="POST" id="submitFDF">
                        @csrf
                        <p class="title">ADD-ONS (COTTAGES)</p>
                        <div class="row">
                            @foreach($addons_cottages as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_cottages[]" type="checkbox"
                                        value="{{$data->id}}" id="cottages{{$data->id}}"
                                        onclick="$('#submitFDF').submit()">
                                    <label class="form-check-label" for="cottages{{$data->id}}">
                                        @if($data->category_name == 'Nipa Hut')
                                        {{$data->category_name.' '.$data->title.' - ₱'.number_format($data->rate,2)}}
                                        @else
                                        {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                        @endif
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>

                        <p class="title">ADD-ONS (FOODS)</p>
                        <div class="row">
                            @foreach($addons_foods as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_foods[]" type="checkbox"
                                        value="{{$data->id}}" id="foods{{$data->id}}"
                                        onclick="$('#submitFDF').submit()">
                                    <label class="form-check-label" for="foods{{$data->id}}">
                                        {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>

                        <p class="title">ADD-ONS (ACTIVITIES)</p>
                        <div class="row">
                            @foreach($addons_activities as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_activities[]" type="checkbox"
                                        value="{{$data->id}}" id="activities{{$data->id}}"
                                        onclick="$('#submitFDF').submit()">
                                    <label class="form-check-label" for="activities{{$data->id}}">
                                        {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>

                        <p class="title">ADD-ONS (EVENTS)</p>
                        <div class="row">
                            @foreach($addons_events as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_events[]" type="checkbox"
                                        value="{{$data->id}}" id="events{{$data->id}}"
                                        onclick="$('#submitFDF').submit()">
                                    <label class="form-check-label" for="events{{$data->id}}">
                                        {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- <div class=" mt-2">
                            <button class="btn btn-primary btn-block"
                            onclick="return confirm('Are you sure want to add this addons?');" type="submit">UPDATE
                            ADD-ONS</button>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title font-weight-bold">Transaction Details</div>

                    <div class="row">
                        <table class="table">
                            <tr>
                                <td class="text-left">Rate / Day (Room)</td>
                                <td class="text-right">₱{{number_format($query->rate,2)}}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Cottages)</td>
                                <td class="text-right">₱<span
                                        id="cottages">@if(Session::has('total_cottages_rate')){{number_format(Session::get('total_cottages_rate'),2)}}
                                        @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Foods)</td>
                                <td class="text-right">₱<span
                                        id="meals">@if(Session::has('total_foods_rate')){{number_format(Session::get('total_foods_rate'),2)}}
                                        @else{{number_format(0,2)}} @endif</span></td>
                            </tr>


                            <tr>
                                <td class="text-left">Add-Ons (Activities)</td>
                                <td class="text-right">₱<span
                                        id="activities">@if(Session::has('total_activities_rate')){{number_format(Session::get('total_activities_rate'),2)}}
                                        @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Events)</td>
                                <td class="text-right">₱<span
                                        id="events">@if(Session::has('total_events_rate')){{number_format(Session::get('total_events_rate'),2)}}
                                        @else{{number_format(0,2)}} @endif</span></td>
                            </tr>


                            <tr>
                                <td class="text-left">Days</td>
                                <td class="text-right"><span id="days">1</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Total</td>

                                <td class="text-right">
                                    <h2 class="font-weight-bold text-success">₱<span
                                            id="total">@if(Session::has('total_rates')){{number_format(Session::get('total_rates') + $query->rate,2)}}
                                            @else{{number_format($query->rate,2)}} @endif</span></h2>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#checkout" type="button"
                        style="position:fixed;bottom: 2em; right: 2em;padding: .6em;font-size: 18px;z-index: 999;width: 200px;border-radius: 5em;">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /basic card -->


</div>

<div class="modal" id="checkout" tabindex="-1">
    <div class="modal-dialog modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-titl font-weight-bold" id="exampleModalLabel">CHECKOUT</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{url('admin/bookings/reservation')}}" data-parsley-validate>
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Customer Details</div>
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{$id}}">
                                        <input type="hidden" name="days_counter" id="days_counter">
                                        <input type="hidden" name="total_rates" id="total_rates"
                                            value="@if(Session::has('total_rates')){{(Session::get('total_rates') + $query->rate)}} @else{{($query->rate)}} @endif">
                                        <input type="hidden" name="category" value="Rooms">
                                        <input type="hidden" name="is_order" value="1">
                                        <div class="form-group">
                                            <label for="">Surname</label>
                                            <input class="form-control" name="surname" required type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <input class="form-control" name="firstname" required type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Middle Name</label>
                                            <input class="form-control" name="middlename" required type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Contact</label>
                                            <input class="form-control" name="contact" required type="text">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input class="form-control" name="email" required type="email">
                                        </div>

                                        <div class="form-group">
                                            <input type="hidden" name="adults" value="{{$query->adults}}">
                                            <input class="form-control" name="booking-name"
                                                value="{{$query->adults}} Adults" disabled type="text">
                                        </div>

                                        <div class="form-group">
                                            <input type="hidden" name="childrens" value="{{$query->childrens}}">
                                            <input class="form-control" name="booking-name"
                                                value="{{$query->childrens}} Childrens" disabled type="text">
                                        </div>

                                        <!-- <button class="btn btn-primary btn-block"
                            onclick="return confirm('Are you sure want to complete this reservation?');"
                            type="submit">Checkout</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <input type="text" class="form-control md_noborder_right" style="width:100%"
                                        name="dates" autocomplete=off placeholder="Reservation Date" required>
                                    <br><br>
                                    <div class="card-title font-weight-bold">Transaction Details</div>

                                    <div class="">
                                        <table class="table">
                                            <tr>
                                                <td class="text-left">Rate / Day (Room)</td>
                                                <td class="text-right">₱{{number_format($query->rate,2)}}</td>
                                            </tr>

                                            <tr>
                                                <td class="text-left">Add-Ons (Cottages)</td>
                                                <td class="text-right">₱<span
                                                        id="cottages">@if(Session::has('total_cottages_rate')){{number_format(Session::get('total_cottages_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left">Add-Ons (Foods)</td>
                                                <td class="text-right">₱<span
                                                        id="meals">@if(Session::has('total_foods_rate')){{number_format(Session::get('total_foods_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>


                                            <tr>
                                                <td class="text-left">Add-Ons (Activities)</td>
                                                <td class="text-right">₱<span
                                                        id="activities">@if(Session::has('total_activities_rate')){{number_format(Session::get('total_activities_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left">Add-Ons (Events)</td>
                                                <td class="text-right">₱<span
                                                        id="events">@if(Session::has('total_events_rate')){{number_format(Session::get('total_events_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>


                                            <tr>
                                                <td class="text-left">Days</td>
                                                <td class="text-right"><span id="day">1</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left">Total</td>

                                                <td class="text-right">
                                                    <h2 class="font-weight-bold text-success">₱<span id="totals">
                                                            @if(Session::has('total_rates'))
                                                            {{ number_format(Session::get('total_rates') + $query->rate,2) }}
                                                            @else
                                                            {{ number_format($query->rate,2) }}
                                                            @endif</span></h2>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <input type="hidden" name="gtotal" id="gtotal" class="form-control form-control-lg" value="@if(Session::has('total_rates'))
                                                {{ Session::get('total_rates') + $query->rate }}
                                            @else
                                                {{ $query->rate }}
                                            @endif">
                                    <div class="d-flex">
                                        <div class="form-group mr-2">
                                            <label class="form-label">Amount Rendered</label>
                                            <input type="" name="render" class="form-control" onkeyup="$('#change').val($(this).val()-$('#gtotal').val());$('#cashTendered').html('₱'+numberWithCommas($(this).val()));$('#cashChanged').html('₱'+numberWithCommas($(this).val()-$('#gtotal').val()));" style="font-size:20px;font-weight: bolder;">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Change</label>
                                            <input type="" name="" id="change" class="form-control form-control-lg" readonly style="font-size:20px;font-weight: bolder;">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block" style="font-size: 18px;">Pay</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none">
                            <div class="card">
                                <div class="card-body" id="DivIdToPrint">
                                    <div class="text-center" style="text-align: center;">
                                        <img src="{{url('admin/assets/images/sbrlogo.png')}}" style="width: 30%;">
                                        <h4 class="mt-2 font-weight-bold">OFFICIAL RECEIPT</h4>
                                        <div>
                                        Order ID: 
                                        @if(Session::has('OrderID'))
                                        {{ 
                                            Session::get('OrderID')
                                        }}
                                        @endif
                                    </div>
                                    </div><br><br>
                                    <table class="table">
                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Add-Ons (Cottages)</td>
                                                <td class="text-right">₱<span
                                                        id="cottages">@if(Session::has('total_cottages_rate')){{number_format(Session::get('total_cottages_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Add-Ons (Foods)</td>
                                                <td class="text-right">₱<span
                                                        id="meals">@if(Session::has('total_foods_rate')){{number_format(Session::get('total_foods_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>


                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Add-Ons (Activities)</td>
                                                <td class="text-right">₱<span
                                                        id="activities">@if(Session::has('total_activities_rate')){{number_format(Session::get('total_activities_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Add-Ons (Events)</td>
                                                <td class="text-right">₱<span
                                                        id="events">@if(Session::has('total_events_rate')){{number_format(Session::get('total_events_rate'),2)}}
                                                        @else{{number_format(0,2)}} @endif</span></td>
                                            </tr>


                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Days</td>
                                                <td class="text-right"><span id="day">1</span></td>
                                            </tr>

                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Total</td>

                                                <td class="text-right">
                                                    <h5 class="font-weight-bold">₱<span id="totals">
                                                            @if(Session::has('total_rates'))
                                                            {{ number_format(Session::get('total_rates') + $query->rate,2) }}
                                                            @else
                                                            {{ number_format($query->rate,2) }}
                                                            @endif</span></h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Cash Tendered</td>
                                                <td class="text-right"><h5 id="cashTendered" class="font-weight-bold">0</h5></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left" style="padding-left: 0;">Change</td>
                                                <td class="text-right"><h5 id="cashChanged" class="font-weight-bold">0</h5></td>
                                            </tr>
                                        </table>

                                        <center>Thank you! Come again..</center>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="button" onclick="DivIdToPrint()">Print Receipt</button>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div> -->
            </form>
        </div>
    </div>
</div>

<!-- /content area -->
@endsection
@section('custom')
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@php
if(Session::has('addons_cottages')) {
$addons_cottages = Session::get('addons_cottages');
} else {
$addons_cottages = [];
}
if(Session::has('addons_foods')) {
$addons_foods = Session::get('addons_foods');
} else {
$addons_foods = [];
}

if(Session::has('addons_events')) {
$addons_events = Session::get('addons_events');
} else {
$addons_events = [];
}

if(Session::has('addons_activities')) {
$addons_activities = Session::get('addons_activities');
} else {
$addons_activities = [];
}
@endphp
<script>
// Check #x
@foreach($addons_foods as $data)
var food_id = '{{$data}}';
$("#foods" + food_id).prop("checked", true);
@endforeach

@foreach($addons_cottages as $data)
var cottages_id = '{{$data}}';
$("#cottages" + cottages_id).prop("checked", true);
@endforeach

@foreach($addons_events as $data)
var events_id = '{{$data}}';
$("#events" + events_id).prop("checked", true);
@endforeach

@foreach($addons_activities as $data)
var activities_id = '{{$data}}';
$("#activities" + activities_id).prop("checked", true);
@endforeach

// HAHAHAHAHHA
var date = new Date();
date.setDate(date.getDate())
$('input[name="dates"]').daterangepicker({
    "autoApply": false,
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    },
    minDate: date,
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
    var rate = '{{Session::has("total_rates") ? Session::get("total_rates") + $query->rate  : $query->rate}}' *
        days;
    $('#days_counter').val(days)
    $("#days,#day").html(days)
    $('#total_rates').val(rate);
    $('#total,#totals').html(numberWithCommas(rate.toFixed(2)))
    $('#gtotal').val(rate)
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

function DivIdToPrint() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();
  newWin.document.write('<html><style href="{{ asset("admin/assets/css/all.min.css") }}"></style><style href="{{ asset("admin/assets/css/icons/icomoon/styles.min.css") }}"></style><style href="{{ asset("assets/parsley/parsley.css") }}"></style><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

</script>
<script>
$('#bookings-must-open').addClass('nav-item-open nav-item-expanded')
$('#bookings-rooms').addClass('active')
</script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{url('admin/assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
<script src="{{url('admin/assets/js/demo_pages/datatables_responsive.js')}}"></script>
@endsection