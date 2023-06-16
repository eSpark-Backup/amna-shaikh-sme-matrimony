@extends('app')
@section('title', 'Members')
@section('content')
<main class="plansMain">
    <section class="interest_section">
        <div class="container">
            <div class="section-head">
                <h2>Interests List</h2>
            </div>
        </div>
    </section>
    <section class="interest-tabs-section">
        <div class="container">
            <div class="intrest-header">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active show" data-toggle="tab" href="#accepted" onclick="showInterest('request_accept',1)"><span class="cover">Accepted Members</span></a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#requests" onclick="showInterest('requested',2, 1)"><span class="cover">Interest Requests <!-- <span>1</span> --></span></a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#interest" onclick="showInterest('request_send',2)"><span class="cover">My Interests</span></a>
                        <a class="nav-item nav-link" data-toggle="tab" href="#rejected" onclick="showInterest('request_reject',3)"><span class="cover">Rejected Members <!-- <span>34</span> --></span></a>
                    </div>
                </nav>
            </div>
            <div class="intrest-body">
                <div class="tab-content px-sm-0" id="nav-tabContent">
                    <!-- Tab1 -->
                    <div class="tab-pane fade active show" id="accepted" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="interest-wrapping">
                            <div class="members-list" id="request_accept">
                                <!-- members show via ajax -->
                            </div>
                        </div>
                    </div>
                    <!-- Tab2 -->
                    <div class="tab-pane fade " id="requests" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="interest-wrapping">
                            <div class="members-list" id="requested">
                                <!-- members ll be loaded by ajax call -->
                            </div>
                        </div>
                    </div>
                    <!-- Tab3 -->
                    <div class="tab-pane fade " id="interest" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="interest-wrapping">
                            <div class="members-list" id="request_send">

                            </div>
                        </div>
                    </div>
                    <!-- Tab4 -->
                    <div class="tab-pane fade " id="rejected" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="interest-wrapping">
                            <div class="members-list" id="request_reject">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="liked">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                {{--                <h4 class="modal-title">Modal Heading</h4>--}}
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <p>You can send message</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn interest-request" id="send-like" data-dismiss="modal" data-status="1" data-checklikelimitcondition="0">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="chatLink">Send Message</button>
            </div>

        </div>
    </div>
