@extends('admin.layouts.app')
@section('title', 'Seo Settings')
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
                  <li class="breadcrumb-item"><a href="{{url('admin/seo-settings')}}" class="">@yield('title')</a></li>
                  <li class="breadcrumb-item active"></li>
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
            <h5 class="mb-1"> @yield('title')</h5>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/seo-settings/update')}}"
              enctype="multipart/form-data" method="POST">
              @csrf
              @foreach ($data as $item)
                <input name="id" type="hidden" value="{{ $item['id'] }}" />
                <!-- Basic Info -->
                <div class="card padding-unset">
                  <div class="card-header custom-card-header">
                      Seo Settings
                  </div>
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                                <label for="author" class="form-label">Author Name</label>
                                <input type="text" name="author" class="form-control required" id="author" value="{{ $item['author'] }}">
                            </div>
                              <div class="col-md-6">
                                <label for="seo_revisit" class="form-label">Seo Revisit</label>
                                <input type="number" name="seo_revisit" class="form-control required" id="seo_revisit" value="{{ $item['seo_revisit'] }}">
                            </div>
                            <div class="col-md-12">
                              <label for="keywords" class="form-label">Keywords</label>
                              <textarea name="keywords"  class="form-control open-source-plugins" rows="15">{{ $item['keywords'] }}</textarea>
                            </div>
                            <div class="col-md-12">
                              <label for="description" class="form-label">Description</label>
                              <textarea name="description" class="form-control open-source-plugins" rows="15">{{ $item['description'] }}</textarea>
                            </div>
                          </div>
                  </div>
                </div>
              @endforeach
              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/dashboard')}}">
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
<script>
  $(document).ready(function() {
    $('.summernote').summernote({ height: 300});
  });

</script>

@endsection
