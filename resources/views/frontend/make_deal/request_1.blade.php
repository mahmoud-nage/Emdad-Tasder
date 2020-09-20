@extends('frontend.layouts.app')
@section('title' , __('general.make_deal') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.make_deal')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <!-- Content -->
    <div class="container">
        <!--   Stepper   -->
        <div class="order-stepper">
            <div class="stepper">
                <ul class="step-wrapper">
                    <li class="active">
                        <span data-text="Profile">1</span>
                    </li>
                    <li class="">
                        <span data-text="Request for Quotation">2</span>
                    </li>
                    <li class="">
                        <span data-text="Publish">3</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="block-wrapper">
            <div class="block-header">
                Please Fill all fields in English
            </div>
            <div class="block-body">
                <form action="" class="form-style">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Account <span class="text-danger">*</span></span>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Option one
                                </label>
                            </div>
                            <div class="checkbox ">
                                <label>
                                    <input type="checkbox" value="" checked>
                                    Option two
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">First name <span class="text-danger">*</span></span>
                            <input type="text" class="form-control" placeholder="First name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Email</span>
                            <input type="email" class="form-control" placeholder="Email address">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Country <span class="text-danger">*</span></span>
                            <select id="address-country" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">City <span class="text-danger">*</span></span>
                            <input type="text" class="form-control" placeholder="City" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Area <span class="text-danger">*</span></span>
                            <input type="text" class="form-control" placeholder="Area" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">phone <span class="text-danger">*</span></span>
                            <input id="phone" type="tel" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group margin-top-50 text-right">
                        <a href="#CompanyData"  class="btn btn-second" id="showCompanyData">Next</a>
                    </div>
                </form>

                <div class="company-data" id="CompanyData">
                    <div class="form-title">company data</div>
                    <form action="" class="form-style">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Company Name<span class="text-danger">*</span></span>
                                <input type="text" class="form-control" placeholder="Company Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Account <span class="text-danger">*</span></span>
                                <div class="row">
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 1
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 2
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 3
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 4
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 5
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 6
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Company contact information</span>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="">
                                        The contact information is the same as my personal information
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Contact person</span>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Company country</span>
                                <select id="address-country2" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <div class="input-group">
                                <span class="input-group-addon">Company Phone</span>
                                <select id="phone2" class="form-control"></select>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Company governorate</span>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Company city</span>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Sector<span class="text-danger">*</span></span>
                                <select name="" class="form-control" required>
                                    <option value="" selected disabled>Select Sector</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Email</span>
                                <input type="email" class="form-control" placeholder="Email address">
                            </div>
                        </div>
                        <div class="form-group margin-top-50 text-right">
                            <a href="#factsNumbers" class="btn btn-second" id="showFactsNumbers">Next</a>
                        </div>
                    </form>
                </div>

                <div class="facts-numbers" id="factsNumbers">
                    <div class="form-title">facts and Numbers</div>
                    <form action="" class="form-style">

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Account <span class="text-danger">*</span></span>
                                <div class="row">
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 1
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 2
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 3
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 4
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 5
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                Option 6
                                            </label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">company establishment date<span class="text-danger">*</span></span>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Employees number<span class="text-danger">*</span></span>
                                <input type="number" class="form-control" placeholder="number of employees" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Capital<span class="text-danger">*</span></span>
                                <select name="" class="form-control" required>
                                    <option value="" selected disabled>Select Capital</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">The legal name of the company<span class="text-danger">*</span></span>
                                <select name="" class="form-control" required>
                                    <option value="" selected disabled>Select The legal name</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Sales volume<span class="text-danger">*</span></span>
                                <select name="" class="form-control" required>
                                    <option value="" selected disabled>Select Sales volume</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Export ratio<span class="text-danger">*</span></span>
                                <select name="" class="form-control" required>
                                    <option value="" selected disabled>Select Export ratio</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group margin-top-50 text-right">
                            <a href="make-deal-2.html" class="btn btn-second">Next</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- Footer -->
@endsection