</div>
<div class="alert_popup">
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="report-form" class="form-horizontal" action="{{route('user.report-user')}}" method="post">
                        <div class="icon-show">!</div>
                        <h2>Are you sure you want to Report this user?</h2>
                        <!-- <p></p> -->
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="reasonList" class="form-label">Reason of reporting <span class="star"> :*</span></label>
                                <select name="reasonList" id="reasonList" class="form-control required">
                                    <option value="">-- Choose One --</option>
                                    <option value="bad_manners">Bad Manners</option>
                                    <option value="not_responsive">Not Responsive</option>
                                    <option value="fake">Fake</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12 reportComments" style="display:none;">
                                <label for="comment" class="form-label">Comments <span class="star"> :*</span></label>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="memberId" value="" id="reportMemberId">
                        <div class="alert-action">

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn-custom-primary">Submit</a>
                        <button type="button" class="btn-custom-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var _assets = "{{ asset('assets/images/') }}" ;

        $(document).ready(function(){
            //by default active users
            showInterest('request_accept',1);

            $('body').on('click','.request-action', function(e){
                e.preventDefault();
                var id = $(this).data('member');
                var status = $(this).data('status');
                showOverlayLoader();
                $.ajax({
                    url: "{{url('/user/update-interest-request') }}",
                    headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    type:"post",
                    data:{'member_id':id, 'status':status},
                    cache:false,

                    success:function(data){
                        hideOverlayLoader();
                        var _act = '';
                        if (status == 1) {
                            showInterest('request_accept',status);
                        }else if (status == 3) {
                            showInterest('request_reject',status);
                        }


                    }
                });
            });
        });
        function showInterest(request,status,flag = 0){

            showOverlayLoader();
            $.ajax({
                url: "{{ url('/user/show-interest') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type:"post",
                data:{'status':status, 'request_for':flag},
                cache:false,

                success:function(data){
                    hideOverlayLoader();
                    if (data.status == 1) {
                        var members = data.success_data.data;

                        var _ul = '<ul class="requested">';
                        var country = '';
                        $('.requested').remove();
                        if (members.length > 0) {
                            $.each(members, function($in, mem){
                                console.log(mem);

                                 var url = "{{ url('user/members/') }}";
                                 _ul += '<li >'+
                                                '<div class="single-member ">'+
                                                    '<div class="member-image">'+
                                                        '<img src="'+mem.profile_image_path+'" class="member-image '+ (mem.picture_privacy == "blur" ? 'blur_img' : '') +'"  alt="image">'+
                                                 '</div>'+
                                                    '<div class="member-info">'+
                                                        '<div class="member-heading-occupation d-flex">'+
                                                         '<h5>'+mem.first_name+'</h5>'+
                                                    '<span>'+mem.occupation+'</span>'+
                                                 '</div>'+
                                                        '<div class="member-infos d-flex">'+
                                                            '<span><img src="'+_assets+'/map.svg" alt="icon">('+mem.country+')</span>'+
                                                        '<div class=" img-icon d-flex">';



                                                            // '<img class="report-request" src="'+_assets+'/Heart.png" data-memberid="mem.id+" alt=mark>'+
                                                            // '<img class="report-request" src="'+_assets+'/Close.png" data-memberid="mem.id+" alt=mark>'+
                                                            // '<img class="report-request" src="'+_assets+'/Mark.png" data-memberid="mem.id+" alt=mark>'+


                                                           if(request == "request_accept")
                                                            {
                                                                _ul += '<img class="interest-request likeMe" src="'+_assets+'/Heart.png" data-memberid="'+mem.id+'" data-memberid="'+mem.id+'" data-status="1" alt=mark>'+
                                                                '<img class="interest-request" src="'+_assets+'/Close.png" data-memberid="'+mem.id+'"  data-status="3" alt=mark>'+
                                                                '<img class="report-request" src="'+_assets+'/Mark.png" data-memberid="'+mem.id+'" alt=mark>';    
                                                            }
                                                            else if(request == "requested")
                                                            {
                                                                _ul += '<img class="interest-request likeMe" src="'+_assets+'/Heart.png" data-memberid="'+mem.id+'" data-memberid="'+mem.id+'" data-status="1" alt=mark>'+
                                                                '<img class="interest-request" src="'+_assets+'/Close.png" data-memberid="'+mem.id+'"  data-status="3" alt=mark>';
                                                            }
                                                            else if(request == "request_send")
                                                            {
                                                                _ul += '<img class="interest-request" src="'+_assets+'/Close.png" data-memberid="'+mem.id+'"  data-status="3" alt=mark>'+
                                                                '<img class="report-request" src="'+_assets+'/Mark.png" data-memberid="'+mem.id+'" alt=mark>';
                                                            }
                                                            else if(request == "request_reject")
                                                            {
                                                                _ul += '<img class="interest-request likeMe" src="'+_assets+'/Heart.png" data-memberid="'+mem.id+'" data-memberid="'+mem.id+'" data-status="1" alt=mark>'+
                                                                '<img class="report-request" src="'+_assets+'/Mark.png" data-memberid="'+mem.id+'" alt=mark>';
                                                            }





                                                        '</div>'+
                                                    '</div>';
                                                        if (request == 'requested') {
                                                            _ul += '<div class="prof-actions prof-btn-wraper">'+
                                                                '<a href="#" class="likeMe request-action" data-member="'+mem.id+'" data-status="1"><img src="'+_assets+'/like.png" alt="icon">Accept</a>'+
                                                                '<a href="#" class="request-action" data-member="'+mem.id+'" data-status="3"><img src="'+_assets+'/cross-ic.png" alt="icon">Reject</a>'+
                                                            '</div>';
                                                        }
                                                        else{
                                                            // _ul += '<a class="btn-custom-primary w-100" href="'+url+'/'+mem.id+'">View Full Profile</a>';
                                                        }
            
                                                    _ul += '</div>'+
                                                '</div><a class="btn-custom-primary w-100" href="'+url+'/'+mem.id+'">View Full Profile</a>'+
                                         '</li>';

                            });
                            _ul += '</ul>';
                            $('#'+request).append(_ul);
                        }else{
                            $('#'+request).append('<h3 class="requested" >No member found</h3>');
                        }
                    }

                }
            });
        }
        $('body').on('click', '.interest-request', function (e) {


            e.preventDefault();
            var id = $(this).data('memberid');
            var status = $(this).data('status');
            var checkLikeLimitCondition = $(this).data('checklikelimitcondition');

            if(checkLikeLimitCondition == 1)
            {
                $('#send-like').attr("data-memberid",id);
                var chatUrl = "{{ url('user/chats') }}";
                chatUrl = chatUrl+"?id="+id;
                var chatPageUrl = "window.location.href = '"+chatUrl+"'"
                $('#chatLink').attr('onclick',chatPageUrl);

                // onclick="window.location.href = 'https://ide.geeksforgeeks.org';"
            }
            showOverlayLoader();
            $.ajax({
                url: "{{ url('/user/send-interest-request') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "post",
                data: {
                    'member_interested_id': id,
                    'status': status,
                    'checkLikeLimitCondition':checkLikeLimitCondition
                },
                cache: false,

                success: function (data) {
                    hideOverlayLoader();

                    var data = JSON.parse(data);

                    if (data.status == 1) {
                        oTable.ajax.reload();
                        if(data.req_message != ''){
                            Swal.fire({
                                icon: 'info',
                                // title: 'Why wait?',

                                text:  data.req_message ,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText:'OK',
                                confirmButtonColor: '#21c2d6',
                            });
                        }
                    } else if(data.status == 0) {

                        Swal.fire({
                            icon: 'warning',
                            title: data.title,
                            text:   data.message,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },

                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonText:'OK',
                            confirmButtonColor: '#21c2d6',
                        });
                        return false;
                    } else if(data.status == 3) {
                        // alert('Update Plan')
                        $('#like_for_approval').modal('show');
                    }
                    else if(data.status == 5) {
                        $('#liked').modal('show');
                    }
                }
            });
        });

        $('body').on('click', '.report-request', function (e) {
            var memberId = $(this).attr('data-memberid');
            $('#reportMemberId').val(memberId);
            $('#reportModal').modal('show');
        });

        $('#report-form').on('submit', function (e) {
            e.preventDefault();
            var _this = $(this);
            var formData = new FormData(this);
            $.ajax({
                url: "{{ url('/user/report-user') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type:"POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    hideOverlayLoader();
                    $('#reportModal').modal('hide');
                    var data = JSON.parse(data);

                    if (data.status == 1) {
                        oTable.ajax.reload();
                        if(data.req_message != ''){
                            Swal.fire({
                                icon: 'warning',
                                title: 'Reported User',

                                text:  data.req_message ,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                showCloseButton: true,
                                showCancelButton: false,
                                focusConfirm: false,
                                confirmButtonText:
                                    'Okay',
                                confirmButtonColor: '#21c2d6',
                            });
                        }
                    } else if(data.status == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: data.title,

                            text:   data.message,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            confirmButtonColor: '#21c2d6',

                        });
                        return false;
                    }
                }
            });

        });
    </script>
@endsection
