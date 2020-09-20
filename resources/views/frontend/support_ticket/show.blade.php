@extends('frontend.layouts.app')

@section('content')
    <!-- Page Contents Wrapper-->
    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.customer_side_nav')
        <!--  Content -->
        
        
                <!--  Content -->
        <div class="main-content">

            <!-- Ticket -->
            <div class="ticket-wrapper">
                <div class="ticket-header">
                    <div>
                        {{ $ticket->subject }} #{{ $ticket->code }}
                    </div>
                    <div>
                        {{ date('h:i:m A d-m-Y', strtotime($ticket->created_at)) }}
                        <!--<span class="pending">pending</span>-->
                                         @if ($ticket->status == 'pending')
                                            <span class="label label-danger">{{__('general.pending')}}</span>
                                            @elseif ($ticket->status == 'open')
                                            <span class="label label-warning">{{__('general.open')}}</span>
                                            @else
                                             <span class="label label-success">{{__('general.solved')}}</span>
                                            @endif
                    </div>
                </div>
                <div class="ticket-body">
                    <form class="" action="{{route('support_ticket.seller_store'['country' => get_country()->code])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                        <input type="hidden" name="user_id" value="{{$ticket->user_id}}">
                        <div class="form-group">
                            <textarea id="editor" name="reply"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="file-upload">
                                <div class="file-select">
                                    <input type="file" name="attachments[]" class="chooseFile" multiple >
                                    <div class="file-select-name noFile">{{__('general.no_chosen')}}</div>
                                    <div class="file-select-button fileName">
                                        <i class="fa fa-photo"></i>
                                        Upload
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-rejected btn-lg">{{__('general.send_replay')}}</button>
                        </div>
                    </form>
                        <hr>
                    @foreach ($ticket_replies as $ticketreply)
                        <div class="reply-wrapper col-sm-8">
                                <div class="replay-details">
                                    <div class="reply-time">
                                        {{ $ticketreply->user->name }}
                                    </div>
                                    <div class="reply-text" style="border-radius: 10px;">
                                    {!! $ticketreply->reply !!}
                                    @if($ticketreply->files != null && is_array(json_decode($ticketreply->files)))
                                    <br><br>
                                    <div>
                                        @foreach (json_decode($ticketreply->files) as $key => $file)
                                            <div>
                                                <a href="{{ asset($file->path) }}" download="{{ $file->name }}" class="support-file-attach bg-gray pad-all rounded">
                                                    <i class="fa fa-link mar-rgt"></i> {{ $file->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                    </div>
                                        
                                    <div class="reply-time">
                                        {{ date('h:i:m d-m-Y', strtotime($ticketreply->created_at)) }}
                                    </div>
                                </div>
                                <div class="reply-user-img">
                                                                                                                          @php
                                        $image = isset($ticketreply->user->avatar) ? $ticketreply->user->avatar : 'https://kooledge.com/assets/default_medium_avatar-57d58da4fc778fbd688dcbc4cbc47e14ac79839a9801187e42a796cbd6569847.png';
                                    @endphp
                                    <img src="{{ asset($image)}}" alt="">
                                </div>
                        </div>
                    
                    @endforeach
                    <div class="reply-wrapper">
                                <div class="replay-details">
                                    <div class="reply-time">
                                        {{ $ticket->user->name }}
                                    </div>
                                    <div class="reply-text" style="border-radius: 10px;"     >
                                    {!! $ticket->details !!}
                                    @if($ticket->files != null && is_array(json_decode($ticket->files)))
                                    <br><br>
                                    <div>
                                        @foreach (json_decode($ticket->files) as $key => $file)
                                            <div>
                                                <a href="{{ asset($file->path) }}" download="{{ $file->name }}" class="support-file-attach bg-gray pad-all rounded">
                                                    <i class="fa fa-link mar-rgt"></i> {{ $file->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                    </div>
                                        
                                    <div class="reply-time">
                                        {{ date('h:i:m d-m-Y', strtotime($ticket->created_at)) }}
                                    </div>
                                </div>
                                <div class="reply-user-img">
                                                                                                                                                              @php
                                        $image = isset($ticket->user->avatar) ? $ticket->user->avatar : 'https://kooledge.com/assets/default_medium_avatar-57d58da4fc778fbd688dcbc4cbc47e14ac79839a9801187e42a796cbd6569847.png';
                                    @endphp
                                    <img src="{{ asset($image)}}" alt="">
                                </div>
                        </div>
                </div>
            </div>

        </div>
        
        
        


        </div>
    </div>

    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );
</script>
@endsection
