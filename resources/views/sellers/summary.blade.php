<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body text-center dash-widget dash-widget-left">
                <div class="dash-widget-vertical">
                    <div class="rorate">Payment</div>
                </div>
                <div class="pad-ver mar-top text-main">
                    <i class="fa fa-money" style="font-size: 30px" aria-hidden="true"></i>
                </div>
                <div class="col-md-4">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Available Balance</p>
                         @php
                                    $total_pendding = 0;
                                    $total_available = 0;
                                    $total = 0;
                                    $total_withdrawal = isset($seller->user->seller_payments)?$seller->user->seller_payments->where('status',2)->sum('amount'):0;
        
                                                $orderDetails = DB::table('order_details')
                                                ->orderBy('id', 'desc')
                                                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                                                ->where('orders.payment_request', 0)
                                                ->where('order_details.seller_id', $seller->user_id)
                                                ->where('order_details.delivery_status','delivered')
                                                ->select('order_details.id')
                                                ->get();

                                        
                                        if($orderDetails != null){
                                        foreach($orderDetails as $orderDetail_id){
                                        
                                        $orderDetail = \App\OrderDetail::find($orderDetail_id->id);
                                        if(strtotime("+".$general_setting->withdrawal_duration." day", strtotime($orderDetail->created_at)) >= strtotime(now())){
                                        
                                            $total_pendding += $orderDetail->price - $orderDetail->commission;   
                                            
                                        }elseif(strtotime("+".$general_setting->withdrawal_duration." day", strtotime($orderDetail->created_at)) <= strtotime(now())){
                                            $total_available += $orderDetail->price - $orderDetail->commission;  
                                        }
                                        
                                        $total += $orderDetail->price - $orderDetail->commission; 
                                        }
                                        }
                                    @endphp
                        <p class="text-semibold text-3x text-main">{{ $total_available }}</p>
                    </div>
                     <br>
                </div>
                <div class="col-md-4">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Pending Balance</p>
                        <p class="text-semibold text-3x text-main">{{ $total_pendding }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Withdrawn Balance</p>
                        <p class="text-semibold text-3x text-main">{{ $total_withdrawal }}</p>
                    </div>
                </div>
                   <div class="col-md-12">
                    <a href="#data" onclick="get_seller_payments({{$seller->user_id}})" class="btn btn-primary mar-top">Show Payments <i class="fa fa-long-arrow-right"></i></a>
                </div>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-body text-center dash-widget dash-widget-left">
                <div class="dash-widget-vertical">
                    <div class="rorate">PRODUCTS</div>
                </div>
                <div class="pad-ver mar-top text-main">
                    <i class="demo-pli-data-settings icon-4x"></i>
                </div>
                <br>
                <p class="text-lg text-main">Total seller's products: <span class="text-bold">{{ \App\Product::where('user_id', $seller->user_id)->get()->count() }}</span></p>
                <p class="text-lg text-main">Total seller's published products: <span class="text-bold">{{ \App\Product::where('published', 1)->where('user_id', $seller->user_id)->get()->count() }}</span></p>
                <p class="text-lg text-main">Total seller's Featured products: <span class="text-bold">{{ \App\Product::where('featured', 1)->where('user_id', $seller->user_id)->get()->count() }}</span></p>
                <p class="text-lg text-main">Total seller's Flash Deals products: <span class="text-bold">{{ \App\Product::where('todays_deal', 1)->where('user_id', $seller->user_id)->get()->count() }}</span></p>
                <br>
                <br>
                <a href="#data" onclick="get_seller_products({{$seller->user_id}})" class="btn btn-primary mar-top">Show Products <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-body text-center dash-widget dash-widget-left">
                <div class="dash-widget-vertical">
                    <div class="rorate">Orders</div>
                </div>
                <div class="pad-ver mar-top text-main">
                    <i class="demo-pli-data-settings icon-4x"></i>
                </div>
                <br>
                <p class="text-lg text-main">Total Ordered Pendding: <span class="text-bold">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->where('delivery_status', 'pendding')->get()) }}</span></p>
                <p class="text-lg text-main">Total Ordered Delivered: <span class="text-bold">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->where('delivery_status', 'delivered')->get()) }}</span></p>
                <p class="text-lg text-main">Total Ordered Canceled: <span class="text-bold">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->where('delivery_status', 'canceled')->get()) }}</span></p>
                <br>
                <p class="text-lg text-bold text-main">Total Ordered: <span class="text-bold">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->get()) }}</span></p>
                <br>
                <a href="#data" onclick="get_seller_orders({{$seller->user_id}})" class="btn btn-primary mar-top">Show Orders <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total Categories</p>
                        <p class="text-semibold text-3x text-main">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->where('delivery_status', 'delivered')->get()) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="pad-top text-center dash-widget">
                        <p class="text-normal text-main">Total Brands</p>
                        <p class="text-semibold text-3x text-main">{{ count(\App\OrderDetail::where('seller_id', $seller->user_id)->where('delivery_status', 'pendding')->get()) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>