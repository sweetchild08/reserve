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
<main id="contact_page_style_2">
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <form id="contact-form-page">
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Your Name">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label class="control-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Your Email">
                        </div>
                        <div class="form-group col-md-6 col-sm-6">
                            <label class="control-label">Subject</label>
                            <input type="text" class="form-control" name="subject" placeholder="Subject">
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Message</label>
                            <textarea class="form-control" name="message" placeholder="Your Message..."></textarea>
                        </div>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="button  btn_blue mt35 upper pull-right"> <i
                                    class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Your Message </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div id="contact-page22">
                    <ul class="contact-info upper mt40">
                        <li>
                            <span class="ci_item">ADDRESS:</span>
                            Parang, Calapan City, Oriental Mindoro
                        </li>
                        <li>
                            <span class="ci_item">EMAIL:</span>
                            santorenzbayresort2022@gmail.com
                        </li>
                        <li>
                            <span class="ci_item">WEB:</span>
                            santorenzbayresort.com
                        </li>
                        <li>
                            <span class="ci_item">PHONE:</span>
                            +63 928 7066 065</strong> , +63 916 4070 935</strong>
                        </li>
                    </ul>

                    <div class="social_media">
                        <a class="https://www.facebook.com/Santorenz-Bay-Resort-826458264364965" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                        <a class="googleplus" href="#"><i class="fa fa-google-plus"></i></a>
                        <a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a>
                        <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                        <a class="youtube" href="#"><i class="fa fa-youtube"></i></a>
                        <a class="instagram" href="#"><i class="fa fa-instagram"></i></a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

@endsection
