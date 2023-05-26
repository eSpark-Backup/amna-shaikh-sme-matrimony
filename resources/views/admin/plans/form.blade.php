@extends('admin.layouts.app')
@section('title', 'Plans')
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item"><a href="{{url('admin/plans')}}" class="">@yield('title')</a></li>
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
            <h5 class="mb-1">Add Plan</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body">
            @include('admin.message')
            <form id="admins-form" class="form-horizontal label-left row g-3" action="{{url('admin/plans')}}"
              enctype="multipart/form-data" method="POST">
              @csrf
              <input type="hidden" name="action" value="{{$action}}" />
              <input name="id" type="hidden" value="{{ $plan->id }}" />
              <div class="col-md-6">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" class="form-control required" id="name" required=""
                    value="{{ ($action == 'Add') ? old('name') : $plan->name}}">
              </div>
              <div class="col-md-6">
                <label for="price" class="form-label">Price*</label>
                <input type="number" name="price" class="form-control required" id="price" required="" step="0.01" min="0" value="{{ ($action == 'Add') ? old('price') : $plan->price}}">
              </div>
              <div class="col-md-6">
                <label for="period" class="form-label">Period (days)*</label>
                <input type="number" name="period" class="form-control required" id="period" required="" min="0" value="{{ ($action == 'Add') ? old('period') : $plan->period}}">
              </div>
              <div class="col-md-6">
                <label for="instant_messages_count" class="form-label">Instant Message Count*</label>
                <input type="number" name="instant_messages_count" class="form-control required" id="instant_messages_count" required="" min="0" value="{{ ($action == 'Add') ? old('instant_messages_count') : $plan->instant_messages_count}}">
              </div>
              <div class="col-md-6">
                <label for="period" class="form-label">Start Color</label>
                <input type="color" name="start_color" class="form-control" id="start_color" value="{{ ($action == 'Add') ? old('start_color') : $plan->start_color}}">
              </div>
              <div class="col-md-6">
                <label for="end_color" class="form-label">End Color</label>
                <input type="color" name="end_color" class="form-control" id="end_color" value="{{ ($action == 'Add') ? old('start_color') : $plan->end_color}}">
              </div>
              <div class="col-md-4">
                <label for="boosting" class="form-label">Unlimited Message Send</label>
                <select id="boosting" name="unlimited_messages_sent" class="form-select">
                  <option value="0" {{$plan->unlimited_messages_sent == 0  ? 'selected' : ''}}>No</option>
                  <option value="1" {{$plan->unlimited_messages_sent == 1  ? 'selected' : ''}} >Yes</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="boosting" class="form-label">Boosting Profile</label>
                <select id="boosting" name="boosting_profile" class="form-select">
                  <option value="0" {{$plan->boosting_profile == 0  ? 'selected' : ''}}>No</option>
                  <option value="1" {{$plan->boosting_profile == 1  ? 'selected' : ''}}>Yes</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                  <option value="1" {{$plan->status == 1  ? 'selected' : ''}}>Active</option>
                  <option value="0" {{$plan->status == 0  ? 'selected' : ''}}>Disable</option>
                </select>
              </div>
              <div class="col-md-12">
                <label for="status" class="form-label">Desription</label>
                <textarea class="form-control" rows="6" name="description">{{ ($action == 'Add') ? old('description') : $plan->description }}</textarea>
              </div>

              <div class="col-md-12">
                <h5 class="mb-1">Add Features</h5>
                @if($action == 'Edit' && isset($features) && !empty($features))
                  @foreach($features as $K => $V)
                    <div class="row features">
                      <div class="col-md-11">
                        <label for="features" class="form-label">Feature Text</label>
                        <input type="type" name="features[]" class="form-control" value="{{ $V }}">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger btn-fullroundedmt-5 mt-8 btn-delete-more ">
                          <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  @endforeach
                @else
                  <div class="row features">
                    <div class="col-md-11">
                      <label for="features" class="form-label">Feature Text</label>
                      <input type="type" name="features[]" class="form-control">
                    </div>
                    <div class="col-md-1 no-display">
                      <button type="button" class="btn btn-sm btn-danger btn-fullroundedmt-5 mt-8 btn-delete-more ">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                @endif
                
                <button type="button" class="btn btn-sm btn-success btn-fullroundedmt-5 pull-right mb-5 mt-5 addmore">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
              </div>

              <div class="col-12">
                  <div class="pull-right">
                    <a href="{{url('admin/plans')}}">
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
  $('.addmore').on('click',function(){
    //$('.features:last').find('.no-display').removeClass('no-display').clone().insertAfter('.features:last');
    var clone = $('body').find('.features:last').clone();
    clone.find('.no-display').removeClass('no-display');
    clone.find("input").val(""); 
    clone.insertAfter('.features:last');
  });

  $('body').on('click','.btn-delete-more', function(){
    $(this).closest(".features").remove();
  });

</script>
@endsection
