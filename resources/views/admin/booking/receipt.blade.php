@extends('layouts.admin.app')
@section('container')
<div class="invoice-container p-0 border-0" style="box-shadow: 0 0 0 0;">
    <div class="control-bar" style="z-index: 9999 !important;">

        <div class="container">
            <div class="row">
                <div class="col-10">
                    <div class="slogan">Receipt {{ $data->reference }}</div>
                </div>


                <div class="col-2 text-right">
                    <a href="javascript:window.print()">Print</a>

                </div>
                <!--.col-->
            </div>
            <!--.row-->
        </div>
        <!--.container-->
    </div>
    <!--.control-bar-->
    <div class="invoic bg-transparent" id="invoice">
        <div class="text-center" style="text-align: center;">
            <img src="{{url('admin/assets/images/sbrlogo.png')}}" style="width: 30%;">
            <h4 class="mt-2 font-weight-bold">O F F I C I A L&nbsp;&nbsp;&nbsp;R E C E I P T</h4>
        </div>
        <div class="row sectio">

            <div class="col-6">

                <p class="client">
                    <strong>{{ $data->surname }}, {{ $data->firstname }} {{ $data->middlename }}</strong><br>
                    {{ strtoupper(strtolower($data->brgyDesc.', '.$data->citymunDesc.', '.$data->provDesc)) }}
                </p>
            </div>
            <!--.col-->

            <div class="col-6 text-left details">
                <p>
                    Date: {{ date('M. d, Y h:i:s A',strtotime($data->ReservedDate)) }}<br>
                    Order: {{ $data->reference }}<br>
                    Status: {{ $data->status }}
                </p>
            </div>
            <!--.col-->

        </div>
        <!--.row-->
        <hr>
        <h4 class="text-center">Itemized Order Breakdown</h4>
        <div class="invoicelist-bod table-responsive">
            <table class="table">
                <thead>
                    <th class="p-1">Product</th>
                    <th class="p-1">Booking Type</th>
                    <th class="p-1 text-right">Total</th>
                </thead>
                <tbody>
                    @php
                    $atr = json_decode($data->description);
                    @endphp
                    @if(count($atr->meals) > 0)
                    @foreach($atr->meals as $meals)
                    <tr class="line-item" style="background-color:transparent;">
                        <td class="p-1 border-0" id="product_info">{{ $meals->title }}</td>
                        <td class="p-1 border-0" id="item_type">Meals</td>
                        <td class="p-1 border-0 line-total money text-right">{{ number_format($meals->rate,2) }}</td>
                    </tr>
                    @endforeach
                    @endif

                    @if(count($atr->events) > 0)
                    @foreach($atr->events as $events)
                    <tr class="line-item" style="background-color:transparent;">
                        <td class="p-1 border-0" id="product_info">{{ $events->title }}</td>
                        <td class="p-1 border-0" id="item_type">Event</td>
                        <td class="p-1 border-0 line-total money text-right">{{ number_format($events->rate,2) }}</td>
                    </tr>
                    @endforeach
                    @endif

                    @if(count($atr->activities) > 0)
                    @foreach($atr->activities as $activities)
                    <tr class="line-item" style="background-color:transparent;">
                        <td class="p-1 border-0" id="product_info">{{ $activities->title }}</td>
                        <td class="p-1 border-0" id="item_type">Activities</td>
                        <td class="p-1 border-0 line-total money text-right">{{ number_format($activities->rate,2) }}</td>
                    </tr>
                    @endforeach
                    @endif

                    @if(count($atr->cottages) > 0)
                    @foreach($atr->cottages as $cottages)
                    <tr class="line-item p-1" style="background-color:transparent;">
                        <td class="p-1 border-0" id="product_info">{{ $cottages->title }}</td>
                        <td class="p-1 border-0" id="item_type">Cottages</td>
                        <td class="p-1 border-0 line-total money text-right">{{ number_format($cottages->rate,2) }}</td>
                    </tr>
                    @endforeach
                    @endif

                    <tr style="border-top: 5px double black;border-bottom: 0;">
                        <td class="p-1 border-0"></td>
                        <td class="p-1 text-right">Amount Render:</td>
                        <td class="p-1 full-subtotal money text-right font-weight-bold">{{ number_format($data->amount) }}</td>
                    </tr>
                    <tr style="background-color:transparent;">
                        <td class="p-1"></td>
                        <td class="p-1 text-right">Change:</td>
                        <td class="p-1 total-price money text-right font-weight-bold" id="total_owed"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--.invoice-body-->
        <!--.invoice-body-->

        <div class="note">
            <h2><strong>Thank you!</strong></h2>
            <small>
                <p>We appreciate your business! Please let us know if you have any questions/concerns about your bill call us at
                    (XXX) XXXX-XXXX ext 1</p>
            </small>
            </p>
        </div>

    </div>
