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
@endsection

@section('js')
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
                                                        '<div class=" img-icon d-flex">'+
                                                            '<img class="report-request" src="'+_assets+'/Heart.png" data-memberid="mem.id+" alt=mark>'+
                                                            '<img class="report-request" src="'+_assets+'/Close.png" data-memberid="mem.id+" alt=mark>'+
                                                            '<img class="report-request" src="'+_assets+'/Mark.png" data-memberid="mem.id+" alt=mark>'+
                                                        '</div>'+
                                                    '</div>';
                                                      
            
            
            
                                                        if (request == 'requested') {
                                                            _ul += '<div class="prof-actions prof-btn-wraper">'+
                                                                '<a href="#" class="likeMe request-action" data-member="'+mem.id+'" data-status="1"><img src="'+_assets+'/like.png" alt="icon">Accept</a>'+
                                                                '<a href="#" class="request-action" data-member="'+mem.id+'" data-status="3"><img src="'+_assets+'/cross-ic.png" alt="icon">Reject</a>'+
                                                            '</div>';
                                                        }else{
                                                            _ul += '<a class="btn-custom-primary w-100" href="'+url+'/'+mem.id+'">View Full Profile</a>';
                                                        }
            
                                                    _ul += '</div>'+
                                                '</div>'+
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
    </script>
@endsection
