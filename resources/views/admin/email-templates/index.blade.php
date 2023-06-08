@extends('admin.layouts.app')
@section('title', 'Email Templates')

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
                        <h5 class="mb-1">@yield('title') Listing</h5>
                        <div class="right">
                            <a href="{{url('admin/email-templates/create')}}" class="pull-right">
                                <button type="button" title="Add" class="btn btn-primary btn-lg btn-fullrounded">
                                    <span>Add</span>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="panel-body">
                                <table id="email-templates-datatable" class="table table-hover " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <!-- <th>Id</th> -->
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($email_templates as $key => $email_template)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <!-- <td>{{ $email_template->id }}</td> -->
                                            <td>{{ucwords(str_replace('_', ' ', $email_template->type))}}</td>
                                            <td>{{$email_template->subject}}</td>
                                            <td>
                                                <div class="actions table-operate flex">
{{--                                                    <a class="edit_btn" href="{{url('admin/email-templates/' . Hashids::encode($email_template->id) . '/edit')}}" title="Edit"><img src="{{asset('admin-assets/assets/media/icons/files/edit_pencil.svg')}}"></a>--}}
                                                    <a class="edit_btn" href="{{url('admin/email-templates/' . $email_template->id . '/edit')}}" title="Edit"><img src="{{asset('admin-assets/assets/media/icons/files/edit_pencil.svg')}}"></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
        $('#email-templates-datatable').dataTable(
        {
            pageLength: 50,
            scrollX: true,
            responsive: true,
            // dom: 'Bfrtip',
            lengthMenu: [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
            language: { "processing": showOverlayLoader()},
            drawCallback : function( ) {
                hideOverlayLoader();
            },
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
