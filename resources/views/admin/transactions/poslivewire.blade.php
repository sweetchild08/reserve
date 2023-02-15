<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>
    <link href="{{asset('assets/css/point-of-sale.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fontawesome/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.33/dist/sweetalert2.all.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link href="{{url('admin/assets/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="{{url('admin/assets/css/pos.css')}}" rel="stylesheet" type="text/css"> -->
    <link href="{{url('assets/parsley/parsley.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

@livewire('p-o-s')

                        
</body>
<style type="text/css">
@import url(https://fonts.googleapis.com/css?family=Open+Sans);

html {
    height: 100%;
}

    {
    height: 100%;
    background: #f5f7fa;
    font-family: "Open Sans", Helvetica, sans-serif;
}

a,
a:hover {
    text-decoration: none;
}

input:focus {
    outline: none;
}

    {
    display: flex;
    flex-direction: column;
    height: 100%;
}

nav {
    display: flex;
    justify-content: space-between;
    background: #34495e;
    padding: 9px 0;
}

nav ul {
    display: flex;
    align-items: center;
    margin: 0;
}

nav ul li {
    list-style-type: none;
}

nav ul li a {
    color: #fff;
    padding: 20px;
}

nav ul li a:hover {
    background: #22303d;
}

nav .search input {
    width: 394px;
    height: 40px;
    margin-right: 30px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    text-align: center;
}

nav .search input::-moz-placeholder {
    font-style: italic;
}

nav .search input:-ms-input-placeholder {
    font-style: italic;
}

nav .search input::placeholder {
    font-style: italic;
}

.sellables-container {
    display: flex;
    flex: 1;
}

.sellables-container .sellables {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.sellables-container .sellables .categories {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    margin: 0.5em;
}

.sellables-container .sellables .categories .category {
    padding: 17.5px;
    margin: 2px;
    border: 1px solid #c8cfd8;
    border-radius: 5px;
    background: #e6e9ed;
    color: #424A54;
}

.sellables-container .sellables .categories .category:hover {
    background: #c8cfd8;
}

.sellables-container .sellables .categories .active {
    background: #bac2cd;
    color: #424A54;
}

.sellables-container .sellables .categories .active:hover {
    background: #abb5c2;
}

.sellables-container .sellables .item-group-wrapper {
    overflow-y: scroll;
}

.sellables-container .sellables .item-group-wrapper .item-group {
    display: flex;
    flex-wrap: wrap;
}

.sellables-container .sellables .item-group-wrapper .item-group .item {
    padding: 50px 35px;
    margin: 0.5em 0.5em;
    border-radius: 5px;
    background: #9b59b6;
    color: #fff;
}

.sellables-container .sellables .item-group-wrapper .item-group .item:hover {
    background: #804399;
}

.sellables-container .register-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.sellables-container .register-wrapper .customer input {
    height: 40px;
    width: 394px;
    margin-top: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
}

.sellables-container .register-wrapper .customer input::-moz-placeholder {
    font-style: italic;
}

.sellables-container .register-wrapper .customer input:-ms-input-placeholder {
    font-style: italic;
}

.sellables-container .register-wrapper .customer input::placeholder {
    font-style: italic;
}

.sellables-container .register-wrapper .register {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
    width: 400px;
    margin: 1em 2em;
    box-shadow: 0px 1px 7px 0px rgba(0, 0, 0, 0.25);
    border-radius: 5px;
    background: #fff;
}

.sellables-container .register-wrapper .register .products {
    display: flex;
    flex-direction: column;
}

.sellables-container .register-wrapper .register .products .product-bar {
    display: flex;
    justify-content: space-between;
    padding: 1em;
    background: #fff;
}

.sellables-container .register-wrapper .register .products .product-bar:first-child {
    margin-top: 1em;
}

.sellables-container .register-wrapper .register .products .product-bar:hover {
    background: #e6e6e6;
}

.sellables-container .register-wrapper .register .products .selected {
    background: #68b3c8;
    color: #fff;
}

.sellables-container .register-wrapper .register .products .selected:hover {
    background: #44a0b9;
}

.sellables-container .register-wrapper .register .pay-button {
    display: flex;
    align-items: center;
    justify-content: center;
}

.sellables-container .register-wrapper .register .pay-button a {
    padding: 10px 125px;
    margin: 1em 0;
    border-radius: 5px;
    background: #42a07f;
    color: #fff;
}

.sellables-container .register-wrapper .register .pay-button a:hover {
    background: #3b8e71;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="{{asset('fontawesome/bootstrap.bundle.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@livewireScripts
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-livewire-alert::scripts />
<x-livewire-alert::flash />
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
}).on('apply.daterangepicker', function(ev, picker) {
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

function add(category, id, type, title, image) {
    Swal.fire({
        title: "Are you sure you want to add '" + title + "' to your Booking?",
        // text: title,
        // icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'I Confirm',
        imageUrl: "{{ asset('assets/images/') }}" + "/" + type + "/" + image,
        imageHeight: 300,
        imageAlt: 'A tall image',
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
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: ' Added Succesfully!',
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
                success: function(data) {
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