@extends('admin.layouts.app')
@section('title', 'Events')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/select2.min.css') }}">
@endsection
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/events')}}" class="">@yield('title')</a></li>
                  <li class="breadcrumb-item active">{{$action}}</li>
                </ol>
              </nav>
            </div>
        </div>
    </div>
</div>
  <!--//Page Toolbar End//-->
<div class="content p-4 pb-0 d-flex flex-column-fluid">
  <div class="container-fluid px-0">
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card h-100">
          <div class="card-header">
            <h5 class="mb-1">{{$action}} Event</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')

            <form id="eventForm" class="form-horizontal label-left row g-3" action="" enctype="multipart/form-data" method="POST">
              @csrf

              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $event->id }}" />

              <div class="col-md-12">
                <label for="title" class="form-label">Title*</label>
                <input type="text" name="title" class="form-control required" id="title" required="" value="{{ ($action == 'Add') ? old('title') : $event->title}}">
              </div>
              <div class="col-md-6">
                <label for="type" class="form-label">Event Type</label>
                <select id="type" name="type" class="form-select">
                  <option value="1" {{ $event->type == 1  ? 'selected' : ''}}>Upcoming Event</option>
                  <option value="0" {{ $event->type == 0  ? 'selected' : ''}}>Past Event</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                  <option value="1" {{ $event->status == 1  ? 'selected' : ''}}>Active</option>
                  <option value="0" {{ $event->status == 0  ? 'selected' : ''}}>Inactive</option>
                </select>
              </div>
              <div class="col-md-12">
                <label for="short_description" class="form-label">Short Description*</label>
                  <textarea  name="short_description" class="form-control required open-source-plugins" rows="15">{{ ($action == 'Add') ? old('short_description') : $event->short_description}}</textarea>
                  <div id="short_description-error" class="help-block" style="display:none"></div>
              </div>
              <div class="col-md-6">
                <label for="joined_female" class="form-label">Joined Females*</label>
                <input type="number" name="joined_female" class="form-control required" id="joined_female" value="{{ ($action == 'Add') ? old('joined_female') : $event->joined_female}}" required="">
              </div>
              <div class="col-md-6">
                <label for="joined_male" class="form-label">Joined Male*</label>
                <input type="number" name="joined_male" class="form-control required" id="joined_male" value="{{ ($action == 'Add') ? old('joined_male') : $event->joined_male}}" required="">
              </div>
              <div class="col-md-6">
                <label for="seats_left" class="form-label">Text for seats left</label>
                <input type="text" name="seats_left" class="form-control" id="seats_left" value="{{ ($action == 'Add') ? old('seats_left') : $event->seats_left}}">
              </div>
              <div class="col-md-6">
                <label for="total_seats" class="form-label">Total Seats*</label>
                <input type="number" name="total_seats" class="form-control required" id="total_seats" value="{{ ($action == 'Add') ? old('total_seats') : $event->total_seats}}" required="">
              </div>
              <div class="col-md-6">
                <label for="location" class="form-label">Location*</label>
                <input type="text" name="location" class="form-control required" id="location" value="{{ ($action == 'Add') ? old('location') : $event->location}}">
              </div>
              <div class="col-md-6">
                <label for="country" class="form-label">Country*</label>
                <select id="country" name="country" class="form-select required">
                  <option value=""> -- Choose Country -- </option>
                  @foreach($countries as $country)
                  <option value="{{$country->name}}" {{$country->name == $event->country  ? 'selected' : ''}}>{{$country->name}}</option>
                  @endforeach
                </select>
              </div>
             <!--  <div class="col-md-6">
                <label for="adults_charges" class="form-label">Parents Charges*</label>
                <input type="number" name="adults_charges" class="form-control required" id="adults_charges" value="{{ ($action == 'Add') ? old('adults_charges') : $event->adults_charges}}" step="0.01">
              </div> -->
              

              <div class="col-md-6">
                <label for="  event_charges" class="form-label">Event Charges*</label>
                <input type="number" name="event_charges" class="form-control required" id="event_charges" value="{{ ($action == 'Add') ? old('event_charges') : $event->event_charges}}" required="" step="0.01">
              </div>
              <div class="col-md-6">
                <label for="event_date" class="form-label">Event Date*</label>
                <input type="text" name="event_date" class="form-control datepicker hasDatepicker required" id="event_date" value="{{$event->event_date}}" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
              </div>
              <div class="col-md-12">
                <label for="type" class="form-label">Family Members</label>
                <select id="type" name="siblings[]" class="select2" multiple="multiple" >
                  @foreach($siblings as $sibling)
                    <option value="{{ $sibling->id }}">{{$sibling->name}}</option>
                  @endforeach
                </select>
                
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Allow Number of members</label>
                <select id="status" name="allow_siblings" class="form-select">
                  @for($i = 0; $i<= 20;$i++)
                    <option value="{{$i}}" {{$event->allow_siblings == $i  ? 'selected' : ''}}>{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="col-md-6">
                <label for="adults_charges" class="form-label">Member Charges*</label>
                <input type="number" name="adults_charges" class="form-control required" id="adults_charges" value="{{ ($action == 'Add') ? old('adults_charges') : $event->adults_charges}}" step="0.01">
              </div>
              <!-- <div class="col-md-4">
                <label for="child_charges" class="form-label">Siblings Charges*</label>
                <input type="number" name="child_charges" class="form-control required" id="child_charges" value="{{ ($action == 'Add') ? old('child_charges') : $event->child_charges}}" step="0.01">
              </div> -->
              <div class="col-md-12">
                <label for="short_description" class="form-label">Long Description*</label>
                  <textarea  name="long_description" class="form-control open-source-plugins required" rows="15">{{ ($action == 'Add') ? old('long_description') : $event->long_description}}</textarea>
                  <div id="long_description-error" class="help-block" style="display:none"></div>
              </div>
              
              <div class="col-md-12">
                <h3 class="m-2">Video</h3>
                <input type="file" name="event_video" class="form-control " id="event_video" accept="video/mp4,video/x-m4v,video/*">
                @if($action == 'Edit' && !empty($event->event_video))
                  <video width="320" height="240" controls>
                    <source src="{{asset('storage/events/'.$event->event_video)}}" type="video/mp4">
                    <source src="{{asset('storage/events/'.$event->event_video)}}" type="video/ogg">
                    Your browser does not support the video tag.
                  </video>
                  <div style="margin:8px 8px 3px 8px;">
                      <input name="chk_del_video" value="{{ $event->event_video }}" type="checkbox"> DELETE</div>
                @endif
                
               
              </div>
              <h3 class="m-2">Photo Gallery</h3>
              <div class="alert-secondary m-0 " style="position: relative;padding: 1rem 1rem;margin-bottom: 1rem;border: 1px solid transparent;">

              Select Images <input type="file" name="gallary[]" multiple class="form-control" accept="image/x-png,image/gif,image/jpeg" />
              
              @if($action == 'Edit')
                <div id="sp_gal">
                  <div class="row">
                    @foreach($gallary as $glry)
                    <div class="col-md-2 mt-4">
                      <img src="{{checkImage(asset('storage/events/'. $glry),'',$glry,1)}}" style="height: 100px;">
                      <div style="margin:8px 8px 3px 8px;">
                      <input name="chk_del[]" value="{{ $glry }}" type="checkbox"> DELETE</div>
                    </div>
                    @endforeach
                  </div>
                </div>
              @endif
              </div>
              <!-- Progress bar -->
              <div id="uploadStatus"></div>
              <div class="progress">
                <div class="progress-bar"></div>
              </div>

              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/events')}}">
                      <button type="button" class="btn btn btn-secondary">
                        <span>Cancel</span>
                      </button>
                    </a>

                    <button type="submit" class="btn btn-primary  btn-fullrounded">
                      <span>Save</span>
                    </button>
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script src="{{ asset('admin-assets/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('admin-assets/assets/js/select2.min.js') }}"></script>
<script>
  $(document).ready(function() {
    /*var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('.datepicker ').val(today);*/
    $('.datepicker').datepicker({
        todayHighlight: true,
        dateFormat: 'yy-mm-dd'
    });

    var siblings = '<?php echo $event->siblings ?>';
    var siblings =  JSON.parse("[" + siblings + "]");
    console.log(siblings);


    $('.select2').select2({ width: '100%' });
    $(".select2").val(siblings).trigger('change');


  });

  // File upload via Ajax
  $(document).on('submit', "#eventForm", function(e) {
      e.preventDefault();
      tinyMCE.triggerSave();
      $.ajax({
          xhr: function() {
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function(evt) {
                  if (evt.lengthComputable) {
                      var percentComplete = ((evt.loaded / evt.total) * 100);
                      $(".progress-bar").width(percentComplete + '%');
                      $(".progress-bar").html(percentComplete+'%');
                  }
              }, false);
              return xhr;
          },
          type: 'POST',
          url: "{{url('admin/events')}}",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend: function(e){
              $(".progress-bar").width('0%');
              $('#uploadStatus').html('<img src="images/loading.gif"/>');
          },
          error:function(){
              $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
          },
          success: function(resp){
              console.log(resp);
              if(resp.status == 1){
                  $('#eventForm')[0].reset();
                  $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                  window.location.href = resp.url;
              }else if(resp.status == 0){
                
                var errorString = '<ul style="color:#EA4335">';
                $.each( resp.message, function( key, value) {
                  errorString += '<li>' + value[0] + '</li>';
                });
                errorString += '</ul>';

                $('#uploadStatus').html('<p style="color:#EA4335;">'+errorString+'</p>');
              }else if(resp == '1'){
                  $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
              }
          }
      });
  });

</script>
@endsection