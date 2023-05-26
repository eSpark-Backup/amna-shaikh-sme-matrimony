<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{env('APP_NAME')}}</title>
    <style>
      .body-cont p {
        max-width: 365px;
        margin: 0 auto;
        font-size: 14px;
        font-weight: 500;
      }
      .body-cont h5 {
        font-size: 18px;
        margin-bottom: 5px;
      }
      .body-cont a {
        /*color: #dd2283 !important;*/
        text-decoration: none;
      }
      .body-cont {
      }
      .body-cont + div h5 {
        font-size: 14px;
        margin-bottom: 0;
        margin-top: 20px;
      }
    </style>
  </head>

  <body style="padding: 0; margin: 0px; background: #eee">
      <div style="text-align: center; background: #fff; max-width: 600px; margin: 0 auto; padding-bottom: 20px">
        <div style="width: 100%; padding: 15px 0px 0px 0px; text-align: center; margin-bottom: 15px; background-size: cover;">
          <img src="https://crzglobal.xyz/assets/images/email-logo-center.png" style="width: 77px;" />
        </div>
        <div style="max-width: 600px;margin: auto; padding: 20px 0; background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675); opacity: 0.95; font-size: 17px; position: relative;">

          <span style="background: #fff ; height: 45px ; width: 45px ; border-radius: 50% ; overflow: hidden;  display: block;margin: 0px auto;padding: 0;">
            <img src="https://crzglobal.xyz/assets/images/email-filled-center.png" style="width: 30px; padding: 7px 0;">
          </span>
          <!-- <span style="display: block;font-size: 14px;padding-top:10px;color: #fff;font-weight: 500;"></span> -->
          <h4 style="margin: 10px 0; color: #fff; font-size: 14px;">{{$heading}}</h4>
        </div>
        
        <div style="padding:0" class="body-cont">
          {!! $content !!}
          <table cellpadding="0" cellspacing="0" border="0" style="width:100%!important">
            <tbody>
              <tr>
                <td colspan="2" align="left" valign="middle" width="100%" style="color: #000; border-collapse:collapse;padding:0 30px;font-family:sans-serif;font-size:18px;line-height:30px" > Ticket#: {{ $audience->id }}</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle" width="100%" style="color: #000; border-collapse:collapse;padding:0 30px 40px 30px;font-family:sans-serif;line-height:22px" id="c_date">Member Id - {{ $audience->member_id }}</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle" width="100%" style="color: #000; border-collapse:collapse;padding:0 30px;font-family:sans-serif;font-size:18px;line-height:30px" > Billing summary</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle" width="100%" style="color: #000; border-collapse:collapse;padding:0 30px 40px 30px;font-family:sans-serif;line-height:22px" id="c_date">Event Date - {{ Carbon\Carbon::createFromTimeStamp(strtotime($audience->get_event->event_date), "UTC")->tz(session('timezone'))->format('d M, Y') }}</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle" width="100%" style="color: #000;border-collapse:collapse;padding:0 30px 30px 30px;font-family:sans-serif;line-height:24px">This is a summary of your charges for the event. <a href="{{ url('/events/'.$audience->event_id)}}" style="text-decoration:none" target="_blank">{{ $audience->get_event ? '('.$audience->get_event->title.')' : ''}}</a>
                </td>
              </tr>
              <tr>
                <td colspan="2" width="100%" style="border-collapse:collapse;color: #000;font-family:sans-serif;line-height:24px;padding:0 30px">
                  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%!important;border-collapse:collapse;margin:0;padding:0">
                    <tbody>
                      @if( $audience->total_price == ($audience->total_guests*$audience->guest_charges) && $audience->total_guests > 0)
                        @php
                            $guests = json_decode($audience->guests);
                          @endphp
                          @foreach($guests as $K => $V)
                            <tr>
                              <td align="left" valign="top" style="color: #000;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 10px 10px 0;"> {{ ucfirst($V->name)}} </td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->relation}} </td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->gender }} </td>
                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->age }} Years</td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > ${{ $audience->guest_charges }} </td>
                            </tr>
                          @endforeach()
                      @else
                        <tr>
                          <td colspan="4" align="left" valign="top" style="color: #000;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 10px 10px 0;"> {{ $audience->get_member->first_name.' '.$audience->get_member->last_name; }} </td>
                          <td align="right" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > ${{ $audience->event_charges }} </td>
                        </tr>
                        @if(!empty($audience->guests) && $audience->total_guests > 0)
                          @php
                            $guests = json_decode($audience->guests);
                          @endphp
                          @foreach($guests as $K => $V)

                            <tr>
                              <td align="left" valign="top" style="color: #000;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 10px 10px 0;"> {{ ucfirst($V->name)}} </td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->relation}} </td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->gender }} </td>
                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > {{ $V->age }} Years </td>

                              <td align="left" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:10px 0;" > ${{ $audience->guest_charges }} </td>
                            </tr>
                          @endforeach()
                        @endif
                      @endif
                      
                    </tbody>
                  </table>
                </td>
              </tr>

              <tr>
                <td colspan="2" width="100%" style="border-collapse:collapse;font-family:sans-serif;line-height:24px;padding:0 30px">
                  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%!important;border-collapse:collapse;margin:0;padding:0px">
                    <tbody>
                      <tr>
                        <td align="left" valign="top" style="color: #000;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:14px 10px 40px 0;"> Total charges to your account </td>
                        <td align="right" valign="top" style="color: #000;text-align:right;border-collapse:collapse;border-top:1px solid #d5e0d5;padding:14px 0 40px 0;;white-space:nowrap"> ${{ $audience->total_price}} </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </div>


        <div >
          <h5 style="font-family: sans-serif; color: #000" class="mb-3">
            Need Help?
          </h5>
          <p style="font-family: sans-serif; color: #000">
            Please send any feedback or bug reports <br />
            to info@smematrimony.com
          </p>
          <p style="color: #000">
            <a style="color: #000" href="#">unsubscribe</a> from this list
          </p>
        </div>
        <div style="max-width: 600px;margin: auto; padding: 20px 0; background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675); opacity: 0.95; font-size: 17px; position: relative; margin-top: 40px; text-align: center">
          <p
            style="
              font-size: 14px;
              color: #fff;
              margin-bottom: 10px;
              font-family: sans-serif;
            "
          >
            &copy; {{date('Y')}} {{env('APP_NAME')}}. {{ $lang_arr['menu']['footer_right_reserved'] }}
          </p>
          <ul
            style="
              display: inline-block;
              list-style: none;
              align-items: center;
              justify-content: center;
              padding-left: 0;
              margin: 0;
            "
          >
            <li style="margin-right: 5px; display: inline-block">
              <a
                href="{{ isset($social_links->youtube_link)? $social_links->youtube_link :'#' }}"
              >
                <img
                  style="width: 18px"
                  src="{{ asset('images/icons/youtube.png') }}"
                  alt=""
                />
              </a>
            </li>
            <li style="margin-right: 5px; display: inline-block">
              <a
                href="{{ isset($social_links->instagram_link)? $social_links->instagram_link:'#' }}"
              >
                <img
                  style="width: 18px"
                  src="{{ asset('images/icons/insta.png')}}"
                  alt=""
                />
              </a>
            </li>
            <li style="margin-right: 5px; display: inline-block">
              <a
                href="{{ isset($social_links->facebook_link)? $social_links->facebook_link:'#' }}"
              >
                <img
                  style="width: 18px"
                  src="{{ asset('images/icons/fbe.png') }}"
                  alt=""
                />
              </a>
            </li>
          </ul>
        </div>
      </div>
  </body>
</html>
