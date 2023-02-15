@extends('layouts.app')
@section('container')
    <!-- ========== MAIN SECTION ========== -->
    <main id="contact_page_style_2">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <form id="contact-form-page">
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{empty($userQuery) ? '' : $userQuery->name}}" placeholder="Your Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="control-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{empty($userQuery) ? '' : $userQuery->contact}}" placeholder="Phone">
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{empty($userQuery) ? '' : $userQuery->email}}" placeholder="Your Email">
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="date">Date</label>
                                <div class="form_date">
                                    <input type="text" class="form-control md_noborder_right" style="width:100%"
                                                name="dates" autocomplete=off placeholder="Reservation Date" required>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Payment Method</label>
                                <select class="form-control" id="payment_option" name="payment" required>
                                    <option>Payment Option</option>
                                    <option value='otc'>Over the Counter</option>
                                    <option value='gcash'>Online Payment</option>
                                    <!-- <option value="ob">Online Banking</option> -->
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Message</label>
                                <textarea class="form-control" name="message" placeholder="Your Message..."></textarea>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" class="button  btn_blue mt35 upper pull-right"> <i
                                        class="fa fa-calendar" aria-hidden="true"></i> Make a Reservation </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <div class="sidebar">
                        <aside class="widget">
                            <table class="table">
                                <tbody><tr>
                                    <td class="text-left">All(Rooms)</td>
                                    <td class="text-right">₱40,000.00</td>
                                </tr>

                                <tr>
                                    <td class="text-left">All (Cottages)</td>
                                    <td class="text-right"><span id="cottages"></span></td>
                                </tr>

                                <tr>
                                    <td class="text-left">All (Foods)</td>
                                    <td class="text-right"><span id="meals"> </span></td>
                                </tr>

                                
                                <tr>
                                    <td class="text-left">All (Activities)</td>
                                    <td class="text-right"><span id="activities"> </span></td>
                                </tr>

                                <tr>
                                    <td class="text-left">All (Events)</td>
                                    <td class="text-right"><span id="events"> </span></td>
                                </tr>


                                <tr>
                                    <td class="text-left">Days</td>
                                    <td class="text-right"><span id="days">1</span></td>
                                </tr>

                                <tr>
                                    <td class="text-left">Total</td>

                                    <td class="text-right">₱<span id="total">40,000.00 </span></td>
                                </tr>
                            </tbody></table>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @extends('layouts.app')
@section('container')