</div>
</div>
</div>
@endsection
<style>
.invoice-container {
    box-sizing: border-box;
    margin: 6rem auto 0;
    max-width: 800px;
    border: 1px solid #aaa;
    padding: 2rem;
    box-shadow: 5px 10px #888888;
}

.invoice {
    background: white;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 1rem;
    padding-right: 1rem;
}

*,
*:before,
*:after {
    box-sizing: inherit;
}

[]:hover,
[]:focus,
input:hover,
input:focus {
    background: rgba(23, 162, 184, 0.1);
    outline: 2px solid #17a2b8;
}

.group:after,
.invoicelist-footer:after {
    content: "";
    display: table;
    clear: both;
}

a {
    color: #17a2b8;
    text-decoration: none;
}

p {
    margin: 0;
}

.control-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
    background: #17a2b8;
    color: white;
    line-height: 4rem;
    height: 4rem;
}

.control-bar .slogan {
    font-weight: bold;
    font-size: 1.2rem;
    display: inline-block;
    margin-right: 2rem;
}

.control-bar label {
    margin-right: 1rem;
}

.control-bar a {
    margin: 0;
    padding: 0.5em 1em;
    background: rgba(255, 255, 255, 0.8);
}

.control-bar a:hover {
    background: white;
}

.control-bar input {
    border: none;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 0;
    max-width: 30px;
    text-align: center;
}

.control-bar input:hover {
    background: rgba(255, 255, 255, 0.3);
}

header {
    margin: 1rem 0 0;
    padding: 0 0 2rem 0;
    border-bottom: 3pt solid #17a2b8;
}

header p {
    font-size: 0.9rem;
}

header a {
    color: #000;
}

.money::before {
    content: "P";
}

.info {
    width: 30%;
}

.section {
    margin: 3rem 0 0;
}

.smallme {
    display: inline-block;
    text-transform: uppercase;
    margin: 0 0 2rem 0;
    font-size: 0.9rem;
}

.client {
    margin: 0 0 3rem 0;
}

h1 {
    margin: 0;
    padding: 0;
    font-size: 2rem;
    color: #17a2b8;
}

.details input {
    display: inline;
    margin: 0 0 0 0.5rem;
    border: none;
    width: 50px;
    min-width: 0;
    background: transparent;
    text-align: left;
}

/**
 * INVOICELIST BODY
 */
.invoicelist-body {
    margin: 1rem;
}

.invoicelist-body table {
    width: 100%;
}

.invoicelist-body thead {
    text-align: left;
    border-bottom: 2pt solid #666;
}

.invoicelist-body td,
.invoicelist-body th {
    position: relative;
    padding: 1rem;
}

.invoicelist-body tr:nth-child(even) {
    background: #ccc;
}

.invoicelist-body tr:hover .removeRow {
    display: block;
    position: relative;
    z-index: 20;
    padding: 5px;
    text-align: center;
    text-decoration: none;
    float: left;
    border: none;
}

.invoicelist-body input {
    display: inline;
    margin: 0;
    border: none;
    width: 80%;
    min-width: 0;
    background: transparent;
    text-align: left;
}

.invoicelist-body .control {
    color: white;
    background: #17a2b8;
    text-transform: uppercase;
    cursor: pointer;
}

.invoicelist-body .control:hover {
    background: #1ab6cf;
}

.invoicelist-body .newRow {
    float: left;
    padding: 5px;
}

.invoicelist-body .removeRow {
    display: none;
    position: absolute;
    left: -1rem;
    font-size: 0.5rem;
    border-radius: 10px;
    padding: 0.5rem;
    background-size: 0 100%;
}

/**
 * INVOICE LIST FOOTER
 */
.invoicelist-footer {
    margin: 1rem;
}

.invoicelist-footer table {
    float: right;
    width: 40%;
}

.invoicelist-footer table td {
    padding: 0.5rem 4rem 0 1rem;
    text-align: right;
}

/**
 * NOTE
 */
.note {
    margin: 1rem;
}

.hidenote .note {
    display: none;
}

.note h2 {
    margin: 0;
    font-size: 1rem;
    font-weight: bold;
}

/************
 * FOOTER
 **/
.invoice footer {
    display: block;
    margin: 1rem 0;
    padding: 1rem 0 0;
}

.invoice footer p {
    font-size: 0.8rem;
}

/**
 * PRINT STYLE
 */
@media print {
    html {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    body,
    .invoice {
        width: 100%;
        border: none;
        background: #fff;
        margin: auto;
        padding: 0;
    }

    .control,
    .control-bar,
    .alert {
        display: none !important;
    }

    []:hover,
    []:focus {
        outline: none;
    }
}
</style>