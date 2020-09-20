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
                            Create URLs
                        </h3>
                    </div>

                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-md-3">
                            <label translate="" class="ng-scope">Select Type</label>
                            <select id="country_select" name="categories" v-model="type"
                                    class="form-control kt-bootstrap-select"
                                    style="">
                                <option value="" selected>Select</option>
                                <option value="products">Products</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <!--begin: Search Form -->
                    <div class="form-body" v-if="type == 'products'">

                        <div class="row">
                            <div class="col-md-3">
                                <label translate="" class="ng-scope">Country store</label>
                                <select id="country_select" name="categories" v-model="country"
                                        class="form-control kt-bootstrap-select"
                                        style="">
                                    <option value="" selected>Select</option>
                                    @foreach(\App\Country::all() as $country)
                                        <option value="{{ $country->id }}">{{ $country->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label translate="" class="ng-scope">Language</label>
                                <select name="language" v-model="lang" class="form-control kt-bootstrap-select"
                                        style="">
                                    <option value="" selected>Select</option>
                                    <option value="ar" translate="" class="ng-scope">Arabic</option>
                                    <option value="en" translate="" class="ng-scope">English</option>
                                </select>

                            </div>
                            <div class="col-md-3">
                                <label>Category</label>
                                <select id="category_select" name="cid" v-model="category"
                                        class="form-control kt-bootstrap-select"
                                        @change="getSubCategories" style="">
                                    <option value="" class="" selected="selected">Select</option>
                                    @foreach(\App\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name_en }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Sub Category</label>
                                <select id="sub_category_select" v-model="sub_category"
                                        class="form-control kt-bootstrap-select"
                                        style="">
                                    <option value="" class="" selected="selected">Select</option>
                                    <option v-for="sub_category in sub_categories" :value="sub_category.id">@{{
                                        sub_category.name_en }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label translate="" class="ng-scope">Keyword</label>
                                <input type="text" class="form-control" v-model="keyword"
                                       placeholder="Example: iPhone 6">
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Tag ID1 </label>
                                    <input type="text" name="tag1" v-model="tag1"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tag ID2 </label>
                                    <input type="text" name="tag2" v-model="tag2"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tag ID3 </label>
                                    <input type="text" name="tag3" v-model="tag3"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tag ID4 </label>
                                    <input type="text" name="tag4" v-model="tag4"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tag ID5 </label>
                                    <input type="text" name="tag5" v-model="tag5"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br/>
                                <input id="submit_button" type="button" value="Display" class="btn btn-primary"
                                       @click="getProducts()">
                            </div>
                        </div>

                        <!--end: Search Form -->
                        <br/>
                        <hr>
                        <section v-if="Object.keys(products).length > 0">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>name</th>
                                        <th>price</th>
                                        <th>URL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product, index  in products">
                                        <td><img :src="base_url+'/'+product.image" width="100"></td>
                                        <td>@{{ product.name }}</td>
                                        <td>@{{ product.price }}</td>
                                        <td class="verticalAlign">
                                            <form action="{{ route('affiliate.urls.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="product">
                                                <input type="hidden" name="tag1" v-model="tag1">
                                                <input type="hidden" name="tag2" v-model="tag2">
                                                <input type="hidden" name="tag3" v-model="tag3">
                                                <input type="hidden" name="tag4" v-model="tag4">
                                                <input type="hidden" name="tag5" v-model="tag5">
                                                <div class="codeArea"><textarea :id="'url'+index" onclick="this.focus();this.select()" rows="5" cols="40" name="url" class="form-control">@{{ product.url }}</textarea>
                                                </div>
                                                <div><input type="button" value="Copy to clipboard" class="btn btn-info" @click="copy(index)"></div>
                                                <div><input type="submit" value="Generate" class="btn btn-primary"></div>
                                                <div class="rowSep show-for-small-only"></div>
                                            </form>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-4 m-b-30 text-center" v-if="Object.keys(products).length > 0">
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
                                            <a class="page-link" href="javascript:void(0)"
                                               v-on:click.prevent="changePage(page)">@{{
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
                        </section>
                        <section class="text-center" v-else>
                            <h3>No Result</h3>
                        </section>
                    </div>
                    <div class="form-body" v-if="type == 'other'">
                        <div class="row">
                            <div class="col-md-3">
                                <label translate="" class="ng-scope">Add any newfaceeg.com URL</label>
                                <input type="url" name="original" v-model="general_url"
                                       placeholder="Example: http://newfaceeg.com" class="form-control" style="">
                            </div>

                        </div>
                        <br/>
                        <div class="row">
                            <label>Apply Tag IDs for tracking</label>

                        </div>
                        <div class="row">
                            <br/>
                            <div class="col-md-2">
                                <label>Tag ID 1</label>

                                <input type="text" name="original" v-model="tag1" class="form-control" style="">
                            </div>
                            <div class="col-md-2">
                                <label>Tag ID 2</label>

                                <input type="text" name="original" v-model="tag2" class="form-control" style="">
                            </div>
                            <div class="col-md-2">
                                <label>Tag ID 3</label>

                                <input type="text" name="original" v-model="tag3" class="form-control" style="">
                            </div>
                            <div class="col-md-2">
                                <label>Tag ID 4</label>

                                <input type="text" name="original" v-model="tag4" class="form-control" style="">
                            </div>

                            <div class="col-md-2">
                                <label>Tag ID 5</label>
                                <input type="text" name="original" v-model="tag5" class="form-control" style="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br/>
                                <input type="button" value="Display" class="btn btn-primary" @click="getURL()">
                            </div>
                        </div>
                        <!--end: Search Form -->
                        <br/>
                        <hr>
                        <section v-if="Object.keys(products).length > 0">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>name</th>
                                        <th>price</th>
                                        <th>URL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product, index  in products">
                                        <td><img :src="base_url+'/'+product.image" width="100"></td>
                                        <td>@{{ product.name }}</td>
                                        <td>@{{ product.price }}</td>
                                        <td class="verticalAlign">
                                            <div class="codeArea">
                                <textarea :id="'url'+index" onclick="this.focus();this.select()" rows="5" cols="40"
                                          name=""
                                          class="form-control">
                                    @{{ product.url }}
                                </textarea>
                                            </div>
                                            <div><input type="button" value="Copy to clipboard" class="btn btn-primary"
                                                        @click="copy(index)"></div>
                                            <div class="rowSep show-for-small-only"></div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="col-lg-4 m-b-30 text-center" v-if="Object.keys(products).length > 0">
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
                                            <a class="page-link" href="javascript:void(0)"
                                               v-on:click.prevent="changePage(page)">@{{
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
                        </section>
                        <section v-else-if="result_url">
                            <div class="row">
                                <label>URL</label>
                                <textarea class="form-control" v-model="result_url"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <br/>
                                    <input type="button" value="Save" class="btn btn-primary" @click="save()">
                                </div>
                            </div>
                        </section>
                        <section class="text-center" v-else>
                            <h3>No Result</h3>
                        </section>
                    </div>
                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>



@stop
@section('script')

    <script>
        var x = 1;
        var home = new Vue({
            el: "#urls",
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
                                tag1: this.tag1,
                                tag2: this.tag2,
                                tag3: this.tag3,
                                tag4: this.tag4,
                                tag5: this.tag5,
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
                            this.result_url = this.general_url+ '?aff='+ '{!! encrypt($affiliate->id).'&cc-p='.encrypt($affiliate->Coupon->id) !!}'+
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

