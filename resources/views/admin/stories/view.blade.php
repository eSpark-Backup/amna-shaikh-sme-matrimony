@extends('admin.layouts.app')
@section('title', 'Stories')
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
            <h5 class="mb-1">View Story</h5>
            <p class="mb-0 text-muted small pull-right">{{ $created_at }} | By: {{ (isset($member) && !empty($member)) ? $member->first_name.' '.$member->last_name : '' }} </p>
          </div>
          <div class="card-body">
            @include('admin.message')
            
              <div class="col-md-12">
                <div class="bd-post-thumbnail mt-2 mb-4">
                  <img data-lazyloaded="1" src="{{$image}}" alt="{{$story->title}}" data-was-processed="true">
                </div>
                <div class="bd-post-details my-3 d-flex flex-column px-5">
                  <h1>{{$story->title}}</h1>
                  <div class="single-page-content pb-5">
                    {{$story->title}}
                  </div>
                </div>
              </div>
              <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/stories')}}"
                      enctype="multipart/form-data" method="POST">
                      @csrf
                      
                      <input name="id" type="hidden" value="{{ $story->id }}" />
                      @if($story->status == 1)
                        <input name="status" type="hidden" value="0" />
                      @else
                        <input name="status" type="hidden" value="1" />
                      @endif
                      
                      <div class="col-12">
                          <div class="pull-right">
                            <a href="{{url('admin/stories')}}">
                              <button type="button" class="btn btn btn-secondary">
                                <span>Cancel</span>
                              </button>
                            </a>
                            @if($story->status == 1)
                             <!--  <button type="submit" class="btn btn-danger  btn-fullrounded">
                              <span>Disable</span>
                            </button> -->
                            @else
                              <!-- <button type="submit" class="btn btn-success  btn-fullrounded">
                                <span>Approve</span>
                              </button> -->
                            @endif
                            
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

@endsection
