@extends('admin.layouts.app')
@section('title', 'Feed Back')
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/feedback')}}" class="">@yield('title')</a></li>
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
            <h5 class="mb-1">View FeedBack</h5>
            <p class="mb-0 text-muted small pull-right">{{ $created_at }} | By: {{$member->first_name}} {{$member->last_name}}</p>
          </div>
          <div class="card-body">
            @include('admin.message')
            
              <div class="col-md-12">
                <div class="bd-post-thumbnail mt-2 mb-4">
                  <img data-lazyloaded="1" src="{{$image}}" alt="{{$feedback->title}}" data-was-processed="true">
                </div>
                <div class="bd-post-details my-3 d-flex flex-column px-5">
                  <h1>{{$feedback->title}}</h1>
                  <div class="single-page-content pb-5">
                    {{$feedback->title}}
                  </div>
                </div>
              </div>    
              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/feedback')}}">
                      <button type="button" class="btn btn btn-secondary">
                        <span>Cancel</span>
                      </button>
                    </a>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')

@endsection
