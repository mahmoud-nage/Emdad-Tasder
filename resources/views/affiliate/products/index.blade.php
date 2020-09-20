@extends('affiliate.layouts.app')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="products">


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
                            Products
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Cover</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->subcategory->name }}</td>
                                <td><img src="{{ asset($product->thumbnail_img) }}" style="width: 50px;"></td>
                                <td nowrap="">
                                    <button class="btn btn-primary" data-toggle="modal"
                                            data-target="#urlModal{{ $product->id }}" data-dismiss="modal">Generate URL
                                    </button>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                    <!--end: Search Form -->
                </div>
                {{ $products->links() }}
            </div>
        </div>
        @foreach($products as $key => $product)

            <div class="modal fade" id="urlModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('affiliate.urls.store') }}" method="POST"
                              class="form-url" enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Create URL</h4>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="type" value="product">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tag ID1 <span
                                                        class="color-second">*</span></label>
                                                <input type="text" name="tag1" v-model="tag1"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tag ID2 <span
                                                        class="color-second">*</span></label>
                                                <input type="text" name="tag2" v-model="tag2"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tag ID3 <span
                                                        class="color-second">*</span></label>
                                                <input type="text" name="tag3" v-model="tag3"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tag ID4 <span
                                                        class="color-second">*</span></label>
                                                <input type="text" name="tag4" v-model="tag4"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Tag ID5 <span
                                                        class="color-second">*</span></label>
                                                <input type="text" name="tag5" v-model="tag5"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>URL <span class="color-second">*</span></label>
                                        <textarea name="url" class="form-control" rows="10">
                                                            {!! route('product' , $product->slug).'?aff='.encrypt($affiliate->id).'&cc-p='.encrypt($affiliate->Coupon->id) !!}@{{ '&u_as=' + tag1 + '|' + tag2 + '|' + this.tag3 + '|' + tag4 + '|' + tag5 }}</textarea>
                                    </div>

                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">generate</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endforeach

    <!-- end:: Content -->
    </div>
@stop
@section('script')

    <script>
        var x = 1;
        var home = new Vue({
            el: "#products",
            data: {
                products: {},
                sub_categories: {},
                keyword: '',
                type: '',
                general_url: '',
                result_url: '',
                tag1: '',
                tag2: '',
                tag3: '',
                tag4: '',
                tag5: '',
                category: '',
                sub_category: '',
                lang: '',
                country: '',
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
            methods: {
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
                    this.getProducts(page);
                },
                copy: function (index) {
                    var copyText = document.getElementById("url" + index);
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    document.execCommand("copy");
                },
                getCategories: function () {
                    $.ajax({
                        url: "{!! route('api.categories.web') !!}",
                        type: 'GET',
                        data: {
                            locale: '{{ \App::getLocale() }}',
                        },
                    }).then((response) => {
                        this.categories = response.data;
                        this.getSubCategories(this.categories[0].id);
                    });
                },
                getProducts: function (page) {
                    if (this.country && this.category && this.sub_category && this.keyword) {
                        $(".preloader").show();
                        let current_page_url;
                        $.ajax({
                            url: "{!! route('api.affiliate.products') !!}" + '?page=' + page,
                            type: 'GET',
                            data: {
                                affiliate_id: '{!! auth()->user()->Affiliate->id !!}',
                                keyword: this.keyword,
                                lang: this.lang,
                                country: this.country,
                                category: this.category,
                                sub_category: this.sub_category,
                            },
                            complete: function () {
                                current_page_url = this.url;
                            },
                        }).then((response) => {
                            $(".preloader").hide();
                            this.current_page_url = current_page_url;
                            this.products = response.data.data;
                            this.pagination = response.data;
                            this.paginationPages(this.pagination.current_page, this.pagination.last_page);
                        });
                        return;
                    }
                    alert('fill all fields');
                },
                getURL: function () {
                    if (this.general_url) {
                        if (this.general_url.match(/^[^\/]*[\/]{0,2}[^\/]*newfaceeg.com.*$/)) {
                            this.result_url = this.general_url + '?aff=' + '{!! encrypt($affiliate->id).'&cc-p='.encrypt($affiliate->Coupon->id) !!}' +
                                '&u_as=' + this.tag1 + '|' + this.tag2 + '|' + this.tag3 + '|' + this.tag4 + '|' + this.tag5
                        }
                        alert('wrong url');
                        return;
                    }
                    alert('fill all fields');
                },
                getSubCategories: function () {
                    $.ajax({
                        url: "{!! route('api.affiliate.sub_categories') !!}",
                        type: 'GET',
                        data: {
                            locale: '{{ \App::getLocale() }}',
                            category: this.category,
                        },
                    }).then((response) => {
                        this.sub_categories = response.data;
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
            },
        });
    </script>


@stop
