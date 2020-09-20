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
                    <li class="active">
                        <span data-text="Request for Quotation">2</span>
                    </li>
                    <li class="">
                        <span data-text="Publish">3</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="block-wrapper">
            <div class="block-body">
                <form action="" class="form-style">
                    <div class="form-title">Order information</div>
                    <div class="form-group">
                        <label>Product classification <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <select name="" class="form-control select-classification" id="selectClassification1" size="7" required>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                    <option value="">6</option>
                                    <option value="">7</option>
                                    <option value="">8</option>
                                    <option value="">9</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <select name="" class="form-control select-classification" id="selectClassification2" size="7" required>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                    <option value="">6</option>
                                    <option value="">7</option>
                                    <option value="">8</option>
                                    <option value="">9</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <select name="" class="form-control select-classification" id="selectClassification3" size="7" required>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                    <option value="">3</option>
                                    <option value="">4</option>
                                    <option value="">5</option>
                                    <option value="">6</option>
                                    <option value="">7</option>
                                    <option value="">8</option>
                                    <option value="">9</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group margin-20 text-center">
                        <button type="submit" class="btn btn-second">Ok</button>
                        <button type="reset" class="btn btn-default">Cancel</button>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label>Product Name / Service (English)></label>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Product Details (English)</label>
                                <textarea class="form-control" name="" rows="4" placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label>Product Name / Service (Arabic) </label>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Product Details (Arabic)</label>
                                <textarea class="form-control" name="" rows="4" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Image</span>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Required quantity</span>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 margin-10">
                                    <input type="number" class="form-control" placeholder="Required quantity">
                                </div>
                                <div class="col-xs-12 col-sm-4 margin-10">
                                    <select class="form-control">
                                        <option value="" selected disabled>Unit</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Available opportunity</span>
                            <div class="row">
                                <div class="col-xs-12 col-md-5">
                                    <input type="date" class="form-control" placeholder="From">
                                </div>
                                <div class="col-xs-12 col-md-2 margin-10 text-center">
                                    To
                                </div>
                                <div class="col-xs-12 col-md-5">
                                    <input type="date" class="form-control" placeholder="To">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Deadline for submitting offer</span>
                            <input type="date" class="form-control" placeholder="From">
                        </div>
                    </div>
                    <div class="form-title">Trade data</div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Preferably the supplier from</span>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">I will order the quantity every day</span>
                            <select name="" class="form-control">
                                <option value="" selected disabled>Please Select</option>
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Annual purchase volume</span>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 margin-10">
                                    <input type="number" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-12 col-sm-4 margin-10">
                                    <select class="form-control">
                                        <option value="" selected disabled>Unit</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">The best would be the price</span>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 margin-10">
                                    <input type="number" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-12 col-sm-4 margin-10">
                                    <select class="form-control">
                                        <option value="" selected disabled>Currency</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">payment methods <span class="text-danger">*</span></span>
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
                            <span class="input-group-addon">Port Access</span>
                            <input type="text" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <a href="confirm.html" class="btn btn-success" >Skip</a>
                        <a href="make-deal.html" class="btn btn-default" >Previous</a>
                        <a href="confirm.html" class="btn btn-second" >Next</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- Footer -->
@endsection
