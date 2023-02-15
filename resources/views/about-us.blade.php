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
        <div class="row">
            <div class="col-md-7">
                <h1 class="mb30">Santorenz Bay Resort - Since 2019</h1>
                <p><b>Welcome to Santorenz Bay Resort and Hotel</b><br>
                Mabuhay! The “true heart of the Philippines,” where Filipino hospitality means a haven of safety and well-being, is happy to welcome you.

                The world has changed and we’ve all had to adapt. For us, here is what it means to live through these challenging times and into the New Normal.</p>
                <p>SANTORENZ BAY RESORT is one of the newest resorts located in Brgy. Parang, Calapan City, Oriental Mindoro. With its classic modern Filipino inspired architecture contrasted by the clear sea waters, Santorenz Bay Resort offers an alternative summer destination to soothe and relax your tired mind and body. Our guests enjoy high-speed wireless Internet access, comfortable beds for a relaxing and restful stay, and a variety of hotel options to suit any trip, from a family vacation or weekend getaway to a full-scale conference or wedding. We are committed to creating caring experiences for every person, every time and strive to make our guests feel truly refreshed and restored during their visit. We hope you enjoy our services as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us. </p>
            </div>
            <div class="col-md-5">
                <div class="about_img">
                    <img src="{{asset('assets/images/gallery/IMG_3764.jpg')}}" class="img1 img-responsive" alt="Image">
                    <img src="{{asset('assets/images/gallery/IMG_3764.jpg')}}" class="img2 img-responsive" alt="Image">
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="countup_box">
                            <div class="inner">
                                <div class="countup number" data-count="16"></div>
                                <div class="text">Rooms</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="countup_box">
                            <div class="inner">
                                <div class="countup number" data-count="8"></div>
                                <div class="text">Staffs</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="countup_box">
                            <div class="inner">
                                <div class="countup number" data-count="7"></div>
                                <div class="text">Cottages</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="countup_box">
                            <div class="inner">
                                <div class="countup number" data-count="4"></div>
                                <div class="text">Activities</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row image-gallery">
            <div class="col-md-3 col-sm-6 mt20 mb20 br2">
                <a href="{{asset('assets/images/restaurant.jpg')}}" class="hover_effect h_lightbox h_blue">
                    <img src="{{asset('assets/images/rooms/1room.jpg')}}" class="img-responsive full_width br2" alt="Image">
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mt20 mb20 br2">
                <a href="{{asset('assets/images/spa.jpg')}}" class="hover_effect h_lightbox h_blue">
                    <img src="{{asset('assets/images/gallery/outcomes-hotel-desk-clerk-300x250.jpg')}}" class="img-responsive full_width br2" alt="Image">
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mt20 mb20 br2">
                <a href="{{asset('assets/images/conference.jpg')}}" class="hover_effect h_lightbox h_blue">
                    <img src="{{asset('assets/images/gallery/9.jpg')}}" class="img-responsive full_width br2" alt="Image">
                </a>
            </div>
            <div class="col-md-3 col-sm-6 mt20 mb20 br2">
                <a href="{{asset('assets/images/swimming.jpg')}}" class="hover_effect h_lightbox h_blue">
                    <img src="{{asset('assets/images/activities/kayaking-and-boating.jpg')}}" class="img-responsive full_width br2" alt="Image">
                </a>
            </div>
        </div>
        <p> </p>
    </div>
    </div>
</main>

@endsection