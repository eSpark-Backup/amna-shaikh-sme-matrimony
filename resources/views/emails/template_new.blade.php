<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
<table bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0" width="100%" >
    <tbody>
    <tr>
        <td>
            <div style="max-width:600px;margin:0 auto;font-size:16px;line-height:24px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff;width:100%!important;line-height:100%!important;border-collapse:collapse;margin:0;padding:0;" >
                                <tbody>
                                <tr>
                                    <td style="border-collapse:collapse;">
                                        <table cellpadding="0" cellspacing="0" border="0" style="
                                background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675);
                                opacity: 0.95;
                                font-size: 17px;
                                position: relative;
                                width:100%!important;
                              ">
                                            <tbody>
                                            <tr>
                                                <td colspan="2" width="100%" style="border-collapse:collapse;padding:15px 0px 15px 0px;text-align:left;background-color:#ffffff;"  id="m_6179757838132566861upwork_logo_cell">
                                                    <img src="https://crzglobal.xyz/assets/images/email-logo-center.png" alt="SME logo" width="77px" border="0" style="display:block;outline:none;text-decoration:none;border:none;margin-left: auto;margin-right:auto" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" valign="middle" width="100%" style="max-width: 600px; margin: auto;padding: 20px 0; background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675);opacity: 0.95;font-size: 14px; position: relative;">
                                      <span style="background: #fff ; height: 45px ; width: 45px ; border-radius: 50% ; overflow: hidden;  display: block;margin: 0px auto;padding: 0;"><img src="https://crzglobal.xyz/assets/images/email-filled-center.png" alt="SME logo" width="30px" border="0" style="display:block;outline:none;text-decoration:none;border:none;margin-left: auto;margin-right:auto; margin-top: 7px;">
                                      </span>
                                                    <h4 style="margin: 10px 0; color: #fff; font-size: 14px; text-align: center;">{{$heading}}</h4>
                                                </td>
                                            </tr>
                                            <tr style="font-family: sans-serif;font-size:14px;">
                                                <td colspan="2" align="center" valign="top" width="100%" style="border-collapse:collapse;padding:20px 0px 20px 0px; background-color:#ffffff;">
                                                    {!! $content !!}
                                                </td>
                                            </tr>
                                            <tr style="font-family: sans-serif;font-size:14px;">
                                                <td colspan="2" align="center" valign="top" width="100%" style="border-collapse:collapse;padding:0 30px 40px 30px; background-color:#ffffff;">
                                                    <div style="text-align: center;">
                                                        <h4 style="font-family: sans-serif; color: #000;" class="mb-3">
                                                            Need Help?
                                                        </h4>
                                                        <p style="font-family: sans-serif; color: #000;">
                                                            Please send any feedback or bug reports <br />
                                                            to info@smematrimony.com
                                                        </p>
                                                        <p style="color: #000;">
                                                            <a style="color: #000;" href="#">unsubscribe</a> from this list
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="font-family:sans-serif;font-size:16px;">
                                                <td colspan="2" align="center" valign="top" width="100%" style="border-collapse:collapse;max-width: 600px;margin: auto; padding: 20px 0; background-image: linear-gradient(#e11d1e -73.27%, #ea147e, #573675); opacity: 0.95; font-size: 17px; position: relative;">
                                                    <div style="margin-top: 20px;text-align: center;">
                                                        <p
                                                            style="
                                            font-size: 14px;
                                            color: #fff;
                                            margin-bottom: -20px;
                                            font-family: sans-serif;
                                          ">
                                                            &copy; {{date('Y')}} {{env('APP_NAME')}}. {{ $lang_arr['menu']['footer_right_reserved'] }}
                                                        </p>

                                                        <ul
                                                            style="
                                          display: inline-block;
                                          list-style: none;
                                          align-items: center;
                                          justify-content: center;
                                          padding-left: 0;
                                          margin-top: 40;
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
                                                                        alt="" />
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
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
