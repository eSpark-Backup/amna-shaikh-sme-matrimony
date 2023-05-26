@extends('admin.layouts.app')
@section('title', 'Events')
@section('css')
  <link rel="stylesheet" href="{{ asset('admin-assets/summernote/summernote.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/custom.css?=') }}">
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
            <h5 class="mb-1">Event Invoice Details</h5>
            <p class="mb-0 text-muted small">Basic Information</p>
          </div>
          <div class="card-body" data-="0">
            <div class="table-responsive">
              <table class="table table-bordered table-striped .table-condensed">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Total Guests</th>
                    <th>Guest Charges</th>
                    <th>Event Charges</th>
                    <th>Total</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ (isset($guests->get_member->first_name))?$guests->get_member->first_name.' '.$guests->get_member->last_name:'---' }}</td>
                    <td>{{ $guests->total_guests }}</td>
                    <td>{{ ($guests->guest_charges*$guests->total_guests) }}</td>
                    <td>{{ $guests->event_charges }}</td>
                    <td>{{ $guests->total_price }}</td>
                    <td>
                      @if($guests->status == 1)
                        <span class="badge rounded-pill bg-success">Approved</span>
                      @else
                        <span class="badge rounded-pill bg-danger">Not Approved</span>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-12">
                @if($guests->status == 0)
                  <div class="pull-right">
                    <form action="{{ url('admin/events-audience/request-approved') }}" method="post">
                      @csrf
                      <input type="hidden" name="status" value="1">
                      <input type="hidden" name="id" value="{{ $guests->id }}">
                      <button type="submit" class="btn btn-primary  btn-fullrounded">
                        <span>Approved</span>
                      </button>
                    </form>
                  </div>
                @endif
              </div>
          </div>
        </div>
      </div>
    </div>
    @if(!empty($members))
      <div class="row">
        <div class="col-12 mb-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-1">Guests</h5>
              <p class="mb-0 text-muted small">Basic Information</p>
            </div>
            <div class="card-body" data-="0">
              @include('admin.message')
              @if(!empty($members))
                <div class="table-responsive">
                  <table class="table table-bordered table-striped .table-condensed">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Relation</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($members as $K => $V)
                        <tr>
                          <td>{{ $V['name'] }}</td>
                          <td>{{ $V['gender'] }}</td>
                          <td>{{ $V['age'] }}</td>
                          <td>{{ $V['relation'] }}</td>
                          <td>
                            @if($guests->status == 0)
                              <div class="actions table-operate flex">
                                <a class="edit_btn" title="Edit" data-indx="{{$K}}" data-id="{{$guests->id}}" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><img src="{{asset('admin-assets/assets/media/icons/files/edit_pencil.svg') }}" id="btnedit-{{$K}}"></a>
                                &nbsp;<a class="btn-danger del_btn" data-indx="{{$K}}" data-id="{{$guests->id}}" onclick="myfunc1(this)" title="Delete"><img src="{{ asset('admin-assets/assets/media/icons/files/bin_icon.svg') }}"></a>
                              </div>
                            @else
                              ---
                            @endif
                          </td>
                        </tr>
                      @endforeach
                      
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Guest Record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <input type="hidden" name="index"  id="index">
          <input type="hidden" name="rec_id"  id="record-id">
          <div class="row">
            <div class="col-md-6">
              <label for="is_approved" class="form-label">Name</label>
              <input type="text" name="" class="form-control" value="" id="name">
            </div>
            <div class="col-md-6">
              <label for="relation" class="form-label">Relation</label>
              <select name="relation" class="form-control" id="relation">
                  <option value="">-- Select Relation --</option>
                  @foreach($siblings as $K => $V)
                    <option value="{{ $V->name }}">{{ $V->name }}</option>
                  @endforeach
                  <!-- <option value="Father">Father</option>
                  <option value="Mother">Mother</option>     
                  <option value="Sister">Sister</option>     
                  <option value="Brother">Brother</option>      -->
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="age" class="form-label">Age</label>
             <select name="age" class="form-control" id="age">
                <option value="">-- Select Age --</option>
                @for($i=100; $i >= 1; $i--)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor   
              </select>
            </div>
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender</label>
              <select name="gender" class="form-control" id="gender">
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>      
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn_save_record">Save</button>
        </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script src="{{ asset('admin-assets/summernote/summernote.min.js') }}"></script>
<script>
  var members = <?php echo $guests->guests ?>;
  var testAr = [];
  var url = "{{ url('admin/events-audience/update-guest') }}";
  console.log(members);

  $(document).ready(function(){
    $('.edit_btn').on('click', function(){
      var ind = $(this).data('indx');
      var id = $(this).data('id');
      $('#name').val(members[ind].name);
      $('#age').val(members[ind].age);
      $('#relation').val(members[ind].relation);
      $('#gender').val(members[ind].gender);
      $('#index').val(ind);
      $('#record-id').val(id);
    });
    $('#btn_save_record').on('click', function(){
      showOverlayLoader();
      var ind = $('#index').val();
      var id = $('#record-id').val();

      
      if ($('#name').val() != '' && $('#relation').val() != '' &&  $('#age').val() != '' && $('#gender').val() != '') {
        
        members.splice(ind,1);

        members.push({'name':$('#name').val(),'relation': $('#relation').val(),'age': $('#age').val(),'gender':$('#gender').val()});
        $.ajax({        
            url: url,
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'post',             
            data: {'guests' : JSON.stringify(members),'id':id,'action':'Edit' },
            success: function(response) {
              var response = JSON.parse(response);
              
              if (response.status == 1) {
                window.location = response.res_url;
                hideOverlayLoader();
              }
            }           
        });
      }else{
        alert('Some values are missing, Please try again');
        hideOverlayLoader();
        return false;
      }
        
        
    });

  });

  function myfunc1(_this) {
    if (confirm("Are you sure you want to delete this record?")) {
      showOverlayLoader();
      var ind = $(_this).data('indx');
      var id = $(_this).data('id');
      var _dlt = members[ind];
      
      members.splice(ind,1);
        
        $.ajax({        
            url: url,
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            type: 'post',             
            data: {'guests' : JSON.stringify(members),'id':id,'action':'Delete','deleted_gust' :JSON.stringify(_dlt)  },
            success: function(response) {
              var response = JSON.parse(response);
              if (response.status == 1) {
                //$(_this).closest('tr').remove();
                window.location = response.res_url;
                //hideOverlayLoader();
              }
            }           
        });
    }
  }
</script>
@endsection