@extends('layouts.app')

@section('content')

    <div id="affiliates" class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Users') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('avatar')}}</th>
                        <th>{{__('Country')}}</th>
                        <th>{{__('phone')}}</th>
                        <th>{{__('Address')}}</th>
                        <th>{{__('Approved')}}</th>
                        <th>{{__('blocked')}}</th>
                        <th>{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="affiliate, index  in affiliates">
                        <td>@{{ affiliate.id }}</td>
                        <td>@{{ affiliate.user.name }}</td>
                        <td><img :src="affiliate.avatar ? base_url+affiliate.avatar : ''" style="width: 50px;"></td>
                        <td>@{{ affiliate.user.country }}</td>
                        <td>@{{ affiliate.user.phone }}</td>
                        <td>@{{ affiliate.user.address }}</td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" @change="update(affiliate.id,'approve')"
                                       :checked="affiliate.is_approved == 1">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td><label class="switch">
                                <input type="checkbox" @change="update(affiliate.id,'block')"
                                       :checked="affiliate.is_blocked == 1">
                                <span class="slider round"></span></label>
                        </td>
                        <td nowrap="">
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                        data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" @click="create_payment(affiliate.id)">{{__('Create Payment')}}</a>
                                    </li>
                                    <!--<li><a href="#" @click="destroy(affiliate.id,index)">{{__('Delete')}}</a></li>-->
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-lg-4 m-b-30 text-center" v-if="Object.keys(affiliates).length > 0">
                <ul class="pagination">
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous"
                           v-on:click.prevent="changePage(pagination.first_page)">
                            First
                        </a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page > 1">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous"
                           v-on:click.prevent="changePage(pagination.current_page - 1)">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="page in pages"
                        :class="{'active': page == pagination.current_page}">
                        <a class="page-link" href="javascript:void(0)" v-on:click.prevent="changePage(page)">@{{
                            page }}</a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next"
                           v-on:click.prevent="changePage(pagination.current_page + 1)">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous"
                           v-on:click.prevent="changePage(pagination.last_page)">
                            Last
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('affiliates.payments.store') }}" v-if="selected_affiliate">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="affiliate_id" :value="selected_affiliate.id">
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Amount *</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="number" class="form-control" name="amount" min="1" accept="any" placeholder="Amount" required>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">egyptian mail</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="radio" name="payment_method" value="egyptian_mail" required>
                                        egyptian mail
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Full name</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('full_name') is-invalid @enderror"
                                               name="full_name" :value="selected_affiliate.full_name"
                                               placeholder="Full name" disabled>
                                    </div>
                                    @error('full_name')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">SSN</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('SSN') is-invalid @enderror"
                                               maxlength="14"
                                               name="SSN" :value="selected_affiliate.SSN"
                                               placeholder="SSN" disabled>
                                    </div>
                                    @error('name_en')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">bank account</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="radio" name="payment_method" value="bank_account" required> bank
                                        account
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Bank name</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('bank_name') is-invalid @enderror"
                                               maxlength="14"
                                               name="bank_name" :value="selected_affiliate.bank_name"
                                               placeholder="bank_name" disabled>
                                    </div>
                                    @error('bank_name')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Bank account username</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('bank_account_username') is-invalid @enderror"
                                               maxlength="14"
                                               name="bank_account_username"
                                               :value="selected_affiliate.bank_account_username"
                                               placeholder="Bank account username " disabled>
                                    </div>
                                    @error('bank_account_username')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <br/>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Bank account number</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('bank_account_number') is-invalid @enderror"
                                               maxlength="14"
                                               name="bank_account_number"
                                               :value="selected_affiliate.bank_account_number"
                                               placeholder="bank name" disabled>
                                    </div>
                                    @error('bank_account_number')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        new Vue({
            el: "#affiliates",
            data: {
                affiliates: {},
                pagination: {},
                countries: {},
                categories: {},
                status: '',
                name: '',
                country: '0',
                is_blocked: 0,
                is_approved: 0,
                category: '0',
                current_page_url: '',
                pages: '',
                selected_affiliate: '',
                user: '{!! auth()->check() ? auth()->user() : null !!}',
                user_id: '{!! auth()->check() ? auth()->user()->id : null !!}',
                last_page: '',
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
            mounted() {
                this.getAffiliates();
            },
            methods: {
                filterSearch(id) {
                    return this.affiliates.filter(id => id);
                },
                isCurrentPage(page) {
                    return this.pagination.current_page === page;
                },
                changePage(page) {
                    let requestUrl = '';
                    this.paginationPages();
                    if (page > this.pagination.last_page) {
                        page = this.pagination.last_page;
                    }
                    this.pagination.current_page = page;
                    this.getAffiliates(page);
                },
                getAffiliates: function (page) {
                    $(".preloader").show();
                    let current_page_url;
                    $.ajax({
                        url: "{!! route('api.affiliates') !!}" + '?page=' + page,
                        type: 'GET',
                        data: {name: this.name},
                        complete: function () {
                            current_page_url = this.url;
                        },
                    }).then((response) => {
                        $(".preloader").hide();
                        this.current_page_url = current_page_url;
                        this.affiliates = response.data.data;
                        this.pagination = response.data;
                        this.countries = response.countries;
                        this.categories = response.categories;
                        this.paginationPages(this.pagination.current_page, this.pagination.last_page);
                    })
                },
                create_payment: function (affiliate) {
                    $.ajax({
                        url: "{!! url('/api/admin/affiliates/') !!}" + '/' + affiliate,
                        type: 'GET',
                    }).then((response) => {
                        this.selected_affiliate = response.data;
                        $("#payment").modal('show');
                    })
                },
                paginationPages(current, last) {
                    let allPages = [];
                    let from = current;
                    let to = from + 5;
                    if (from < 1) {
                        from = 1;
                    }
                    if (to > last) {
                        to = last;
                    }
                    while (from <= to) {
                        allPages.push(from);
                        from++;
                    }
                    this.pages = allPages;
                },
                update: function (id, type) {
                    if (type == 'block') {
                        this.is_blocked = 1
                    } else {
                        this.is_approved = 1
                    }
                    $.ajax({
                        url: "{!! url('/api/admin/affiliates/update/') !!}" + '/' + id,
                        type: 'POST',
                        data: {
                            is_approved: this.is_approved,
                            is_blocked: this.is_blocked,
                            _token:'{!! @csrf_token() !!}'
                        },
                    }).then((response) => {
                        toastr.info(response.message);
                        this.is_approved = 0;
                        this.is_blocked = 0;
                        this.getAffiliates();
                    })
                },
                destroy: function (id, index) {
                    if (confirm('Do you really want to delete this item?')) {
                        $.ajax({
                            url: "{!! url('/api/admin/affiliates/') !!}" + '/' + id,
                            type: 'POST',
                        }).then((response) => {
                            toastr.info(response.message);
                            this.$delete(this.products, index);
                        })
                    }
                },
            },
        })
        ;
    </script>
@stop
