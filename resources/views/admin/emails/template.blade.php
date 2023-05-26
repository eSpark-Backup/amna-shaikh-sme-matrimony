<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{env('APP_NAME')}}</title>
</head>
<body style="padding:0; margin:0px; background:#eee;">
    <div style="max-width:600px; margin:auto;  background:#fff; color:#222; font-size:17px; position: relative;">
        <div style="width:100%; padding:15px 0px 35px; text-align:center; margin-bottom: 15px;background-size: cover;">
            <img src="{{ asset('admin-assets/assets/media/logo/footer-logo.png') }}" width="180">
        </div>
        {!! $content !!}
        <div style="margin-top: 40px; text-align: center; background: #F7F8FC;padding:10px 20px 10px;  ">
            <p style="font-size:12px; color: #000000; margin-bottom: 0; font-family: sans-serif;">{{ $lang_arr['faqs_section_further_assistance'] }}</p>
            <a style="color: #000000; font-size:12px;font-family: sans-serif; " href="#">{{ url('/') }}</a>
        </div>
        <!--footer area-->
        <div style=" background: #e61858; padding:10px 20px 10px; font-size: 12px;text-align: center; font-family: sans-serif;  color: #fff;">
            <!-- copyright area-->
            <p style="margin-bottom: 0; margin-top: 0">&copy; {{date('Y')}} {{env('APP_NAME')}}. {{ $lang_arr['menu']['footer_right_reserved'] }}</p>
        </div>
    </div>
</body>
</html>