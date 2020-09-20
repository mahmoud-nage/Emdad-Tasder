@extends('affiliate.layouts.app')

@section('content')
    <style>
        tr:hover{
            cursor: pointer;
        }
    </style>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="contacts">



        <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-box"></i>
										</span>
                        <h3 class="kt-portlet__head-title">
                            Tickets
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">

                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-brand btn-icon-sm" data-toggle="modal" data-target="#ticketModal" data-dismiss="modal">
                                    <i class="flaticon2-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> name </th>
                            <th> phone </th>
                            <th> email </th>
                            <th> subject </th>
                            <th> body </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $key => $ticket)
                            <tr onclick="window.location.replace('{{ route('affiliate.tickets.show' , $ticket->id) }}')">
                                <td> {{ $key + 1 }} </td>
                                <td> {{ $ticket->user->name }} </td>
                                <td> {{ $ticket->user->phone }} </td>
                                <td> {{ $ticket->user->email }} </td>
                                <td> {{ $ticket->subject }} </td>
                                <td> {!! $ticket->details !!} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!--end: Search Form -->
                </div>


            </div>
        </div>
        <div class="modal fade ticket-modal" id="ticketModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create a Ticket</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('affiliate.tickets.store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_type" value="affiliate">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label>Subject <span class="color-second">*</span></label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Provide a detailed description <span class="color-second">*</span></label>
                                    <textarea name="body"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="color-main">attachment</label>

                                    <div class="file-upload">

                                        <div class="input-group">
                                            <input type="file" name="attachment" class="dropify">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-rejected">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- end:: Content -->
    </div>

    <!-- END CONTENT -->
@endsection
@section('script')
    <script>
        CKEDITOR.replace('body');
    </script>
@stop
