@extends('app')
@section('title', 'Notification')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.min.css">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <style type="text/css">
      .noti_space {
    border: solid 1px #C9C9C9;
    border-radius: 20px;
    margin-top: 15px;
    padding: 15px;
}
.noti_space p {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 0;
}
.time_remove {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.noti_time span {
    font-size: 15px;
    color: #393939;
    display: block;
}
.noti_remove span a {
    height: 28px;
    width: 28px;
    background: #683276;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.noti_remove span a img {
    filter: brightness(0) invert(1);
}
.unread_notification {
    background: #EFEFEF;
}
.notification-drop .dropdown-toggle::after {
    display: none;
}

.notification-drop {
    position: relative;
}
.notification-drop ul.dropdown-menu {
    inset: unset !important;
    min-width: 190px;
    left: unset !important;
    right: 0 !important;
    transition: unset !important;
    padding: 0;
    border: 0;
    border-radius: 10px !important;
    background: #F5F7FA;
}

.notification_title {
  position: relative;
}
.notification-drop img {
  filter: brightness(0);
}
.notification-drop .dropdown-menu {
    display: none !important;
}
.notification-drop .dropdown-menu.show {
  display: block !important;
}
  </style>
@endsection
@section('content')
<!-- Profiles -->
<section class="profiles-section">
    <div class="container">
        <div class="profiles-content ">
            <div class="notification_title">
                    <div class="inner-title d-flex align-items-center">
                            <h4>My Notification</h4>
                            <div class="ml-auto notification-drop">
                                <a href="javascript:avoid(0)" class="dropdown-toggle" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset('assets/images/more_dots.png')}}" alt="">
                                </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteNotification(this)">Clear All</a>
                              </li>
                              <!-- <li>
                                <a class="dropdown-item" href="#">Mark All As Read</a>
                              </li> -->
                            </ul>
                          </div>
                    </div>
            </div>
            <table id="notification_table" class="w-100">
                <thead>
                    <tr>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="results">
            <span><img src="{{asset('assets/images/result.png')}}" alt="image"></span>
            <h2>Record Not Found.</h2>
            <!-- <span>Find out if you and your match are compatible</span> -->
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        var oTable = $('#notification_table').DataTable({
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
                "url": "{!! url('user/notifications') !!}",

                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                "data": function (d) {
                    /*d.first_name = $("input[name=first_name]").val();
                    d.country_id = $('select[name=country_id]').val();
                    d.education_id = $('select[name=education_id]').val();
                    d.nationality_id = $('select[name=nationality_id]').val();
                    d.occupation_id = $('select[name=occupation_id]').val();
                    d.height = $('select[name=height]').val();
                    d.caste_id = $('select[name=caste_id]').val();
                    d.maritial_status_id = $('select[name=maritial_status_id]').val();
                    d.partner_age = $('select[name=partner_age]').val();*/
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
    });

    function deleteNotification($this) {
        var notification_id = $($this).attr('data-id');
        var user_id = "{{ auth()->user()->id ?? ''}}";

        if (confirm("Are you sure you want to delete notification?") == true) {
            //call ajax for Delete Notification
            var formData = new FormData(); // Currently empty
            var token = "{{ csrf_token() }}";
            formData.append('_token', token);
            formData.append('userId', user_id);

            if (notification_id) {
              formData.append('notification_id', notification_id);
            }

            $.ajax({
              url: '{{ route("user.clearAllNotification") }}',
              dataType: 'json',
              data: formData,
              type: 'POST',
              cache: false,
              contentType: false,
              processData: false,
              success: function(res) {

                if (res.status === true) {
                  // toastr.success(res.message);
                    Swal.fire(
                      'Notification Removed!',
                      res.message,
                      'success'
                    )
                } else {

                  if (notification_id) {
                    $('.notification_div_'+notification_id).remove();

                  } else {
                    $('.noti_space').remove();
                  }
                  // toastr.error(res.message);
                }
              },
              error: function(jqXHR, textStatus, textStatus) {
                if (jqXHR.responseJSON.errors) {
                  $.each(jqXHR.responseJSON.errors, function(index, value) {
                    toastr.error(value)
                  });
                } else {
                  toastr.error(jqXHR.responseJSON.message)
                }
              }
            });          
        }
    }
</script>
@endsection