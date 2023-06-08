@extends('app')
@section('title', 'Chats')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">

   <link type="text/css" rel="stylesheet" href="{{ asset('assets/lightgellary/css/lightgallery.css') }}" />
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
   <style>
       .dataTables_empty{
            display: none;
        }
   </style>
@endsection
@section('content')
    <!-- Chat -->
    <main class="chatMain">
            <div class="container">
                <section class="chat-section">
                    <div class="chat-mobile">
                        <span> <i class="fa fa-bars"></i> Messages</span>
                    </div>
                    <div class="chat-content flex">
                        @if(isset($chat_user) && !empty($chat_user))
                            <div class="chat-sidebar">
                        @else
                            <div class="chat-sidebar active">
                        @endif
                            <div class="caht-head">
                                <h4>Chats</h4>
                                <!-- <span>6 active chats</span> -->
                            </div>

                            <div class="chat-boxes">
                            	<table id="members_table" class="w-100">
                                    <thead>
                                       <tr>
                                          <th scope="col"></th>
                                       </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                            <!-- Include file here -->
                            @include('/frontend.partials.conversation')

                    </div>
                </section>
            </div>
    </main>
    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload & Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body">
                <div class="row">
                   <div class="col-md-8 text-center">
                      <div id="image_demo" class="upload-image-container"></div>
                      <img id='id2' src=''>
                      <input type="hidden"  id="ext" value="">
                   </div>
                    <div class="col-md-4 current-chat-footer chat_img_uplaod_btn">
                        <div class="upload_left_btn">
                            <div class="uploading_spinner text-center form-text text-muted" style="display: none;">Uploading ...</div>
                            <!--  <button class="btn btn-success crop_image">Upload Image</button> -->
                            <button type="button" class="btn btn-success crop_image"> Send <img src="{{ asset('assets/images/send.svg') }}" alt="icon" data-instantimage="0"></button>
                        </div>
                        <div class="uploading_btn">
                            <div class="uploading_spinner text-center form-text text-muted" style="display: none;">Uploading ...</div>
                            <img class="encrypt-send crop_image" data-instantimage="1" src="http://crzglobal.xyz/assets/images/encrypt-msg.svg" alt="Instant">
                        </div>
                    </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             </div>
          </div>
       </div>
    </div>
    <div class="alert_popup chat_upgrade_popup">
        <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h2>Upgrade to send message!</h2>
                <p>To receive and send messages kindly upgrade.</p>
                <div class="alert-action">
                    <a href="{{ url("/plans") }}" class="btn">View Plans</a>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
                </div>
              </div>
              <!-- <div class="modal-footer">
                    <a href="javascript:void(0);" onclick="submitApprovalForm()">Proceed</a>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn">Cancel</button>
              </div> -->
            </div>
          </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://crzglobal.xyz:9000/socket.io/socket.io.js"></script> -->
{{--    <script src="/socket.io/socket.io.js"></script>--}}

    <script type="text/javascript">

        const socket = io('https://localhost:9000',{secure: true});
        var auth_id = {{ auth()->user()->id }};
        var uploaded_image = '';
        var user_hash = {{ (isset($rid) && !empty($rid) ) ? $rid:0 }};
        var current_url = window.location.search;
        var active_chatId = current_url.replace('?id=','');
        var typing=false;
        var timeout=undefined;
        var cht_active = '';
        console.log("sdfasd")

        $(document).ready(function() {

            // $(".message123").on('input', function(){
            //     console.log("typing")
            //     socket.emit('typing', {typing:"hello from php"})
            // })

            socket.on("connected", function(data){
                console.log(data)
                socket.on("sender_typing", function(data){
                    if(data.receiver_id == auth_id){
                        // console.log("typing...")
                        $('#is_typing').text("typing...")
                        setTimeout(() => $('#is_typing').text(""), 2000)
                    }
                  })
            })

            //event for send message on enter button
                /*$('#messagePPP').keypress(function(event){

                  var keycode = (event.keyCode ? event.keyCode : event.which);
                    if(keycode == '13'){
                        event.preventDefault();
                        var message = $('#message').val();
                        if(message != ''){
                            upload(message,0,'');
                        }
                        //$('#btn-send').trigger('click');
                    }
                });*/
            /*$('.no_plan').on('click' , function(){

                Swal.fire({
                          title: "It's time to upgrade",
                          icon: 'error',
                          html:
                            'To upgrade package please click on , ' +

                            '<div class="plan-footer">'+
                                '<a href="/plans">Plans</a>'+
                            '</div>',
                          focusConfirm: true,

                        });

                return false;
            });*/

            $("#message-form").submit(function(e) {
                // Stop the form submitting
                e.preventDefault();
                var message = $('#message').val();
                if(message != ''){
                    $('.sendMsgBtn').prop('disabled', true);
                    upload(message,0,'');
                }
            });
            //show typing ..
            $('#message').keypress((e)=>{
                var receiver_id=$('#user_id_receiver').val()
                if(e.which!=13){
                  typing=true
                  socket.emit('typing', {typing:true,user_id:auth_id, receiver_id: receiver_id})
                //   console.log({user_id: auth_id, receiver_id : receiver_id})
                  clearTimeout(timeout)
                  timeout=setTimeout(typingTimeout, 3000)
                }else{
                  clearTimeout(timeout);
                  typingTimeout(receiver_id);
                  //sendMessage() function will be called once the user hits enter
                  event.preventDefault();
                  $('#btn-send').trigger('click');
                }
            });
            $('#message').focusout(function(){
                var receiver_id=$('#user_id_receiver').val()
                clearTimeout(timeout);
                typingTimeout(receiver_id);
            });
            //code explained later
            socket.on('display', (data)=>{
                if (data.user_id != auth_id) {

                    if(data.typing==true){
                      $('.typing').text('typing...');
                    }else{
                      $('.typing').text("");
                    }
                }
            });
            //END show typing ..
            var oTable = $('#members_table').DataTable({
              "bLengthChange": false,
                searching: false,
                processing: true,
                serverSide: true,
                sorting: false,
                ordering : false,
                bPaginate: false,
                ordering: false,
                info: false,
                'language':{
                   "loadingRecords": "&nbsp;",
                   "processing": "Loading..."
                },
                "ajax": {
                    "url": "{!! url('user/chats') !!}",

                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                columns: [

                    {

                    "render": function(data, type, row, meta) {
                        var _url = "{{ url('user/chats?id=') }}";
                        _url = _url+row.hash_id;
                        var tme = '';
                        var current_chat_active = '';
                        /*if(row.un_red_count == 0){
                            tme = '<span class="time">3 min</span>';
                        }else{
                            tme = '<span class="unread">'+row.un_red_count+'</span>';
                        }*/
                        if(row.un_red_count != 0){
                            tme = '<span class="unread">'+row.un_red_count+'</span>';
                        }
                        var msg = '';
                        if( row.msg_file != '' ){
                            msg = '<img src="{{ asset('assets/images/image-svgrepo-com.svg') }}">';
                        }else if(row.message != '' || row.message != null){
                            msg =  '<p>'+row.message+'</p>';
                        }
                        if (row.chat_user_id == user_hash) {
                            cht_active = 'u_cht_active';
                        }

                        if (row.hash_id == active_chatId) {
                            current_chat_active = 'active';
                        }
                        return '<ul>'+
                                '<a href="'+_url+'" class="u_cht '+cht_active+'">'+
                                '<li class="'+current_chat_active+'">'+

                                        '<div class="single-chat flex">'+
                                            '<div class="chat-image '+ (row.picture_privacy == "blur" ? 'blur_img' : '') +'" style="background-image: url('+row.profile_image_path+');">'+

                                            '</div>'+
                                            '<div class="chat-data">'+
                                                '<h5>'+row.display_user_name+'</h5>'+
                                                msg+
                                            '</div>'+tme+

                                        '</div>'+

                                '</li>'+ '</a>'+
                            '</ul>';
                    }
                  },
                ]
            }).on('page.dt', function() {
              $('html, body').animate({
                scrollTop: $(".dataTables_wrapper").offset().top
              }, 'slow');

            });

            $('#btn-send').on('click',function(event) {
                /* Act on the event */
                var message = $('#message').val();
                if(message){
                    $('.sendMsgBtn').prop('disabled', true);
                    upload(message,0,'');
                    oTable.draw();

                }
            });
            $('.instant_message').on('click',function(event) {

                var message = $('#message').val();
                if(message){
                    upload(message,1,'');
                    oTable.draw();

                }
            });

            socket.off('session_join_request_get').on('session_join_request_get', function(msg) {


                if(msg.receiver.id == auth_id){
                    var message = '';
                    if(msg.file != null){
                        var _insmsg = '';
                        if(msg.instant == 1){
                            _insmsg = '<img class="instant-msg instant-msg-left" src="{{asset('assets/images/instant-msg.svg') }}">';
                        }

                        message = '<div class="receiving-sms generic-append d-flex justify-content-start"><div class="receiving-mesg">'+
                                    '<a href="'+msg.file+'" data-fancybox="gallery"><img class="receiving-img" style="width: 14rem" src="'+msg.file+'"></a>'+_insmsg
                                '</div></div>';
                    }else{
                        var _insmsg = '';
                        if(msg.instant == 1){
                            _insmsg = '<img class="instant-msg instant-msg-left" src="{{asset('assets/images/instant-msg.svg') }}">';
                        }
                        message =   '<div class="receiving-sms generic-append d-flex justify-content-start">'+
                                        '<div class="receiving_msg_cont">'+
                                            '<div class="receiving-mesg">'+
                                                '<p>'+msg.message+'</p>'+
                                                _insmsg+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                    }

                    $('.generic-append:last').after(message);
                    scrollBottom();
                    oTable.draw();
                    //window.scrollTo(100%-190, $('.current-chat-body').scrollHeight);
                }
            });

            //upload image
            $('.add_photo').on("click", function(e) {
                e.preventDefault();
                $('#file').focus().trigger("click");

            });
            $image_crop = $('#image_demoP').croppie({
                enableExif: true,

                viewport: {
                    width: 600,
                    height: 600,
                    type: 'square' //circle
                },
                boundary: {
                    width: 400,
                    height: 400
                }
            });
            var fileTypes = ['jpg', 'jpeg', 'png','gif'];

            $('#file').on('change', function() {
                var reader = new FileReader();
                var file = this.files[0]; // Get your file here

                var fileExt = file.type.split('/')[1]; // Get the file extension
                $('#ext').val(fileExt);

                if (fileTypes.indexOf(fileExt) !== -1)
                {

                    /*reader.onload = function(event) {
                      $image_crop.croppie('bind', {
                          url: event.target.result
                      }).then(function() {

                      });
                    }*/
                    reader.onload = function (e) {
                        $('#id2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                   // reader.readAsDataURL(this.files[0]);
                    $('#uploadimageModal').modal('show');

                }
                else
                {
                  alert('File not supported');
                }
            });

            $('.crop_image').on("click", function(event) {
                var response = $('#id2').attr('src');
                var ext = $('#ext').val();
                response = response.replace("data:image/png;base64,", "");
                var _inst = $(this).data('instantimage');
                upload('',_inst,response);

                oTable.draw();
                scrollBottom();

                /*$image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {

                    response = response.replace("data:image/png;base64,", "");

                    upload('',_inst,response);

                    oTable.draw();
                    scrollBottom();
                })*/
                //upload('',response,ext);
            });
            //var aDay = 2*60*60*1000;
            var aDay = 1660403391;

            scrollBottom();
        });
        function typingTimeout(receiver_id){
            typing=false;
            socket.emit('typing', {typing:false,user_id:auth_id, receiver_id: receiver_id});
        }

        function upload(msg='',instant=0, img='') {
            $('.sendMsgBtn').prop('disabled', true);

            var user_id_receiver = $('#user_id_receiver').val();
            var data = {
                '_token': "{{ csrf_token() }}",
                'message': msg,
                'file': img,
                'instant': instant,
                'user_id_receiver' : user_id_receiver
            }
            $('.uploading_spinner').show();


            // AJAX request

            /*$.post('{{ route("user.users_add_photo") }}', data)
            .done(function(response) {
                $('.crop_image').show();
                $('.uploading_spinner').hide();
                $('#uploadimageModal').modal('hide');
                _photo = 0;
                window.location.reload(true);
            })
            .fail(function($xhr) {
                var response = $xhr.responseJSON;
                $('.uploading_spinner').hide();
                $('.crop_image').show();
                   // Swal.fire(response.msg);
                });*/
                // AJAX request

                $.post('{{ route("user.send-message") }}', data)
                .done(function(response) {
                    console.log("send message")
                        socket.emit("send_message",{is_send: true, data: data})
                        $('.uploading_spinner').hide();
                        $('#uploadimageModal').modal('hide');
                        var res = JSON.parse(response);

                        $('.sendMsgBtn').prop('disabled', false);

                        if(res.status == 1){

                            var im = "{{ asset('storage/members/chat/') }}";
                            var msges = '';
                            var image_url = '';
                            if (res.success_data.chat.msg_file != '') {

                                image_url = im+'/'+res.success_data.chat.msg_file;
                                msges = '<div class="sender-sms sender-sms-img generic-append d-flex justify-content-end p-0">'+
                                            '<a href="'+image_url+'" data-fancybox="gallery"><img class="sender-img" style="width: 14rem" src="'+image_url+'"><span>'+res.success_data.chat.d_time+'</span><div class="sms-status"><img src="{{asset('assets/images/s_tick.png')}}" alt="icon"></div></a>';
                                        if(instant == 1){
                                          msges += '<img class="instant-msg instant-msg-right" src="{{asset('assets/images/instant-msg.svg') }}">';
                                        }

                                        '</div>';
                            }else{
                                var ins_msg = '';
                                if(instant == 1){
                                   ins_msg = '<img class="instant-msg instant-msg-right" src="{{asset('assets/images/instant-msg.svg') }}">';
                                }
                                // msges =   '<div class="sender-sms generic-append"><div class="send_msg_cont"><div class="msg_left_cls">'+
                                //     '<p>'+msg+'</p>'+
                                //     '<span>'+res.success_data.chat.d_time+'</span><div class="sms-status"><img src="{{asset('assets/images/s_tick.png')}}" alt="icon"></div>'+ins_msg+

                                // '</div><div class="msg_right_cls"><img class="sender-img" src="'+image_url+'"></div></div></div>';


                                msges =   '<div class="sender-sms generic-append"><div class="send_msg_cont"><div class="msg_left_cls">'+
                                    '<p>'+msg+'</p>'+
                                    ins_msg+

                                '</div></div></div>';
                            }

                            $('.generic-append:last').after(msges);
                            scrollBottom();
                            $('#message').val('');

                            var s_obj = {
                                'message':res.success_data.chat.message,
                                'file':res.success_data.chat.msg_file_path,
                                'time':res.success_data.chat.d_time,
                                'msgId':res.success_data.chat.message_id,
                                'chatId':res.success_data.chat.chat_id,
                                'sender': res.success_data.sender,
                                'receiver': res.success_data.receiver,
                                'instant': res.success_data.chat.instant_count,
                            }
                           socket.emit('session_join_request_send', s_obj);
                            if (res.is_active_plan == 0) {
                                //$('#chat_modal').modal('show');
                                Swal.fire({
                                  icon: 'warning',
                                  title: "Upgrade to send message",

                                  text:   "To continue sending messages please upgrade.",
                                  showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    },

                                    showCancelButton: true,
                                    focusConfirm: false,
                                    reverseButtons: true,
                                    confirmButtonText:
                                    '<a href="/plans" target="_blank"> View Plans </a>',

                                    cancelButtonText:'Cancel',
                                    cancelButtonColor: '#e7147b',
                                    confirmButtonColor: '#21c2d6',
                                });
                                return false;
                            }
                        }else if(res.status == 0){
                            /*$('#user_message_popup').text(res.message);
                            $('#no_plan').modal('show');*/
                            Swal.fire({
                              icon: 'warning',
                              title: res.title,

                              text:   res.message,
                              showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },

                                showCancelButton: true,
                                focusConfirm: false,
                                reverseButtons: true,
                                confirmButtonText:
                                '<a href="/plans" target="_blank"> View Plans </a>',

                                cancelButtonText:'Cancel',
                                cancelButtonColor: '#e7147b',
                                confirmButtonColor: '#21c2d6',
                            });
                            return false;

                            //$('#chat_modal').modal('show');
                            //return false;
                        }
                    })
                    .fail(function($xhr) {
                        var response = $xhr.responseJSON;
                        $('.uploading_spinner').hide();
                    });
        }
        function timeSince(date) {

          var seconds = Math.floor((new Date() - date) / 1000);

          var interval = seconds / 31536000;

          if (interval > 1) {
            return Math.floor(interval) + " years";
          }
          interval = seconds / 2592000;
          if (interval > 1) {
            return Math.floor(interval) + " months";
          }
          interval = seconds / 86400;
          if (interval > 1) {
            return Math.floor(interval) + " days";
          }
          interval = seconds / 3600;
          if (interval > 1) {
            return Math.floor(interval) + " hours";
          }
          interval = seconds / 60;
          if (interval > 1) {
            return Math.floor(interval) + " minutes";
          }
          return Math.floor(seconds) + " seconds";
        }
        function scrollBottom(){
            $(".current-chat-body").stop().animate({
                scrollTop: $(".current-chat-body")[0].scrollHeight
            }, 1000);
        }
    </script>

@endsection
