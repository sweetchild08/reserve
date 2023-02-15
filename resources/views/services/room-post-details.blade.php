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
<main id="room_page">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="slider">
                    <div id="slider-larg" class="owl-carousel image-gallery">
                        @foreach($gallery as $data)
                            <a href="{{asset('assets/images/rooms/'.$data->gallery)}}">
                                <img class="img-responsive" style="height:500px" src="{{asset('assets/images/rooms/'.$data->gallery)}}" alt="Image">
                            </a>
                        @endforeach
                    </div>
                    <div id="thumbs" class="owl-carousel">
                        @foreach($gallery as $data)
                        <div class="item"><img class="img-responsive" style="height:80px;" src="{{asset('assets/images/rooms/'.$data->gallery)}}" alt="Image"></div>
                        @endforeach
                    </div>
                </div>
                <div class="main_title mt50">
                    <h2 class="text-uppercase">What about this room?</h2>
                </div>
                <p class="text-justify">{{$query->description}}</p>
                
                <div class="main_title t_style a_left s_title mt50">
                    <div class="c_inner">
                        <h2 class="c_title">ROOM SERVICES</h2>
                    </div>
                </div>
                <div class="room_facilitys_list">
                    <div class="all_facility_list">
                        @foreach($services as $service)
                        @php
                        $data = explode(',',$service->services);
                        @endphp
                        @foreach($data as $d)
                        <div class="col-sm-4 nopadding">
                            <ul class="list-unstyled">
                                <li><i class="fa fa-check"></i>{{$d}}</li>
                            </ul>
                        </div>
                        @endforeach
                        @endforeach
                    </div>
                </div>

                <form action="{{url('services/reservation/addons_set_a')}}" method="POST">
                    @csrf
                    <div class="similar_rooms">
                        <div class="main_title t_style5 l_blue s_title a_left">
                            <div class="c_inner">
                                <h2 class="c_title">ADD-ONS (COTTAGE)</h2>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($addons_cottages as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_cottages[]" type="checkbox"
                                        value="{{$data->id}}" id="cottages{{$data->id}}">
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
                    </div>

                    <div class="similar_rooms">
                        <div class="main_title t_style5 l_blue s_title a_left">
                            <div class="c_inner">
                                <h2 class="c_title">ADD-ONS (FOODS)</h2>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($addons_foods as $data)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="addons_foods[]" type="checkbox"
                                        value="{{$data->id}}" id="foods{{$data->id}}">
                                    <label class="form-check-label" for="foods{{$data->id}}">
                                        {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="similar_rooms">
                        <div class="main_title t_style5 l_blue s_title a_left">
                            <div class="c_inner">
                                <h2 class="c_title">ADD-ONS (ACTIVITIES)</h2>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($addons_activities as $data)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="addons_activities[]" type="checkbox" value="{{$data->id}}" id="activities{{$data->id}}">
                                        <label class="form-check-label" for="activities{{$data->id}}">
                                            {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="similar_rooms">
                        <div class="main_title t_style5 l_blue s_title a_left">
                            <div class="c_inner">
                                <h2 class="c_title">ADD-ONS (EVENTS)</h2>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($addons_events as $data)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" name="addons_events[]" type="checkbox" value="{{$data->id}}" id="events{{$data->id}}">
                                        <label class="form-check-label" for="events{{$data->id}}">
                                            {{$data->title.' - ₱'.number_format($data->rate,2)}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button class="button btn_lg btn_blue btn_full"
                        onclick="return confirm('Are you sure want to add this addons?');" type="submit">UPDATE
                        ADD-ONS</button>
                </form>

                <div class="similar_rooms">
                    <div class="main_title t_style5 l_blue s_title a_left">
                        <div class="c_inner">
                            <h2 class="c_title">SIMILAR ROOMS</h2>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($related as $data)
                        <div class="col-md-4">
                            <article>
                                <figure>
                                    <a href="{{url('rooms')}}/{{Crypt::encryptString($data->id)}}/details"
                                        class="hover_effect h_blue h_link"><img
                                            src="{{asset('assets/images/rooms/'.$data->image)}}" alt="Image"
                                            class="img-responsive"></a>
                                    <figcaption>
                                        <h4 class="text-center"><a
                                                href="{{url('rooms')}}/{{Crypt::encryptString($data->id)}}/details">{{$data->title}}</a>
                                        </h4>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="comments">
                    <div class="main_title t_style3">
                        <h2>COMMENTS ({{$comments->count()}})</h2>
                    </div>
                    <ol class="comments_list clearfix">
                        @foreach($comments as $comment)
                        <li class="comment single_comment">
                            <!-- Comment -->
                            <div class="comment-container comment-box">
                                <a href="javascript:void(0)" class="avatar">
                                    <img width="80" height="80" src="{{asset('assets/images/users/user1.jpg')}}" alt="Image">
                                </a>
                                <div class="comment_content">
                                    <h4 class="author_name"><a href="javascript:void(0)">{{$comment->name}}</a></h4>
                                    <span class="comment_info">
                                      <i class="fa fa-calendar"></i>
                                      <a href="javascript:void(0)">
                                         <time datetime="2017-10-01T19:56:36+00:00">{{date('F j, Y g:i A',strtotime($comment->created_at))}}</time>
                                      </a>
                                    </span>
                                    <div class="comment_said_text">
                                        <p>asdasd</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ol>

                    @if(Session::has('customer_id'))
                        @if($query->is_comments == 0)
                        <div class="main_title mt40">
                            <h2>LEAVE YOUR COMMENT</h2>
                        </div>
                        <div class="row">
                            <form method="POST" action="{{url('services/comments')}}" data-parsley-validate>
                                @csrf
                                <input type="hidden" name="booking_id" value="{{$id}}">
                                <input type="hidden" name="category" value="Rooms">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="comments" style="resize:none;height:100px" placeholder="Write Your Comment" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                <br>
                                <button class="button btn_blue pull-right"><i class="fa fa-paper-plane-o"></i> POST YOUR COMMENT </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @else
                            <div class="alert alert-info">Comments are disabled.</div>
                        @endif
                    @else
                        <div class="alert alert-info"><a href="{{url('login')}}">Login</a> to comment</div>
                    @endif
                    
                </div>

            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <aside class="widget">
                        <table class="table">
                            <tr>
                                <td class="text-left">Rate / Day (Room)</td>
                                <td class="text-right">₱{{number_format($query->rate,2)}}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Cottage)</td>
                                <td class="text-right">₱<span id="cottage">@if(Session::has('total_cottage_rate')){{number_format(Session::get('total_cottage_rate'),2)}} @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Foods)</td>
                                <td class="text-right">₱<span id="meals">@if(Session::has('total_foods_rate')){{number_format(Session::get('total_foods_rate'),2)}} @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            
                            <tr>
                                <td class="text-left">Add-Ons (Activities)</td>
                                <td class="text-right">₱<span id="activities">@if(Session::has('total_activities_rate')){{number_format(Session::get('total_activities_rate'),2)}} @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Add-Ons (Events)</td>
                                <td class="text-right">₱<span id="events">@if(Session::has('total_events_rate')){{number_format(Session::get('total_events_rate'),2)}} @else{{number_format(0,2)}} @endif</span></td>
                            </tr>

                            <tr>
                                <td class="text-left">Total</td>
                                <td class="text-right">₱<span id="total">@if(Session::has('total_rates')){{number_format(Session::get('total_rates') + $query->rate,2)}} @else{{number_format($query->rate,2)}} @endif</span></td>
                            </tr>
                        </table>
                    </aside>

                    <aside class="widget">
                        <div class="vbf">
                            <h2 class="form_title"><i class="fa fa-calendar"></i> BOOK ONLINE</h2>
                            <form method="POST" action="{{url('services/reservation')}}" class="inner">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{$id}}">
                                <input type="hidden" name="days_counter" id="days_counter">
                                <input type="hidden" name="total_rates" id="total_rates" value="@if(Session::has('total_rates')){{(Session::get('total_rates') + $query->rate)}} @else{{($query->rate)}} @endif">
                                <input type="hidden" name="category" value="Rooms">
                                <div class="form-group">
                                    <input class="form-control" name="name" placeholder="Enter Your Name" value="{{empty($userQuery) ? '' : $userQuery->name}}" type="text" readonly>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="email" placeholder="Enter Your Email Address" value="{{empty($userQuery) ? '' : $userQuery->email}}" type="email" readonly>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" name="contact" placeholder="Enter Your Phone Number" value="{{empty($userQuery) ? '' : $userQuery->contact}}" type="text" readonly>
                                </div>
                                
                                <div class="form-group col-md-6 col-sm-6 col-xs-12 nopadding">
                                    <div class="form_select">
                                        <div class="form-group">
                                            <input type="hidden" name="adults" value="{{$query->adults}}">
                                            <input class="form-control" name="booking-name" value="{{$query->adults}} Adults" disabled type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12 nopadding">
                                    <div class="form_select">
                                        <input type="hidden" name="childrens" value="{{$query->childrens}}">
                                        <input class="form-control" value="{{$query->childrens}} Childrens" disabled type="text">
                                    </div>
                                </div>
                                <div class="form-group col-12 nopadding">
                                    <div class="input-group">
                                        <div class="form_date">
                                            <input type="text" class="form-control md_noborder_right" style="width:100%" name="dates"
										autocomplete=off placeholder="Reservation Date" value="{{$date}}" readonly required>
                                        </div>
                                    </div>
                                </div>
                                @if(Session::has('customer_id'))
                                    <!-- <button class="button btn_lg btn_blue btn_full" onclick="return confirm('Are you sure want to complete this reservation?');" type="submit">BOOK A ROOM NOW</button> -->
                                    <button class="button btn_lg btn_blue btn_full" onclick="submit_reservation();" type="submit">BOOK A ROOM NOW</button>
                                @else 
                                    <a href="{{url('/login1')}}" class="button btn_lg btn_blue btn_full" type="submit">LOGIN</a>
                                @endif
                            </form>
                        </div>
                    </aside>
                    <aside class="widget">
                        <h4>NEED HELP?</h4>
                        <div class="help">
                            If you have any question please don't hesitate to contact us
                            <div class="phone"><i class="fa  fa-phone"></i><a href="tel:+63 928 7066 065"> +63 928 7066 065
                                </a></div>
                            <div class="phone"><i class="fa  fa-phone"></i><a href="tel:+63 916 4070 935"> +63 916 4070 935
                                </a></div>
                            <div class="email"><i class="fa  fa-envelope-o "></i><a
                                    href="mailto:santorenzbayresort2022@gmail.com">santorenzbayresort2022@gmail.com</a></div>
                        </div>
                    </aside>
                    
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('custom')
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
    

    function numberWithCommas(x) {
        x = x.toString();
        var pattern = /(-?\d+)(\d{3})/;
        while (pattern.test(x))
            x = x.replace(pattern, "$1,$2");
        return x;
    }

    function submit_reservation() {
        var status = confirm();
    }

</script>
@endsection
