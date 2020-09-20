@extends('affiliate.layouts.app')

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="urls">


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
                            URLs
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">

                            <div class="dropdown dropdown-inline">
                                <a href="{{ route('affiliate.urls.create') }}" class="btn btn-brand btn-icon-sm">
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
                            <th>#</th>
                            <th>Type</th>
                            <th>Visits</th>
                            <th>Tag1</th>
                            <th>Tag2</th>
                            <th>Tag3</th>
                            <th>Tag4</th>
                            <th>Tag5</th>
                            <th>Orders pend</th>
                            <th>orders rejected</th>
                            <th>orders complete</th>
                            <th>CTR</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="url, index  in urls">
                            <td>@{{ index+1 }}</td>
                            <td>@{{ url.type }}</td>
                            <td>@{{ url.visits }}</td>
                            <td>@{{ url.tag1 }}</td>
                            <td>@{{ url.tag2 }}</td>
                            <td>@{{ url.tag3 }}</td>
                            <td>@{{ url.tag4 }}</td>
                            <td>@{{ url.tag5 }}</td>
                            <td>@{{ url.orders_pend }}</td>
                            <td>@{{ url.orders_rejected }}</td>
                            <td>@{{ url.orders_complete }}</td>
                            <td v-if='(url.orders_pend + url.orders_complete )>0'>
                                @{{url.visits/( url.orders_pend + url.orders_complete)}}
                            </td>
                            <td v-else>0</td>
                            <td>
                                <button type="button" class="btn btn-success" @click="openUrl(url.url)">URL</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="urlModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label>URL</label>
                                <textarea name="url" class="form-control" rows="10" v-model="url"
                                          onclick="this.focus();this.select()"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@stop
@section('script')

    <script>
        var x = 1;
        var home = new Vue({
            el: "#urls",
            data: {
                urls: {},
                url: {},
                query: $(location).attr('search'),
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
            mounted() {
                this.getUrls();
            },
            methods: {
                openUrl(url) {
                    this.url = url;
                    $('#urlModal').modal('show');
                    return;
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
                    this.getUrls(page);
                },
                getUrls: function () {
                    $.ajax({
                        url: "{!! route('api.affiliate.urls') !!}",
                        type: 'GET',
                        data: {
                            locale: '{{ \App::getLocale() }}',
                            affiliate_id: '{{ auth()->user()->Affiliate->id }}',
                        },
                    }).then((response) => {
                        this.urls = response.data;
                        this.getSubCategories(this.categories[0].id);
                    });
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
            },
        });
    </script>


@stop
