@extends('layouts.app')
<?php
use App\Http\Controllers\CheckAvailability;
?>
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
   <main id="rooms_list">
    <div class="container">
      @if(!empty($query) && $query->count())
         @foreach($query as $data) 
            <article  class="room_list">
               <div class="row">
                  <div class="col-lg-4 col-md-5 col-sm-12">
                     <figure>
                           <div class="item">
                              <a href="javascript:void(0)" class=""><img src="{{asset('assets/images/rooms/'.$data->image)}}" alt="Image" style="height:230px"></a>
                           </div>
                     </figure>
                  </div>
                  <div class="col-lg-8 col-md-7 col-sm-12">
                     <div class="room_details">
                        <div class="col-md-9 col-sm-9 col-xs-12 room_desc">
                           <h3><a href="javascript:void(0)"> {{$data->category_name}} - {{$data->title}} </a></h3>
                           <p>
                              <span style="font-size:15px"><strong>Adults:</strong> {{$data->adults}} | <strong>Childrens:</strong> {{$data->childrens}} | <strong>Featured:</strong> {{$data->is_featured == 0 ? 'No' : 'Yes'}}</span><br>
                              Status:
                              
                              <span><?= CheckAvailability::check($data->TabID)['Status'] ?></span> 
                              @if(CheckAvailability::check($data->TabID)['Booked'] !== '.')| 
                              <span>Room Available: <?= date('M. d, Y', strtotime('+1 day',strtotime(CheckAvailability::check($data->TabID)['Booked']))) ?></span>
                              @endif
                              
                           </p>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 room_price">
                           <div class="room_price_inner">
                              <span class="room_price_number">???{{number_format($data->rate,2)}}</span>
                              <small class="upper"> per night </small>
                              
                              @if(CheckAvailability::check($data->TabID)['isAvail'] !== 1)
                              <a href="{{url('rooms')}}/{{Crypt::encryptString($data->id)}}/details" class="button btn_blue btn_full upper">Book Now</a>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </article>
         @endforeach
      @else
         <div class="alert alert-danger">No Result Found</div>
      @endif
      
      {{ $query->links('pagination') }}
     
       
        
    </div>
 </main>

@endsection