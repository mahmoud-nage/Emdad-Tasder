@extends('frontend.layouts.app')
@section('title' , __('general.support_ticket') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.support_ticket')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')

        
            <div class="main-content">
                    <div class="profile-title">
                
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class=" dashboard-stat add-ticket-wrapper" data-toggle="modal" data-target="#ticketModal">
                            <a href="#" class="add-ticket"></a>
                            <div class="add-ticket-title">
                                {{__('general.add_ticket')}}
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            <div class="table-wrapper">
                <div class="table-block">
                    <table class="table table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th class="reorder">#</th>
                                <th class="reorder">{{__('forms.date')}}</th>
                                <th class="">{{__('general.subject')}}</th>
                                <th class="">{{__('forms.status')}}</th>
                                <th class="">{{__('forms.options')}}</th>
                            </tr>
                            </thead>
                            <tbody style="font-size:14px">
                            @if(count($tickets) > 0)
                                @foreach ($tickets as $key => $ticket)
                                    <tr>
                                        <td>#{{ $ticket->code }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                            @if ($ticket->status == 'pending')
                                            <td><span class="label label-danger">{{__('general.pending')}}</span></td>
                                            @elseif ($ticket->status == 'open')
                                            <td><span class="label label-warning">{{__('general.open')}}</span></td>
                                            @else
                                                <td><span class="label label-success">{{__('general.solved')}}</span></td>
                                            @endif
                                        <td>
                                      
                                                                            <div class="dropdown custom-dropdown">
                                    <a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('support_ticket.seller_show', ['country' => get_country()->code, 'id' => encrypt($ticket->id)] )}}"> {{__('general.details')}}</a></li>
                                    </ul>
                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center pt-5 h4" colspan="100%">
                                        <i class="la la-meh-o d-block heading-1 alpha-5"></i>
                                        <span class="d-block">{{ __('general.no_history_found') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>

                        </table>
                    </div>
                </div>
                </div>

            </div>
        </div>
    </div>
    
    
     <!--Modals -->
<div class="modal fade ticket-modal" id="ticketModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{__('general.add_ticket')}}</h4>
            </div>
            <div class="modal-body">
                <form class="" action="{{  route('support_ticket.store',['country' => get_country()->code]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="container-fluid">
                    <div class="form-group">
                        <label>{{__('general.subject')}} <span class="color-second">*</span></label>
                        <input type="text" class="form-control" name="subject">
                        <input type="hidden" class="form-control" name="type" value="2">
                    </div>
                    <div class="form-group">
                        <label>{{__('general.description')}}  <span class="color-second">*</span></label>
                        <textarea id="editor1" name="details"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="file-upload">
                            <div class="file-select">
                                <input type="file" name="attachments[]" class="chooseFile" multiple>
                                <div class="file-select-name noFile">{{__('general.no_chosen')}}</div>
                                <div class="file-select-button fileName">
                                    <i class="fa fa-photo"></i>
                                    {{__('general.attachment')}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-rejected">{{__('general.send')}}</button>
                    </div>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
    
    <!--<div class="modal fade" id="ticket_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
    <!--    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">-->
    <!--        <div class="modal-content position-relative">-->
    <!--            <div class="modal-header">-->
    <!--                <h5 class="modal-title strong-600 heading-5">{{__('general.add_ticket')}}</h5>-->
    <!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--                    <span aria-hidden="true">&times;</span>-->
    <!--                </button>-->
    <!--            </div>-->
    <!--            <div class="modal-body px-3 pt-3">-->
    <!--                <form class="" action="{{ route('support_ticket.store',['country' => get_country()->code]) }}" method="post" enctype="multipart/form-data">-->
    <!--                    @csrf-->
    <!--                    <input type="hidden" name="user_type" value="affiliate">-->
    <!--                    <div class="form-group">-->
    <!--                        <label>{{__('general.subject')}} <span class="text-danger">*</span></label>-->
    <!--                        <input type="text" class="form-control mb-3" name="subject" placeholder="{{__('general.subject')}}" required>-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <label>{{__('general.description')}} <span class="text-danger">*</span></label>-->
    <!--                        <textarea class="form-control editor" name="details" placeholder="{{__('general.description')}}" data-buttons="bold,underline,italic,|,ul,ol,|,paragraph,|,undo,redo"></textarea>-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <input type="file" name="attachments[]" id="file-2" class="custom-input-file custom-input-file--2" data-multiple-caption="{count} files selected" multiple />-->
    <!--                        <label for="file-2" class=" mw-100 mb-0">-->
    <!--                            <i class="fa fa-upload"></i>-->
    <!--                            <span>{{__('general.attachment')}}</span>-->
    <!--                        </label>-->
    <!--                    </div>-->
    <!--                    <div class="text-right mt-4">-->
    <!--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('general.cancel')}}</button>-->
    <!--                        <button type="submit" class="btn btn-base-1">{{__('general.send')}}</button>-->
    <!--                    </div>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
@endsection
