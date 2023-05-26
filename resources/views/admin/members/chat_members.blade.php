@extends('admin.layouts.app')
@section('title', 'Chat Members')
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
                        <h5 class="mb-1">Chat Members Listing</h5>
                    </div>
                    <div class="card-body">
                        @include('admin.message')
                        <div class="col-12">
                            <div class="panel-body">
                                <table id="admins-datatable" class="table table-striped"  style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>member_id</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
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
@endsection
@section('js')
<script>
    $(function()
    {
        var url = '{{ url("admin/members/$user_id/view-chat-members") }}';
        $('#admins-datatable').dataTable(
        {
            pageLength: 50,
            scrollX: true,
            processing: false,
            language: { "processing": showOverlayLoader()},
            drawCallback : function() {
                hideOverlayLoader();
            },
            responsive: true,
            // dom: 'Bfrtip',
            lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'member_id', name: 'member_id'},
                {data: 'profile_image_path', name: 'profile_image_path'},
                {data: 'display_user_name', name: 'display_user_name'},
                {data: 'email', name: 'email'},
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
