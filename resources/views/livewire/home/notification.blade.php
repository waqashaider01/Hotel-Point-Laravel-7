<div>
    @php
    $text='';
    $count=0;

     if (sizeof($notificationBookings) > 0) {
      foreach ($this->notificationBookings as $reservation) {
          $roomid=$reservation['room_id'];
          $adults=$reservation['adults'];
          $kids=$reservation['kids'];
          $infants=$reservation['infants'];

          $maxadults=$reservation->room?->max_adults;
          $maxkids=$reservation->room?->max_kids;
          $maxinfants=$reservation->room?->max_infants;

          $typename=$reservation->room?->room_type?->name;

         if ($reservation['channex_status']==="cancelled") {
             if($roomid===NULL){
                 $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;'  ><div class='row '> <div class='col-md-12'>".
             "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
             "<span style='background:red; color:white; padding:2px 4px; ".
             " margin-left:5px;'>CL</span></div>".
             "<div class='col-md-2' style= ' font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
             "</div><div class='col-md-3 ' style='color:red;'>Unmapped Room</div>".
             "<div class='col-md-2' style='color:red;'>".
             $reservation['check_in'].
             "</div><div class='col-md-2 pl-0' style='text-align:right'><span style='color:red; text-decoration:line-through red;'>  ".
            showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' style= ''>".$reservation['booking_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->rate_type?->name.
             "</div><div class='col-md-2' style='color:red;'>".$reservation['check_out'].
             "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' style= ' color:red;'>".$reservation['channex_status']."&nbsp;&nbsp;".
             $reservation['cancellation_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
             "</div><div class='col-md-2'></div></div></div></div></div>";



             }else if ($adults>$maxadults || $kids>$maxkids || $infants>$maxinfants) {
                 $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
              "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
             "<span style='background:red; color:white; padding:2px 4px;".
             " margin-left:5px;'>CL</span></div>".
             "<div class='col-md-2' style= 'font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
             "</div><div class='col-md-3 '>".$typename." <i class='fa-solid fa-triangle-exclamation' style='color:red;' data-toggle='tooltip' data-placement='top' data-html='true' title='Over capacity room'></i></div>".
             "<div class='col-md-2' style='color:red;'>".
             $reservation['check_in'].
             "</div><div class='col-md-2 pl-0' style='text-align:right'><span style='color:red; text-decoration:line-through red;'> ".
             showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->rate_type?->name.
             "</div><div class='col-md-2' style='color:red;'>".$reservation['check_out'].
             "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' style= 'color:red;'>".$reservation['channex_status']."&nbsp;&nbsp;".
             $reservation['cancellation_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
             "</div><div class='col-md-2'></div></div></div></div></div>";
             }
             else{
             $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
              "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
             "<span style='background:red; color:white; padding:2px 4px;".
             " margin-left:5px;'>CL</span></div>".
             "<div class='col-md-2' style= 'font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
             "</div><div class='col-md-3 '>".$typename."</div>".
             "<div class='col-md-2' style='color:red;'>".
             $reservation['check_in'].
             "</div><div class='col-md-2 pl-0' style='text-align:right'><span style='color:red; text-decoration:line-through red;'> ".
             showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->rate_type?->name.
             "</div><div class='col-md-2' style='color:red;'>".$reservation['check_out'].
             "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
             "<div class='col-md-3' style= 'color:red;'>".$reservation['channex_status']."&nbsp;&nbsp;".
             $reservation['cancellation_date']."</div><div class='col-md-2'></div>".
             "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
             "</div><div class='col-md-2'></div></div></div></div></div>";

              }

         }
         elseif ($reservation['channex_status']==="modified") {
              if($roomid===NULL){
             $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
          "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
          "<span style='background:purple; color:white; padding:2px 4px; ".
             " margin-left:5px;'>MF</span></div>".
         "<div class='col-md-2' style= 'font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
         "</div><div class='col-md-3 ' style='color:red;'>Unmapped Room</div><div class='col-md-2'>".$reservation['check_in'].
         "</div><div class='col-md-2 pl-0' style='text-align:right'><span > ".
         showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
         "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' ></div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
         "</div><div class='col-md-2'></div></div></div></div></div>";



          }else if ($adults>$maxadults || $kids>$maxkids || $infants>$maxinfants) {
             $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
          "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
          "<span style='background:purple; color:white; padding:2px 4px;".
             " margin-left:5px;'>MF</span></div>".
         "<div class='col-md-2' style= 'font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
         "</div><div class='col-md-3 '>".$typename." <i class='fa-solid fa-triangle-exclamation' style='color:red;' data-toggle='tooltip' data-placement='top' data-html='true' title='Over capacity room'></i></div><div class='col-md-2'>".$reservation['check_in'].
         "</div><div class='col-md-2 pl-0' style='text-align:right'><span> ".
         showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
         "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' ></div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
         "</div><div class='col-md-2'></div></div></div></div></div>";
        }else{
         $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
          "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
          "<span style='background:purple; color:white; padding:2px 4px;".
             " margin-left:5px;'>MF</span></div>".
         "<div class='col-md-2' style= 'font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
         "</div><div class='col-md-3 '>".$typename."</div><div class='col-md-2'>".$reservation['check_in'].
         "</div><div class='col-md-2 pl-0' style='text-align:right'><span > ".
         showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
         "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' ></div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
         "</div><div class='col-md-2'></div></div></div></div></div>";

          }
         }
         else{
         if($roomid===NULL){
             $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
          "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
          "<span style='background:green; color:white; padding:2px 4px;".
             " margin-left:5px;'>New</span></div>".
         "<div class='col-md-2' style= ' font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
         "</div><div class='col-md-3 ' style='color:red;'>Unmapped Room</div><div class='col-md-2'>".$reservation['check_in'].
         "</div><div class='col-md-2 pl-0' style='text-align:right'><span > ".
         showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' >".$reservation['booking_date']."</div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
         "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' ></div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
         "</div><div class='col-md-2'></div></div></div></div></div>";



         }else if ($adults>$maxadults || $kids>$maxkids || $infants>$maxinfants) {
                $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
                  "<div class='row justify-content-around'><div class='col-md-3 '>".
                     "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
                     $reservation['booking_code']."</span>".
                  "<span style='background:green; color:white; padding:2px 4px; ".
                     " margin-left:5px;'>New</span></div>".
                 "<div class='col-md-2' style= ' font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
                 "</div><div class='col-md-3 '>".$typename." <i class='fa-solid fa-triangle-exclamation' style='color:red;' data-toggle='tooltip' data-placement='top' data-html='true' title='Over capacity room'></i></div><div class='col-md-2'>".$reservation['check_in'].
                 "</div><div class='col-md-2 pl-0' style='text-align:right'><span> ".
                 showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
                 "<div class='col-md-3' style= ''>".$reservation['booking_date']."</div><div class='col-md-2'></div>".
                 "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
                 "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
                 "<div class='col-md-3' style= ''></div><div class='col-md-2'></div>".
                 "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
                 "</div><div class='col-md-2'></div></div></div></div></div>";
         }else{
         $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
          "<div class='row justify-content-around'><div class='col-md-3 '>".
             "<span style= 'font-weight:bold; color:#151B54;' class='cursor-pointer' wire:click='updateNotification(". $reservation['id'] .")' data-ref='".$reservation['id']."'>".
             $reservation['booking_code']."</span>".
          "<span style='background:green; color:white; padding:2px 4px; ".
             " margin-left:5px;'>New</span></div>".
         "<div class='col-md-2' style= ' font-weight:bold; font-size:10px;'>".$reservation->booking_agency?->name.
         "</div><div class='col-md-3 '>".$typename."</div><div class='col-md-2'>".$reservation['check_in'].
         "</div><div class='col-md-2 pl-0' style='text-align:right'><span> ".
         showPriceWithCurrency($reservation['reservation_amount'])."</span></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' style= ''>".$reservation['booking_date']."</div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->rate_type?->name."</div><div class='col-md-2'>".$reservation['check_out'].
         "</div><div class='col-md-2'></div></div><div class='row justify-content-around'>".
         "<div class='col-md-3' style= ''></div><div class='col-md-2'></div>".
         "<div class='col-md-3 '>".$reservation->guest?->full_name."</div><div class='col-md-2'>".
         "</div><div class='col-md-2'></div></div></div></div></div>";

          }
      }

 }

    }else{
    $text.="<div class='col px-2 py-4 rounded-xl mb-3' style='border:1px solid #f58787;' ><div class='row '> <div class='col-md-12'>".
       "<div class='row justify-content-around'><div class='col-md-12 '><center>No new reservations</center></div></div></div></div></div>";
    }

 @endphp
    <div class="card-header check-in-gradient1 border-0" style="border-radius: 0;padding: 0 !important;border: none !important;border-bottom: 1px solid var(--secondary) !important;">
        <p style="margin: 0;padding: 8px;padding-inline: 15px;width: fit-content;background-color: white;border-top-left-radius: 10px;border-top-right-radius: 10px;color: #4da5ff !important;" class="card-title">Last Channel Bookings
          <span class="badge badge-offer" style="background-color: #7e8299;color: white;margin-left: 10px;">{{ $notification_count }}</span></p>
    </div>
    <div class="card-body notification-card-body-div position-relative custom-bar mt-3 pt-0 pr-2 pl-2 pb-2" style="overflow-y: scroll;overflow-x: hidden;max-height: 410px;min-height: 410px;">
       <div style="font-size: 9px">
        {!! $text !!}
       </div>

    </div>
 </div>
