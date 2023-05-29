@extends('admin.layouts.app')
@section('title', 'Members')
@section('content')
<!--//Page Toolbar//-->
<div class="toolbar p-4 pb-0">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-5 mb-3 mb-lg-0">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="">Home</a></li>
                  <li class="breadcrumb-item active">@yield('title')</li>
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
                        <h5 class="mb-1">Members Listing</h5>
                        <div class="right">
                            <a href="{{url('admin/members/create')}}" class="pull-right">
                                <button type="button" title="Add" class="btn btn-primary btn-lg btn-fullrounded">
                                    <span>Add</span>
                                </button>
                            </a>
                            <!-- <a href="{{url('admin/members/export')}}" class="pull-right">
                                <button type="button" title="Export" class="btn btn-secondary btn-lg btn-fullrounded mr-2">
                                    <span>Export</span>
                                </button>
                            </a> -->

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              Export
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('admin.message')
                        <div class="col-12">
                            <div class="panel-body">
                                <table id="admins-datatable" class="table table-striped"  style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkAll" class="checkboxes"></th>
                                            <th>Id</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Plan</th>
                                            <th>Approval Status</th>
                                            <th>Created Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export Members</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form  class="form-horizontal label-left row g-3" action="{{url('admin/members/export')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="is_approved" class="form-label">Approval Status</label>
                        <select name="is_approved"  class="form-control">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                            <option value="2">Blocked</option>
                            <option value="3">Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <select name="country_id" class="form-control">
                            <option value="">-- Select Country --</option>
                            @foreach($country as $K => $V)
                                <option value="{{$V->id}}">{{$V->name}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 15px">
                        <div class="form-check">
                          <input type="hidden" name="mobile" value="0">
                          <input class="form-check-input" name="mobile" type="checkbox" value="1"  id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            Only Mobile Column Export
                          </label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="email" value="0">
                          <input class="form-check-input" name="email" value="1" type="checkbox"  id="flexCheckChecked" >
                          <label class="form-check-label" for="flexCheckChecked">
                            Only Email Column Export
                          </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Export</button>
            </div>
        </form>
    </div>
  </div>
</div>



@endsection
@section('js')
<script>
    $(function()
    {
        var url = "{{ url('admin/members') }}";
        $('#admins-datatable').dataTable(
        {
            initComplete: function () {
                this.api().columns([5]).every( function (ci) {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var s_val = '';
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            /*if (val == 'Active') {
                                s_val = 1;
                            }else if (val == 'Pending') {
                                s_val = 0;
                            }else if (val == 'Block') {
                                s_val = 2;
                            }*/
                            //console.log(s_val);
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                        //console.log(column);
                        //console.log(column.data().unique());
                     column.data().unique().sort().each( function ( d, j ) {
                        var st_value = '';
                        if (d == 0) {
                            st_value = 'Incomplete';
                        }if (d == 1) {
                            st_value = 'Active';
                        }if (d == 2) {
                            st_value = 'Block';
                        }if (d == 3) {
                            st_value = 'Cancel';
                        }
                        if (d == 4) {
                            st_value = 'Pending';
                        }
                        select.append( '<option value="'+d+'">'+st_value+'</option>' )
                     });
                } );
            },
            pageLength: 50,
            scrollX: true,
            processing: false,
            language: { "processing": showOverlayLoader()},
            drawCallback : function( ) {
                hideOverlayLoader();
            },
            responsive: true,
            // dom: 'Bfrtip',
            lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
            serverSide: true,
            ajax: url,
            columns: [
                {
                    "render": function(data, type, row, meta) {
                        return '<input type="checkbox" name="member_id[]" value="'+row.id+'" id="checkItem" class="checkboxes"><span class="text-danger"> </span>';
                    }
                },
                {data: 'id', name: 'id'},
                {data: 'profile_image', name: 'profile_image'},

                {data: 'name', name: 'first_name'},
                {data: 'plan', name: 'plan'},
                {
                    data:'is_approved',
                    "render": function(data, type, row, meta) {
                      if (row.is_approved == 0) {
                         return '<span class="badge rounded-pill bg-info">Incomplete</span>';
                      }
                      if (row.is_approved == 1) {
                        return '<span class="badge rounded-pill bg-success">Approved</span>';
                      }if (row.is_approved == 2) {
                        return '<span class="badge rounded-pill bg-danger">Block</span>';
                      }if (row.is_approved == 3) {
                        return '<span class="badge rounded-pill bg-danger">Rejected</span>';
                      }
                      if (row.is_approved == 4) {
                        return '<span class="badge rounded-pill bg-warning">Pending</span>';
                      }
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false},
            ]
        }).on( 'length.dt', function () {
            showOverlayLoader();
        }).on('page.dt', function () {
            showOverlayLoader();
        }).on( 'order.dt', function () {
            showOverlayLoader();
        }).on( 'search.dt', function () {
            showOverlayLoader();
            $(".loader").css("background-color", "rgba(100,100,100,0)");
        });
    });
</script>
@endsection
