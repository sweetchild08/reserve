<div>
    <nav>
        <ul>
            <li><a href="#">Santorenz Bay Resort Point of Sales</a></li>

            <li><a href="{{url('admin/dashboard')}}"><i class="fa-solid fa-rotate-left"></i>Return to Dashboard</a></li>
            <li><a href="#" onclick="clearbooking()">Clear Booking</a></li>
        </ul>

        <div class="search">
            <!-- <button class="btn btn-primary">Clear Booking</button> -->
        </div>
    </nav>

    <div class="sellables-container">
        <div class="sellables" style="margin-right: 30%;position: fixed;bottom: 1em;left: 1em;top: 3em;">
            <div class="categories">
                <a class="category active" onclick="category(event, 'rooms')">Rooms</a>
                <a class="category" onclick="category(event, 'cottages')">Cottage</a>
                <a class="category" onclick="category(event, 'foods')">Foods</a>
                <a class="category" onclick="category(event, 'activities')">Activities</a>
                <a class="category" onclick="category(event, 'events')">Events</a>
                <a class="category" href="{{url('santorenz-reservation/terms-agreement')}}">Reserve Whole Resort</a>

            </div>

            <div class="item-group-wrapper" style="overflow:auto">
                <!-- <form action=""> -->
                <div class="item-group" id="rooms" style="display:flex">
                    @foreach($rooms as $room)
                    <a href="#"
                        onclick="add('rooms', {{ $room->id }},'rooms','{{ $room->title }}','{{ $room->image }}')"
                        class="item p-0" style="width: 160px;border-radius: .6em;">
                        <div style="background-image: url({{ asset('assets/images/rooms/'.$room->image) }}); height: 100px;background-position: center;background-size: contain;border-radius: .6em;">
                        </div>
                        <div class="p-3" style="background:#0D8AEE;border-radius: .6em;">
                            {{ ucwords($room->title) }}<br />
                            <span style="font-size:9px;">Adults: {{ $room->adults }} | Children:
                                {{ $room->childrens }}</span><br />
                            <span><b>Php. {{ number_format($room->rate,2) }}</b></span>
                        </div>
                        <input type="hidden" name="rooms[]" value="{{$room->id}}">
                    </a>
                    @endforeach
                </div>

                <div class="item-group" id="cottages" style="display:none">
                    @foreach($cottages as $cottage)
                    {{--dd($cottages)--}}
                    <a href="#"
                        onclick="add('cottages', {{ $cottage->id }},'cottages','{{ $cottage->title }}','{{ $cottage->image }}')"
                        class="item p-0" style="width: 160px;border-radius: .6em;">
                        <div style="background-image: url({{ asset('assets/images/cottages/'.$cottage->image) }}); height: 100px;background-position: center;background-size: contain;border-radius: .6em;">
                        </div>
                        <div class="p-3" style="background:#0D8AEE;border-radius: .6em;">
                            {{ ucwords($cottage->title) }}<br />
                            <span style="font-size:9px;">Pax: {{ $cottage->pax }}</span><br />
                            <span><b>Php. {{ number_format($cottage->rate,2) }}</b></span>
                        </div>
                        <input type="hidden" name="cottages[]" value="{{$cottage->id}}">
                    </a>
                    @endforeach
                </div>

                <div class="item-group" id="activities" style="display:none">
                    @foreach($activities as $activity)
                    <a href="#"
                        onclick="add('activities', {{ $activity->id }},'activities','{{ $activity->title }}','{{ $activity->image }}')"
                        class="item p-0" style="width: 160px;border-radius: .6em;">
                        <div style="background-image: url({{ asset('assets/images/activities/'.$activity->image) }}); height: 100px;background-position: center;background-size: contain;border-radius: .6em;">
                        </div>
                        <div class="p-3" style="background:#0D8AEE;border-radius: .6em;">
                            {{ ucwords($activity->title) }}<br />
                            <span style="font-size:9px;">Pax: {{ $activity->pax }}</span><br />
                            <span><b>Php. {{ number_format($activity->rate,2) }}</b></span>
                        </div>
                        <input type="hidden" name="activities[]" value="{{$activity->id}}">
                    </a>
                    @endforeach
                </div>

                <div class="item-group" id="events" style="display:none">
                    @foreach($events as $event)
                    <a href="#"
                        onclick="add('events', {{ $event->id }},'events','{{ $event->title }}','{{ $event->image }}')"
                        class="item p-0" style="width: 160px;border-radius: .6em;">
                        <div style="background-image: url({{ asset('assets/images/events/'.$event->image) }}); height: 100px;background-position: center;background-size: contain;border-radius: .6em;">
                        </div>
                        <div class="p-3" style="background:#0D8AEE;border-radius: .6em;">
                            {{ ucwords($event->title) }}<br />
                            <span style="font-size:9px;">Pax: {{ $event->pax }}</span><br />
                            <span><b>Php. {{ number_format($event->rate,2) }}</b></span>
                        </div>
                        <input type="hidden" name="events[]" value="{{$event->id}}">
                    </a>
                    @endforeach
                </div>

                <!-- <div class="item-group">
              <a href="#" class="item">Bud Light</a>
              <a href="#" class="item">Bud Light</a>
              <a href="#" class="item">Bud Light</a>
              <a href="#" class="item">Bud Light</a>
              <a href="#" class="item">Bud Light</a>
            </div> -->
            </div>
        </div>

        <div class="register-wrapper" style="position: fixed;right: 1em;bottom: 6em;top: 3.5em;">
            <div class="customer">
                <div class="form_date">
                    <!-- <h2 class="font-weight-bolder">1500</h2> -->
                    <input type="text" name="dates" autocomplete="off" />
                </div>
            </div>

            <div class="register" style="height:100%;overflow: auto;">
                <div class="products">

                    <div id="product-overview-temp" hidden>
                        <p id="product-overview-temp-category" hidden></p>
                        <p id="product-overview-temp-id" hidden></p>
                        <h3 id="product-overview-temp-title"></h3>

                        <div id="product-overview-temp-images-container">
                            <img id="product-overview-temp-image" src="{{asset('assets/images/rooms/')}}" alt="Image"
                                style="height:230px">
                        </div>
                        {{-- TODO: append here your ideal layout --}}
                    </div>

                    <div id="product-overview">
                    </div>

                    <!-- 
                <div class="pay-button">
                    <a href="#" id="" onClick="reserveToPay()">Select Php. <span id="product-overview-total"></span></a>
                </div>

                <div style="width: 100%">
                    <hr>
                </div> -->

                    @php $total = 0; @endphp

                    @if(Session::has('rooms'))
                    @foreach(Session::get('rooms') as $room)
                    <div class="product-bar">
                        <span>{{$room[0]['title']}}</span>
                        <b>{{'Php. '.number_format($room[0]['rate'],2)}}</b>
                    </div>
                    @php $total += $room[0]['rate'] @endphp
                    @endforeach
                    @endif

                    @if(Session::has('cottages'))
                    @foreach(Session::get('cottages') as $cottage)
                    <div class="product-bar">
                        <span>{{$cottage[0]['title']}}</span>
                        <b>{{'Php. '.number_format($cottage[0]['rate'],2)}}</b>
                    </div>
                    @php $total += $cottage[0]['rate'] @endphp
                    @endforeach
                    @endif

                    @if(Session::has('activities'))
                    @foreach(Session::get('activities') as $activity)
                    <div class="product-bar">
                        <span>{{$activity[0]['title']}}</span>
                        <b>{{'Php. '.number_format($activity[0]['rate'],2)}}</b>
                    </div>
                    @php $total += $activity[0]['rate'] @endphp
                    @endforeach
                    @endif

                    @if(Session::has('events'))
                    @foreach(Session::get('events') as $event)
                    <div class="product-bar">
                        <span>{{$event[0]['title']}}</span>
                        <b>{{'Php. '.number_format($event[0]['rate'],2)}}</b>
                    </div>
                    @php $total += $event[0]['rate'] @endphp
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="produc">
                <div class="product-ba d-flex justify-content-between">
                    <div class="mr-3">Total</div>
                    <h1 class="font-weight-bolder">₱{{ number_format($total,2) }}</h1>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" data-toggle="modal" data-target="#checkout" type="button"
                        style="position:fixed;bottom: 1em; right: 3em;padding: .6em;font-size: 18px;z-index: 999;width: 200px;border-radius: 5em;">Checkout</button>

    <div class="modal " id="checkout" tabindex="-1">
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
                                        <input type="hidden" name="booking_id" value="">
                                        <input type="hidden" name="days_counter" id="days_counter">
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
                                        </table>
                                    </div>
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
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div> -->
            </form>
        </div>
    </div>
</div>

</div>