<?php

namespace App;
use Alhoqbani\SmsaWebService\Smsa;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\SmsaShipmentController;
use App\Http\Controllers\AramexShipmentController;

class Order extends Model
{
    protected $fillable = ['user_id' , 'guest_id' ,'affiliate_id' , 'coupon_affiliate_id' ,
        'shipping_address' , 'payment_type' , 'payment_status' , 'payment_details' , 'status_id' ,
        'grand_total' , 'coupon_discount' ,'affiliate_id' , 'coupon_url_id' , 'code' , 'date' ,
        'viewed', 'payment_request','ref_number','awb','pickup_id','shipment_status', 'country_id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class)->with('product');
    }

    public function status()
    {
        return $this->belongsTo(Status::class,'status_id','id');
    }
        
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function CouponUrl()
    {
        return $this->belongsTo(CouponUrl::class,"coupon_url_id");
    }
    
    public function addresses()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    
    public function statusShipment($order_id){
        $order = Order::find($order_id);
        
        if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->statusShipment($order->awb); // cancel shipment also if allowed
                
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2 && $order->awb){
                $aramex_shipment = new AramexShipmentController;
                $shipment = (array) $aramex_shipment->trackShipments($order->awb); // cancel shipment also if allowed
                if($shipment)
                {
                    // $record = AramexPickup::where('pickupGUID', $order->pickup_id)->update(['status' => $shipment->UpdateDescription]);
                    // dump($shipment);
                    if(count($shipment) > 0){
                        $status = isset($shipment[count($shipment)-1]->UpdateDescription)?$shipment[count($shipment)-1]->UpdateDescription:'';
                        return $status;
                    }
                   
                }
                else
                    return '';
                    
            }
     }  
     public function trackShipment($order_id){
        $order = Order::find($order_id);
        
        if(\App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1){ // check smsa activation
                $smsa_shipment = new SmsaShipmentController;
                $shipment = $smsa_shipment->trackShipment($order->awb, $order->ref_number); // print shipment also if allowed
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2){
                $aramex_shipment = new AramexShipmentController;
                $shipment = $aramex_shipment->trackShipment($order->awb); // print shipment also if allowed
                if($shipment)
                    return $shipment;
                else
                    return '';
                    
            }
     } 
     
}
