@extends('admin.layouts.app')
@section('title', 'Stories')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote.min.css') }}">
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
                  <li class="breadcrumb-item"><a href="{{url('admin/stories')}}" class="">@yield('title')</a></li>
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
            <h5 class="mb-1">Add Story</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/stories')}}"
              enctype="multipart/form-data" method="POST">
              @csrf
              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $story->id }}" />
              <div class="col-md-12">
                <label for="title" class="form-label">Title*</label>
                <input type="text" name="title" class="form-control required" id="title" required=""
                    value="{{ ($action == 'Add') ? old('title') : $story->title}}">
              </div>
              <div class="col-md-6">
                <label for="member_id" class="form-label">Member*</label>
                <select class="form-select" name="member_id" id="member_id">
                  <option value="">Select Member</option>
                  @foreach($member as $K => $V)
                    <option value="{{ $V->id }}" {{ ($V->id == $story->member_id || $V->id == old('member_id'))? 'selected':'' }}>{{ $V->first_name.' '.$V->last_name}} </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="partner_name" class="form-label">Partner Name*</label>
                <input type="text" name="partner_name" class="form-control required" id="partner_name" required=""
                    value="{{ ($action == 'Add') ? old('partner_name') : $story->partner_name}}">
              </div>
              <div class="col-md-6">
                <label for="image" class="form-label">Image*</label>
                <input type="file" name="image" class="form-control" id="image" >
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                  <option value="1" {{$story->status == 1  ? 'selected' : ''}}>Active</option>
                  <option value="0" {{$story->status == 0  ? 'selected' : ''}}>Disable</option>
                </select>
              </div>
              <div class="col-md-12">
                <label for="description" class="form-label"> Description*</label>
                  <textarea  name="description" class="form-control open-source-plugins required" required=""rows="15">{{$story->description}}</textarea>
                  <div id="description-error" class="help-block" style="display:none"></div>
              </div>
              <h3 class="m-2">Photo Gallery</h3>
              <div class="alert-secondary m-0 " style="position: relative;padding: 1rem 1rem;margin-bottom: 1rem;border: 1px solid transparent;">
              Select Images <input type="file" name="gallery[]" multiple class="form-control" accept="image/x-png,image/gif,image/jpeg" />
                @if($action == 'Edit')
                  <div id="sp_gal">
                    <div class="row">
                      @foreach($gallary as $glry)
                      <div class="col-md-2 mt-4">
                        <img src="{{checkImage(asset('storage/stories/'. $glry),'',$glry,1)}}" style="height: 100px;">
                        <div style="margin:8px 8px 3px 8px;">
                        <input name="chk_del[]" value="{{ $glry }}" type="checkbox"> DELETE</div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                @endif
              </div>

              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/stories')}}">
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

<script>
  $(document).ready(function() {
    $("#admins-form").validate({});
  });
</script>
@endsection
