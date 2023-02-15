<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title }}</title>
    <link href="{{asset('assets/css/point-of-sale.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fontawesome/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    @livewireStyles
</head>
<body>
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
    <div class="sellables">
        <div class="categories">
            <a class="category active" onclick="category(event, 'rooms')">Rooms</a>
            <a class="category active" onclick="category(event, 'cottages')">Cottage</a>
            <a class="category active" onclick="category(event, 'foods')">Foods</a>
            <a class="category active" onclick="category(event, 'activities')">Activities</a>
            <a class="category active" onclick="category(event, 'events')">Events</a>
            <a class="category activve" onclick="category(event, 'terms-agreement')">Reserve Whole Resort</a>

        </div>

        <div class="item-group-wrapper">
            <!-- <form action=""> -->
            <div class="item-group" id="rooms" style="display:flex">
                @foreach($rooms as $room)
                    {{--dd($room)--}}
                    <a href="#" onclick="add('rooms', {{ $room->id }})" class="item">
                        {{ ucwords($room->title) }}<br/>
                        <span
                            style="font-size:9px;">Adults: {{ $room->adults }} | Children: {{ $room->childrens }}</span><br/>
                        <span><strong>Php. {{ number_format($room->rate,2) }}</strong></span>
                        <input type="hidden" name="rooms[]" value="{{$room->id}}">
                    </a>
                @endforeach
            </div>

            <div class="item-group" id="cottages" style="display:none">
                @foreach($cottages as $cottage)
                    {{--dd($cottages)--}}
                    <a href="#" onclick="add('cottages', {{ $cottage->id }})" class="item">
                        {{ ucwords($cottage->title) }}<br/>
                        <span style="font-size:9px;">Pax: {{ $cottage->pax }}</span><br/>
                        <span><strong>Php. {{ number_format($cottage->rate,2) }}</strong></span>
                        <input type="hidden" name="cottages[]" value="{{$cottage->id}}">
                    </a>
                @endforeach
            </div>

            <div class="item-group" id="activities" style="display:none">
                @foreach($activities as $activity)
                    <a href="#" onclick="add('activities', {{ $activity->id }})" class="item">
                        {{ ucwords($activity->title) }}<br/>
                        <span style="font-size:9px;">Pax: {{ $activity->pax }}</span><br/>
                        <span><strong>Php. {{ number_format($activity->rate,2) }}</strong></span>
                        <input type="hidden" name="activities[]" value="{{$activity->id}}">
                    </a>
                @endforeach
            </div>

            <div class="item-group" id="events" style="display:none">
                @foreach($events as $event)
                    <a href="#" onclick="add('events', {{ $event->id }})" class="item">
                        {{ ucwords($event->title) }}<br/>
                        <span style="font-size:9px;">Pax: {{ $event->pax }}</span><br/>
                        <span><strong>Php. {{ number_format($event->rate,2) }}</strong></span>
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

    <div class="register-wrapper">
        <div class="customer">
            <div class="form_date">
                <input type="text" name="dates"/>
            </div>
        </div>

        <div class="register">
            <div class="products">

                <div id="product-overview-temp" hidden>
                    <p id="product-overview-temp-category" hidden></p>
                    <p id="product-overview-temp-id" hidden></p>
                    <h3 id="product-overview-temp-title"></h3>

                    <div id="product-overview-temp-images-container">
                        <img id="product-overview-temp-image" src="{{asset('assets/images/rooms/')}}" alt="Image" style="height:230px">
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
                            <span>{{'Php. '.number_format($room[0]['rate'],2)}}</span>
                        </div>
                        @php $total += $room[0]['rate'] @endphp
                    @endforeach
                @endif

                @if(Session::has('cottages'))
                    @foreach(Session::get('cottages') as $cottage)
                        <div class="product-bar">
                            <span>{{$cottage[0]['title']}}</span>
                            <span>{{'Php. '.number_format($cottage[0]['rate'],2)}}</span>
                        </div>
                        @php $total += $cottage[0]['rate'] @endphp
                    @endforeach
                @endif

                @if(Session::has('activities'))
                    @foreach(Session::get('activities') as $activity)
                        <div class="product-bar">
                            <span>{{$activity[0]['title']}}</span>
                            <span>{{'Php. '.number_format($activity[0]['rate'],2)}}</span>
                        </div>
                        @php $total += $activity[0]['rate'] @endphp
                    @endforeach
                @endif

                @if(Session::has('events'))
                    @foreach(Session::get('events') as $event)
                        <div class="product-bar">
                            <span>{{$event[0]['title']}}</span>
                            <span>{{'Php. '.number_format($event[0]['rate'],2)}}</span>
                        </div>
                        @php $total += $event[0]['rate'] @endphp
                    @endforeach
                @endif

                <div class="product-bar">

                </div>
            </div>

            <div class="pay-button">
                <div class="row" style="margin-left: 1em;">
                    <div class="col-md-6">
                        <label class="form-label">Amount</label>
                        <input style="padding: .5em;border-radius: .3em;font-size: 18px;font-weight: bold;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Change</label>
                        <input style="padding: .5em;border-radius: .3em;" type="text">
                    </div>
                </div>
                <a href="#" style="padding:1em" id="" onClick="printReceipt()">Pay Php. <span id="total">{{ number_format($total,2) }}</span></a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="{{asset('fontawesome/bootstrap.bundle.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    var date = new Date();
    date.setDate(date.getDate() + 5)
    $('input[name="dates"]').daterangepicker({
        "autoApply": true,
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        minDate: date,
        // isInvalidDate: function(ele) {
        //     var currDate = moment(ele._d).format('YYYY-MM-DD');
        //     return ["2022-06-27","2022-06-29","2022-06-30"].indexOf(currDate) != -1;
        // }
    }).on('apply.daterangepicker', function (ev, picker) {
        var start = moment(picker.startDate.format('YYYY-MM-DD'));
        var end = moment(picker.endDate.format('YYYY-MM-DD'));
        var diff = start.diff(end, 'days'); // returns correct number
        var day = Math.abs(diff);
        var days = day == 0 ? 1 : day + 1;

        $('#days_counter').val(days)
        $("#days").html(days)
        //$('#total_rates').val(rate);
        $('#total').html(numberWithCommas('{{$grand_total}}' * days));
    });

    $('input[name="dates"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="dates"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    function numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }

    function category(evt, cat) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("item-group");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("category");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cat).style.display = "flex";
        evt.currentTarget.className += " active";
    }

    function add(category, id) {
        
        // console.log(product);
        // // const productOverviewEl = document.getElementById('product-overview')
        // // const categoryEl = document.getElementById('product-overview-temp-category')
        // // const idEl = document.getElementById('product-overview-temp-id')
        // // const titleEl = document.getElementById('product-overview-temp-title')
        // // const imageContainerEl = document.getElementById('product-overview-temp-images-container')
        // // const imageEl = document.getElementById('product-overview-temp-image')
        // // // TODO: update here what you want see on the product overview sidebar
        // // const productOverviewTempEl = document.getElementById('product-overview-temp')

        // // const prefix = `{{asset('assets/images/rooms')}}`
        // // console.info(`${prefix}/${product.gallery}`)
        // // imageEl.src = `${prefix}/${product.gallery}`

        // // // clear the template
        // // categoryEl.innerText = category
        // // idEl.innerText = product.id
        // // titleEl.innerHTML = product.title

        // // productOverviewEl.innerHTML = productOverviewTempEl.innerHTML

        // // const payEl = document.getElementById('product-overview-total')

        // // payEl.innerHTML = product.rate.toLocaleString('en', {
        // //     // 2 decimal places
        // //     minimumFractionDigits: 2,
        // //     maximumFractionDigits: 2
        // // })

        Swal.fire({
            title: 'Are you sure you want to add this to your Booking?',
            text: "",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'I Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: '/admin/transactions/add_pos_test',
                    data: {
                        _token: '{{csrf_token()}}',
                        category: category, 
                        id: id
                    }, 
                    //dataType: 'json',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title:' Added Succesfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        console.log(data);
                        location.reload();
                    }
                });
            }
        });
    }

    function reserveToPay(type, value) {
        
        const category = document.getElementById('product-overview-temp-category').innerText
        const id = Number(document.getElementById('product-overview-temp-id').innerText)
        console.info(category, id)

        Swal.fire({
            title: 'Are you sure you want to add this to your Booking?',
            text: "",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'I Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'post',
                    url: '/admin/transactions/add_pos_test',
                    data: {
                        _token: '{{csrf_token()}}',
                        category: category, 
                        id: id
                        
                    }, 
                    //dataType: 'json',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: data + ' Added Succesfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        console.log('{{csrf_token()}}');
                        //location.reload();
                    }
                });
            }
        })
    }

    {{--function add(category, id) {--}}
    {{--    Swal.fire({--}}
    {{--      title: 'Are you sure you want to add this to your Booking?',--}}
    {{--      text: "",--}}
    {{--      icon: 'info',--}}
    {{--      showCancelButton: true,--}}
    {{--      confirmButtonColor: '#3085d6',--}}
    {{--      cancelButtonColor: '#d33',--}}
    {{--      confirmButtonText: 'I Confirm'--}}
    {{--    }).then((result) => {--}}
    {{--      if (result.isConfirmed) {--}}
    {{--        $.ajax({--}}
    {{--          type: 'post',--}}
    {{--          url: '/admin/transactions/add_pos_test',--}}
    {{--          data: {category: category, id: id, _token: '{{csrf_token()}}'},--}}
    {{--          dataType: 'json',--}}
    {{--          success: function(data){--}}
    {{--            Swal.fire({--}}
    {{--              icon: 'success',--}}
    {{--              title: data+' Added Succesfully!',--}}
    {{--              showConfirmButton: false,--}}
    {{--              timer: 1500--}}
    {{--            });--}}
    {{--            location.reload();--}}
    {{--          }--}}
    {{--        });--}}
    {{--      }--}}
    {{--    })--}}
    {{--}--}}

    function clearbooking() {
        Swal.fire({
            title: 'Are you sure you want to delete booking?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'I Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'All Booking Deleted Succesfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                window.location.href = "/admin/transactions/clearbooking";


            }
        })
    }

    function printReceipt() {
        Swal.fire({
            title: 'Are you sure that the information is correct?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'I Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Booking Succesfully',
                    showConfirmButton: false,
                    timer: 1500
                });
                window.location.href = "/admin/transactions/clearbooking";


            }
        })
    }
</script>

</body>
</html>
