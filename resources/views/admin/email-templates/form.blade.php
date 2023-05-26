@extends('admin.layouts.app')
@section('title', 'Email Template')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote.min.css') }}">
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <style>
    .note-editor.note-frame.panel.panel-default {
      background-color: black !important;
      color: white !important;
    }
  </style>
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
                  <li class="breadcrumb-item"><a href="{{url('admin/email-templates')}}" class="">@yield('title')</a></li>
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
            <h5 class="mb-1">{{$action}} Email Template</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')

            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/email-templates')}}"
              enctype="multipart/form-data" method="POST">
              @csrf

              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $email_template->id }}" />

              <div class="col-md-12">
                <!-- Create the editor container -->
                
                <label for="name" class="form-label">Subject*</label>
                <input type="text" name="subject" class="form-control required" id="subject" required=""
                    value="{{ ($action == 'Add') ? old('subject') : $email_template->subject}}">
              </div>
              @if ($action == 'Add')
                <div class="col-md-12">
                  <label for="name" class="form-label">Type*</label>
                  <input type="text" name="type" class="form-control required" id="subject" required=""
                      value="{{ ($action == 'Add') ? old('type') : $email_template->type}}">
                </div>
              @endif
              <div class="col-md-12">
                <label for="content"  class="form-label">Content*</label>
                <textarea name="content" class="open-source-plugins">{{$email_template->content}}</textarea>
                
                <!-- <textarea id="editor" name="content" class="form-control required" required=""rows="15">{{$email_template->content}}</textarea>
                <div id="content-error" class="help-block" style="display:none"></div>  -->

              </div>


              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/email-templates')}}">
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
