@extends('affiliate.layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="ticket">
                <div class="kt-chat">
                    <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
                        <div class="kt-portlet__head">
                            <div class="kt-chat__head ">
                                <div class="kt-chat__left">

                                    <!--begin:: Aside Mobile Toggle -->


                                    <!--end:: Aside Mobile Toggle-->
                                    <div class="dropdown dropdown-inline">
                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="flaticon-more-1"></i>
                                        </button>
                                        <div
                                            class="dropdown-menu dropdown-menu-fit dropdown-menu-left dropdown-menu-md">

                                            <!--begin::Nav-->
                                            <ul class="kt-nav">
                                                <li class="kt-nav__item">
                                                    <a href="javascript:void(0)" class="kt-nav__link"
                                                       onclick="$('#status_form').submit()">
                                                        <i class="kt-nav__link-icon flaticon2-group"></i>
                                                        <span class="kt-nav__link-text">{{ $ticket->status == 'opened' ? 'Close' : 'Open' }} Ticket</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <!--end::Nav-->
                                        </div>
                                        <span class="btn {{ $ticket->status == 'opened' ? 'btn-info' : 'btn-danger' }}">{{ $ticket->status }}</span>
                                    </div>
                                </div>
                                <div class="kt-chat__center">
                                    <div class="kt-chat__label">
                                        <a href="#" class="kt-chat__title">{{ $ticket->user->name }}</a>
                                    </div>
                                    <div class="kt-chat__pic kt-hidden">
															<span class="kt-media kt-media--sm kt-media--circle"
                                                                  data-toggle="kt-tooltip" data-placement="right"
                                                                  title="Jason Muller"
                                                                  data-original-title="Tooltip title">
																<img src="assets/media/users/300_12.jpg" alt="image">
															</span>
                                        <span class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip"
                                              data-placement="right" title="Nick Bold"
                                              data-original-title="Tooltip title">
																<img src="assets/media/users/300_11.jpg" alt="image">
															</span>
                                        <span class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip"
                                              data-placement="right" title="Milano Esco"
                                              data-original-title="Tooltip title">
																<img src="assets/media/users/100_14.jpg" alt="image">
															</span>
                                        <span class="kt-media kt-media--sm kt-media--circle" data-toggle="kt-tooltip"
                                              data-placement="right" title="Teresa Fox"
                                              data-original-title="Tooltip title">
																<img src="assets/media/users/100_4.jpg" alt="image">
															</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
                                <div class="kt-chat__messages" v-if="Object.keys(messages).length > 0">
                                    <div v-for="message,index in messages" class="kt-chat__message"
                                         v-bind:class="{'kt-chat__message--right' : message.user.user_type == 'affiliate'}">
                                        <div class="kt-chat__user">
                                            <span class="kt-chat__datetime">@{{ message.created_at }}</span>
                                            <a href="#" class="kt-chat__username"><span>@{{ message.user.name }}</span></a>
                                            <span class="kt-media kt-media--circle kt-media--sm">
                                                <img
                                                    :src="message.user.image ? base_url+ message.user.avatar : base_url +'/assets/affiliate/media/users/default.jpg'"
                                                    alt="image">
                                            </span>
                                        </div>
                                        <div class="kt-chat__text kt-bg-light-brand">
                                            @{{ message.body }}
                                            <br/>
                                            <a v-if="message.attachment" :href="base_url+message.attachment"
                                               target="_blank">
                                                <img :src="base_url+message.attachment" width="200px">
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($ticket->status == 'opened')
                            <div class="kt-portlet__foot">
                                <div class="kt-chat__input">
                                    <div class="kt-chat__editor">
                                    <textarea style="height: 50px" v-model="body" @keyup.enter="storeMessages"
                                              placeholder="Type here..."></textarea>
                                    </div>
                                    <div class="kt-chat__toolbar">
                                        <div class="kt_chat__actions">
                                            <button type="button"
                                                    class="btn btn-brand btn-md btn-upper btn-bold kt-chat__reply"
                                                    @click="storeMessages">reply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
@section('script')
    <script>
        vm = new Vue({
            el: "#ticket",
            data() {
                return {
                    messages: {},
                    body: '',
                    conversations: {},
                    users: {},
                    play: false,
                    selectedConversation: '',
                    selectedUsername: '',
                    selectedUserId: '',
                    name: '',
                    seen: '',
                    chatBox: '',
                    user: '{!! auth()->check() ? auth()->user() : null !!}',
                    user_id: '{!! auth()->check() ? auth()->user()->id : null !!}',
                    base_url: "{!! url('/') !!}",
                    url: "{!! request()->url() !!}",
                    items: []
                };
            },
            mounted() {
                this.getMessages();
            },
            methods: {
                getMessages: function () {
                    $.ajax({
                        url: "{!! route('api.affiliate.messages') !!}",
                        type: 'GET',
                        data: {ticket_id: '{!! $ticket->id !!}'},
                    }).then((response) => {
                        this.messages = response.data.reverse();
                    })
                },
                storeMessages: function () {
                    if (this.body.charAt(0) !== "\n") {
                        var body = this.body;
                        this.body = '';
                        $.ajax({
                            url: "{!! route('api.affiliate.messages.store') !!}",
                            type: 'POST',
                            data: {
                                ticket_id: '{!! $ticket->id !!}',
                                user_id: '{!! auth()->user()->id !!}',
                                'body': body
                            },
                        }).then((response) => {
                            this.messages.push(response.data);
                        });
                    }

                },
            },
        });
    </script>


@stop
