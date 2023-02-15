<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Agreement</title>
    
    <link rel="stylesheet" href="{{asset('terms-condition/style.css')}}">
</head>

<body>
    <!-- <link rel="stylesheet" href="http://themainlabel.com/assets/css/style.css"> -->

    <main class="header-offset content-wrapper about-wrapper">
        <div class="terms-container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <section class="terms-title">
                        <h1>Terms &amp; Conditions</h1>
                        <hr>
                    </section>

                    <div class="terms-body">
                        <h4><strong>Welcome to the Santorenz Bay Resort and Hotel Reservation Website. Please review the following basic terms that govern your
                                use
                                of, and booking of, rooms, cottages, foods, activities, and events from our site. Please note that your use of our site
                                constitutes your agreement to follow and be bound by those terms.</strong></h4>
                        <hr>
                        <h3>General</h3>
                        <p>
                            By using our website, you agree to the Terms of Use. We may change or update these terms so
                            please check this page regularly. We do not represent or warrant that the information on our
                            web
                            site is accurate, complete, or current. This includes pricing and availability information.
                            We
                            reserve the right to correct any errors or omissions, and to change or update information at
                            any
                            time without giving prior notice.
                        </p>
                        <hr>
                        <h3>Correction of Errors and Inaccuracies</h3>
                        <p>The information on the site may contain typographical errors or inaccuracies and may not be
                            complete or current. The Main Label therefore reserves the right to correct any errors,
                            inaccuracies or omissions and to change or update information at any time with or without
                            prior
                            notice (including after you have submitted your order). Please note that such errors,
                            inaccuracies or omissions may relate to product description, pricing, product availability,
                            or
                            otherwise.
                        </p>
                        <hr>
                        
                        
                        <h3>Cancellations </h3>
                        <p>
                            If you decide that you no longer want your reservation for any reason you may cancel it as long as
                            the
                            reservation is not approved. However, once the reservation is approved, we are unable to cancel the reservation
                            as the appointment has already been already process.
                        </p>
                        <hr>
                        
                        <h3>Availability</h3>
                        <p>All of our Rooms, Cottages, Foods is available during your whole booking of the resort. But ensure cleanliness of the whole resort. </p>
                        <hr>
                        <h3>Damages</h3>
                        <p>
                            For all damages within the inside of the resort must be paid by the one who reserved to us during their stay, 
                            .
                            

                            <div class="button-terms">
                                <input type="checkbox" name="check" id="check">
                                <label for="check">I agree to the Terms and Conditions</label> 
                                <br/>
                                <button class="btn btn-submit" id="t-proceed">Proceed</button>
                            </div>

                            <!-- FOOTER -->
                        <div class="container terms_footer">
                            <h3>Can't find what you're looking for? <a href="{{url('/contact-us')}}">Email us</a></h3>
                        </div>

                    </div>
                </div>
            </div>

            
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container -->
    </main>

    <script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>

</body>

</html>

<script>
    $('#t-proceed').on('click', function(){
        var chck = $('#check').prop('checked');
        if(chck){
            window.location.href= '/santorenz-reservation/inquiries';

        }else{
            alert('not checked');
        }

    });
</script>