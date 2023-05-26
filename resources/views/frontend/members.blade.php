@extends('app')
@section('title', 'Members')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
@endsection
@section('content')
<!-- Profile Page -->
<section class="filters-section">
    <div class="container">
        <div class="filters-content">
            <form id="search-form" autocomplete="off">
                <div class="filter-search">
                    <div class="row align-items-end">
                        <div class="col-md-6 col-lg-7 col-xl-8">
                            <label for="">Search</label>
                            <input type="text" placeholder="Search by Member first name, last name, email address."
                                name="first_name">
                        </div>
                        <div class="col-md-6 col-lg-5 col-xl-4">
                            <div class="filter-btn">
                                <button type="button" class="filters"><img
                                        src="{{asset('assets/images/filter-white.png') }}" alt="icon">Advanced
                                    Filters</button>
                                <button type="submit"><img src="{{asset('assets/images/srchh.png')}}" alt="icon">Search</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="filters-wrap mt-4">
                    <div class="filters-content">
                        <!-- <span><img src="{{asset('assets/images/error.png')}}" alt="icon">Your filter will be saved, and applied automatically next time you login  </span> -->
                        <div class="filters-row flex">
                            <div class="single-filterr">
                                <label for="">Age from</label>
                                <select name="partner_age" id="partner_age">
                                    <option value="">Choose Any</option>
                                    @for($i = 17; $i <= 50; $i++) <option value="{{$i}}">{{$i}}</option>
                                        @endfor

                                </select>
                            </div>
                            <div class="single-filterr">
                                <label for="">Marital status</label>
                                <select name="maritial_status_id" id="maritial_status_id">
                                    <option value="">Choose Any</option>
                                    @foreach($maritalStatus as $MK => $MV)
                                    <option value="{{ $MV->id }}">{{ $MV->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="single-filterr">
                                <label for="">Caste</label>
                                <select name="caste_id" id="caste_id">
                                    <option value="">Choose One</option>
                                    @foreach($castes as $CK => $CV)
                                    <option value="{{ $CV->id }}">{{ $CV->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="single-filterr">
                                <label for="">job title</label>
                                <select name="occupation_id" id="occupation_id">
                                    <option value="">Choose a Caste first</option>
                                    @foreach($occupations as $OK => $OV)
                                    <option value="{{ $OV->id }}">{{ $OV->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="filters-row-bottom">
                        <div class="filters-row flex">
                            <div class="single-filterr">
                                <label for="">Hight(feet)</label>
                                <select name="height" id="height">
                                    <option value="">Choose Any</option>
                                    <option value="4ft 0in - 122cm">4ft 0in - 122cm</option>
                                    <option value="4ft 1in - 124cm">4ft 1in - 124cm</option>
                                    <option value="4ft 2in - 127cm">4ft 2in - 127cm</option>
                                    <option value="4ft 3in - 129cm">4ft 3in - 129cm</option>
                                    <option value="4ft 4in - 132cm">4ft 4in - 132cm</option>
                                    <option value="4ft 5in - 135cm">4ft 5in - 135cm</option>
                                    <option value="4ft 6in - 137cm">4ft 6in - 137cm</option>
                                    <option value="4ft 7in - 140cm">4ft 7in - 140cm</option>
                                    <option value="4ft 8in - 142cm">4ft 8in - 142cm</option>
                                    <option value="4ft 9in - 145cm">4ft 9in - 145cm</option>
                                    <option value="4ft 10in - 147cm">4ft 10in - 147cm</option>
                                    <option value="4ft 11in - 150cm">4ft 11in - 150cm</option>
                                    <option value="5ft 0in - 152cm">5ft 0in - 152cm</option>
                                    <option value="5ft 1in - 153cm">5ft 1in - 153cm</option>
                                    <option value="5ft 2in - 157cm">5ft 2in - 157cm</option>
                                    <option value="5ft 3in - 160cm">5ft 3in - 160cm</option>
                                    <option value="5ft 4in - 162cm">5ft 4in - 162cm</option>
                                    <option value="5ft 5in - 165cm">5ft 5in - 165cm</option>
                                    <option value="5ft 6in - 168cm">5ft 6in - 168cm</option>
                                    <option value="5ft 7in - 170cm">5ft 7in - 170cm</option>
                                    <option value="5ft 8in - 172cm">5ft 8in - 172cm</option>
                                    <option value="5ft 9in - 175cm">5ft 9in - 175cm</option>
                                    <option value="5ft 10in - 177cm">5ft 10in - 177cm</option>
                                    <option value="5ft 11in - 180cm">5ft 11in - 180cm</option>
                                    <option value="6ft 0in - 183cm">6ft 0in - 183cm</option>
                                    <option value="6ft 1in - 185cm">6ft 1in - 185cm</option>
                                    <option value="6ft 2in - 188cm">6ft 2in - 188cm</option>
                                    <option value="6ft 3in - 190cm">6ft 3in - 190cm</option>
                                    <option value="6ft 4in - 193cm">6ft 4in - 193cm</option>
                                    <option value="6ft 5in - 195cm">6ft 5in - 195cm</option>
                                    <option value="6ft 6in - 198cm">6ft 6in - 198cm</option>
                                    <option value="6ft 7in - 200cm">6ft 7in - 200cm</option>
                                    <option value="6ft 8in - 203cm">6ft 8in - 203cm</option>
                                    <option value="6ft 9in - 205cm">6ft 9in - 205cm</option>
                                    <option value="6ft 10in - 208cm">6ft 10in - 208cm</option>
                                    <option value="6ft 11in - 211cm">6ft 11in - 211cm</option>
                                    <option value="7ft 0in - 213cm">7ft 0in - 213cm</option>
                                    <option value="7ft 1in - 216cm">7ft 1in - 216cm</option>
                                    <option value="7ft 2in - 218cm">7ft 2in - 218cm</option>
                                    <option value="7ft 3in - 221cm">7ft 3in - 221cm</option>
                                    <option value="7ft 4in - 223cm">7ft 4in - 223cm</option>
                                    <option value="7ft 5in - 226cm">7ft 5in - 226cm</option>
                                    <option value="7ft 6in - 228cm">7ft 6in - 228cm</option>
                                    <option value="7ft 7in - 231cm">7ft 7in - 231cm</option>
                                    <option value="7ft 8in - 234cm">7ft 8in - 234cm</option>
                                    <option value="7ft 9in - 236cm">7ft 9in - 236cm</option>
                                    <option value="7ft 10in - 239cm">7ft 10in - 239cm</option>
                                    <option value="7ft 11in - 241cm">7ft 11in - 241cm</option>

                                </select>
                            </div>
                            <div class="single-filterr">
                                <label for="">Education</label>
                                <select name="education_id" id="education_id">
                                    <option value="">Choose One</option>
                                    @foreach($educations as $EK => $EV)
                                    <option value="{{ $EV->id }}">{{ $EV->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="single-filterr">
                                <label for="">Nationality</label>
                                <select name="nationality_id" id="nationality_id">
                                    <option value="">Choose Any</option>
                                    @foreach($nationality as $NK => $NV)
                                    <option value="{{ $NV->id }}">{{ $NV->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="single-filterr">
                                <label for="">Country</label>
                                <select name="country_id" id="country_id">
                                    <option value="">Choose Any</option>
                                    @foreach($countries as $K => $V)
                                    <option value="{{ $V->id }}">{{ $V->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="single-filterr">
                            </div>
                        </div>
                        <div class="filters-actions flex">
                            <a href="javascript:void(0)" id="clear_filters">Clear all Filters</a>
                            <button type="submit">Apply Filter</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>
<!-- Profiles -->
<section class="profiles-section">
    <div class="container">
        <div class="profiles-content ">

            <table id="members_table" class="w-100">
                <thead>
                    <tr>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="results hide" style="display: none;">
            <span><img src="{{asset('assets/images/result.png')}}" alt="image"></span>
            <h2>Get to know your matches on another level</h2>
            <span>Find out if you and your match are compatible</span>
        </div>
    </div>
</section>

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
    <div class="like_popup">
            <div class="modal fade" id="like_for_approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h2>Upgrade Now</h2>
                    <span class="msg_ic_cls">
                        <svg xmlns="http://www.w3.org/2000/svg" width="118.983" height="124.121" viewBox="0 0 118.983 124.121">
                          <g id="Layer_x0020_1" transform="translate(-1044.458 -308.009)">
                            <path id="Path_21360" data-name="Path 21360" d="M52.194,105.489v24.794a3.08,3.08,0,0,0,5.3,2.129l29.224-26.924h24.64a13.986,13.986,0,0,0,13.954-13.954V37.829a13.986,13.986,0,0,0-13.954-13.953H41.334A13.985,13.985,0,0,0,27.38,37.829V91.535a13.986,13.986,0,0,0,13.954,13.954h10.86Zm49.812-48.117a5.268,5.268,0,1,0,5.268,5.268,5.268,5.268,0,0,0-5.268-5.268Zm-51.325,0A5.268,5.268,0,1,0,55.95,62.64a5.268,5.268,0,0,0-5.268-5.268Zm17.108,0a5.268,5.268,0,1,0,5.268,5.268,5.268,5.268,0,0,0-5.268-5.268Zm17.108,0a5.268,5.268,0,1,0,5.268,5.268A5.268,5.268,0,0,0,84.9,57.372Zm46.511,28.366c-4.046,0-4.046,6.155,0,6.155a13.986,13.986,0,0,0,13.954-13.954V24.233A13.986,13.986,0,0,0,131.409,10.28H61.388c-4.046,0-4.046,6.153,0,6.153h70.021a7.831,7.831,0,0,1,7.8,7.8V77.938a7.831,7.831,0,0,1-7.8,7.8ZM58.347,123.274V102.411a3.077,3.077,0,0,0-3.077-3.077H41.334a7.832,7.832,0,0,1-7.8-7.8V37.829a7.832,7.832,0,0,1,7.8-7.8h70.02a7.831,7.831,0,0,1,7.8,7.8V91.535a7.831,7.831,0,0,1-7.8,7.8l-25.831.007a3.058,3.058,0,0,0-2.08.81Z" transform="translate(1017.579 298.23)" fill="#d92483" stroke="#d92483" stroke-width="1"/>
                          </g>
                        </svg>
                    </span>
                    <h3>Choose your Package</h3>
                    <p>Unlock Messages and chat with anyone you like!</p>
                        <div class="plan_main_sec">
                            <div class="plan_inner">

                                @foreach($plans as $K => $V)
                                    <div class="plan_col {{ $K == 1 ? 'most_popular_main' : '' }}">

                                        @if ($K == 1)
                                            <div class="most_popular">
                                                <span class="btn_popular">Most Popular</span>
                                            </div>
                                        @endif
                                        <div class="plan_cont">
                                            <div class="plan_inner_cont">
                                                <h2>{{ $V->period }}</h2>
                                                <h5>Days</h5>

                                                @if($K == 1)
                                                    <p>Best Seller</p>
                                                @endif
                                            </div>
                                            <h3>${{ $V->price }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <div class="continue-action">
                        <a href="{{url('/plans')}}">Continue</a>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
        </div>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        var oTable = $('#members_table').DataTable({
            "bLengthChange": false,
            searching: false,
            processing: true,
            serverSide: true,
            sorting: false,
            ordering: false,
            'language': {
                "loadingRecords": "&nbsp;",
                "processing": "Loading..."
            },
            "ajax": {
                "url": "{!! url('user/members') !!}",

                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                "data": function (d) {
                    d.first_name = $("input[name=first_name]").val();
                    d.country_id = $('select[name=country_id]').val();
                    d.education_id = $('select[name=education_id]').val();
                    d.nationality_id = $('select[name=nationality_id]').val();
                    d.occupation_id = $('select[name=occupation_id]').val();
                    d.height = $('select[name=height]').val();
                    d.caste_id = $('select[name=caste_id]').val();
                    d.maritial_status_id = $('select[name=maritial_status_id]').val();
                    d.partner_age = $('select[name=partner_age]').val();
                }
            },
            "footerCallback": function ( row, data, start, end, display ) {
                
                if (display.length == 0) {
                    // $('.filters-content').hide();
                    $('.filters-wrap').slideUp();
                    $('.profiles-content').hide();
                    $('.results').show();
                }else{
                    $('.filters-wrap').slideUp();
                    $('.results').hide();
                    $('.profiles-content').show();
                }
                  
            },
            columns: [{
                data: 'customer_html',
                name: 'customer_html'
            }, ]
        }).on('page.dt', function () {
            $('html, body').animate({
                scrollTop: $(".dataTables_wrapper").offset().top
            }, 'slow');

        });
        
        $('#search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();

        });
        $('#clear_filters').on('click', function (e) {
            $('#search-form')[0].reset();
        });

        $('#reasonList').on('change', function (e) {

            if ($(this).val() == 'other') {
                $('.reportComments').css('display','block');

            } else {
                $('.reportComments').css('display','none');
            }
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

        $('body').on('click', '.interest-request', function (e) {
            e.preventDefault();
            var id = $(this).data('memberid');
            var status = $(this).data('status');
            showOverlayLoader();
            $.ajax({
                url: "{{ url('/user/send-interest-request') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "post",
                data: {
                    'member_interested_id': id,
                    'status': status
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
                              title: 'Why wait?',
                              
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
                }
            });
        });

        $('body').on('click', '.btn-member-msg', function (){
            var aprved = {{ auth()->user()->is_approved }};
            var _status = {{ auth()->user()->status }};
            if ( aprved != 1 && _status == 4) {
                Swal.fire({
                    icon: 'warning',
                    title: "Account is under admin approval",
                  
                    text:   "Your account is under admin approval. You'll not be able to perform any actions until your profile is approved. Thanks for your patience.",
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
                    '<a href="/user/edit-profile" target="_blank"> GoTo Profile </a>',
                  
                    cancelButtonText:'Cancel',
                    cancelButtonColor: '#e7147b',
                    confirmButtonColor: '#21c2d6',
                });
            }else if(aprved != 1){
                Swal.fire({
                    icon: 'warning',
                    title: 'Verification Required',
                  
                    text:   'Your account verification is required. Please complete your profile and submit it for admin approval. After your profile is approved you ll receive a verified user badge to continue your search.',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                  
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    confirmButtonText: '<a href="/user/edit-profile" target="_blank"> GoTo Profile </a>',
                  
                    cancelButtonText: 'Okay',
                    cancelButtonText:'Cancel',
                    cancelButtonColor: '#e7147b',
                    confirmButtonColor: '#21c2d6',
                });
            }
            else if(aprved == 1){
                var hasid = $(this).data('memberidhash');
                var chat_url = "{{ url('/user/chats?id=') }}";
                chat_url = chat_url+hasid;
                window.location.href = chat_url;
            }
        });
    });
</script>
@endsection