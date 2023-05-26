@extends('admin.layouts.app')
@section('title', 'Marital Status')
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/marital-status')}}" class="">@yield('title')</a></li>
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
            <h5 class="mb-1">Add @yield('title')</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/marital-status')}}" method="POST">
              @csrf
              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $marital_status->id }}" />
              <div class="col-md-6">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" class="form-control required" id="name" required=""
                    value="{{ ($action == 'Add') ? old('name') : $marital_status->name}}">
              </div>

              <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                  
                  <option value="0" {{$marital_status->status == 0  ? 'selected' : ''}}>Disable</option>
                  <option value="1" {{ ( $marital_status->status == 1  || $action == 'Add' )  ? 'selected' : ''}}>Active</option>
                </select>
              </div>
              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/marital-status')}}">
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
  $("#admins-form").validate({});
</script>
@endsection
