<?php

namespace App\Http\Controllers;

use App\AramexPickup;
use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipper;
use Illuminate\Http\Request;
use Octw\Aramex\Aramex;
use SoapClient;

class AramexShipmentController extends Controller
{
    private $ClientInfo;
    public function __construct()
    {
        $this->ClientInfo = array(
            'AccountCountryCode' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_COUNTRY_CODE')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_COUNTRY_CODE')->first()->value : '',
            'AccountEntity' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_ENTITY')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_ENTITY')->first()->value : '',
            'AccountNumber' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value : '',
            'AccountPin' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_BIN')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_BIN')->first()->value : '',
            'UserName' => isset(\App\BusinessSetting::where('type', 'ARAMEX_USER_NAME')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_USER_NAME')->first()->value : '',
            'Password' => isset(\App\BusinessSetting::where('type', 'ARAMEX_PASSWORD')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_PASSWORD')->first()->value : '',
            'Version' => isset(\App\BusinessSetting::where('type', 'ARAMEX_VERSION')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_VERSION')->first()->value : '',
        );
    }
    

    public function createPickup(Request $request)
    {
        $shipper = Shipper::first();
        $data = Aramex::createPickup([
            'name' => $shipper->name,
            'cell_phone' => $shipper->phone,
            'phone' => $shipper->phone2,
            'email' => $shipper->email ? $shipper->email : 'mw@gmail.com',
            'city' => $shipper->city->name_en,
            'country_code' => $shipper->country->code,
            'zip_code' => 10001,
            'line1' => $shipper->address,
            'line2' => $shipper->address2,
            "pickup_date" => time(), // time parameter describe the date of the pickup
            "ready_time" => time(), // time parameter describe the ready pickup date
            "last_pickup_time" => time(), // time parameter
            "closing_time" => time(), // time parameter
            'status' => 'Ready',
            'pickup_location' => $shipper->address,
            'weight' => 1,
            'volume' => 1,
        ]);
        if ($data->error) {
            return 0;
        } else {
            $order = Order::where('shipment_type', 2)->where('shipment_status', 0)->where('awb', '!=', 0)->first();
            $status = $order->statusShipment($order->id);
            $shipment_order_pending = Order::where('shipment_type', 2)->where('shipment_status', 0)->count();
            $record = AramexPickup::create(['pickupId' => $data->pickupID, 'pickupGUID' => $data->pickupGUID, 'shipment_count' => $shipment_order_pending, 'status' => $status]);
            if ($record) {
                Order::where('shipment_type', 2)->where('shipment_status', 0)->update(['shipment_status' => 1, 'pickup_id' => $data->pickupGUID]);
                flash(__('PickUp has been Creeated successfully'))->success();
            } else {
                flash(__('Something went wrong'))->error();
            }
            return back();
        }
    }

    public function aramex_pickups()
    {
        $records = AramexPickup::orderBy('id', 'desc')->get();
        $shipment_order_pending = Order::where('shipment_type', 2)->where('shipment_status', 0)->count();
        return view('pickups.index', compact('records', 'shipment_order_pending'));
    }

    public function cancelPickup($id)
    {
        $record = AramexPickup::find($id)->delete();
        if ($record) {
            flash(__('PickUp has been Creeated successfully'))->success();
        } else {
            flash(__('Something went wrong'))->error();
        }
        return back();
    }

    public function goToShipment($order_id, $type = 0)
    {

        $shipper = Shipper::first();
        $order = Order::find($order_id);
        $items_count = $order->orderDetails->sum('quantity');
        
            $currncy = $order->country->Currency->code;
            if (!$currncy) {
                $currncy = "EGP";
            }
            
        $products_description = "";
        $items = [];
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetaill = $orderDetail->with('product')->first();
            $options = isset($orderDetail->Variation) ? '( ' . $orderDetail->Variation->getChoice() . ' )' : '';
            $products_description .= $orderDetail->product['name_en'] . '' . $options;
            $items['Quantity'] = $orderDetail->quantity;
            $items['Comments'] = $orderDetail->product['name_en'] . '' . $options;
        }

        if($type) {
            $total_price_withShipping = 0;
        }else {
            if($currncy != "EGP"){
                $total_price_withShipping = $this->exchange($currncy, 'USD', $order->grand_total);
                    $currncy = "USD";
            }
            dd($currncy,$total_price_withShipping);
        }

        $user = $order->user;
        $shipping_address = (array) json_decode($order->shipping_address);
        $city = City::find($shipping_address['city']);

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        // $soapClient = new SoapClient('https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?singleWsdl');
        $soapClient = new SoapClient('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc?singleWsdl');

        $params = array(
            'Shipments' => array(
                'Shipment' => array(

                    'Shipper' => array(
                        'Reference1' => time(),
                        'Reference2' => '',
                        'AccountNumber' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value : '',
                        'PartyAddress' => array(
                            'Line1' => $shipper->address,
                            'Line2' => $shipper->address2,
                            'Line3' => '',
                            'City' => $shipper->city->name_en,
                            'StateOrProvinceCode' => '',
                            'PostCode' => '',
                            'CountryCode' => $shipper->country->code,
                        ),
                        'Contact' => array(
                            'Department' => '',
                            'PersonName' => $shipper->name,
                            'Title' => '',
                            'CompanyName' => 'Man & Women',
                            'PhoneNumber1' => $shipper->phone2,
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => $shipper->phone,
                            'EmailAddress' => $shipper->email ? $shipper->email : 'newface@gmail.com',
                            'Type' => '',
                        ),
                    ),

                    'Consignee' => array(
                        'Reference1' => time(),
                        'Reference2' => '',
                        'AccountNumber' => isset(\App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value) ? \App\BusinessSetting::where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value : '',
                        'PartyAddress' => array(
                            'Line1' => $shipping_address['address_details'],
                            'Line2' => '',
                            'Line3' => '',
                            'City' => $city->name_en,
                            'StateOrProvinceCode' => '',
                            'PostCode' => $shipping_address['postal_code'],
                            'CountryCode' => $city->country->code,
                        ),

                        'Contact' => array(
                            'Department' => '',
                            'PersonName' => $shipping_address['name'],
                            'Title' => '',
                            'CompanyName' => 'Man & Women',
                            'PhoneNumber1' => $shipping_address['phone'],
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => $shipping_address['phone'],
                            'EmailAddress' => $shipping_address['email'],
                            'Type' => '',
                        ),
                    ),

                    'Reference1' => time(),
                    'Reference2' => '',
                    'Reference3' => '',
                    'ForeignHAWB' => $order->code,
                    'TransportType' => 0,
                    'ShippingDateTime' => time(),
                    'DueDate' => time(),
                    'PickupLocation' => $shipper->address,
                    'PickupGUID' => '',
                    'Comments' => '',
                    'AccountingInstrcutions' => '',
                    'OperationsInstructions' => '',

                    'Details' => array(

                        'ActualWeight' => array(
                            'Value' => "0.5",
                            'Unit' => 'Kg',
                        ),

                        'ProductGroup' => 'EXP',
                        'ProductType' => 'PDX',
                        'PaymentType' => 'p',
                        'PaymentOptions' => '',
                        'Services' => 'CODS',
                        'NumberOfPieces' => $items_count,
                        'DescriptionOfGoods' => $products_description,
                        'GoodsOriginCountry' => $shipper->country->code,

                        'CashOnDeliveryAmount' => array(
                            'Value' => $total_price_withShipping,
                            'CurrencyCode' => $currncy,
                        ),

                        'InsuranceAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => $currncy,
                        ),

                        'CollectAmount' => array(
                            'Value' => $total_price_withShipping,
                            'CurrencyCode' => $currncy,
                        ),

                        'CashAdditionalAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => $currncy,
                        ),

                        'CashAdditionalAmountDescription' => '',

                        'CustomsValueAmount' => array(
                            'Value' => 0,
                            'CurrencyCode' => $currncy,
                        ),

                        'Items' => array(
                            $items,
                        ),
                    ),
                ),
            ),

            'ClientInfo' => $this->ClientInfo,

            'Transaction' => array(
                'Reference1' => time(),
                'Reference2' => '',
                'Reference3' => '',
                'Reference4' => '',
                'Reference5' => '',
            ),
            'LabelInfo' => array(
                'ReportID' => 9201,
                'ReportType' => 'URL',
            ),
        );

        $params['Shipments']['Shipment']['Details']['Items'][] = array(
            'PackageType' => 'Box',
            'Quantity' => $items_count,
            'Weight' => array(
                'Value' => 0.5,
                'Unit' => 'Kg',
            ),
            'Comments' => $products_description,
            'Reference' => '',
        );

        try {
            $auth_call = $soapClient->CreateShipments($params);
            if ($auth_call->HasErrors) {
                return $auth_call;
            } else {
                $order->awb = $auth_call->Shipments->ProcessedShipment->ID;
                $order->ref_number = $auth_call->Shipments->ProcessedShipment->Reference1;
                $order->aramex_invoice_url = $auth_call->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
                $order->shipment_type = 2;
                $order->save();
                return 1;
            }
        } catch (SoapFault $fault) {
            return 0;
            die('Error : ' . $fault->faultstring);
        }
    }

    public function calculateRate($order_id)
    {
        $shipper = Shipper::first();
        $order = Order::find($order_id);
        $shipping_address = (array) json_decode($order->shipping_address);
        $city = City::find($shipping_address['city']);
        $items_count = $order->orderDetails->sum('quantity');

        $params = array(
            'ClientInfo' => $this->ClientInfo,

            'Transaction' => array(
                'Reference1' => time(),
            ),

            'OriginAddress' => array(
                'City' => $shipper->city->name_en,
                'CountryCode' => $shipper->city->country->code,
            ),

            'DestinationAddress' => array(
                'City' => $city->name_en,
                'CountryCode' => $city->country->code,
            ),
            'ShipmentDetails' => array(
                'PaymentType' => 'P',
                'ProductGroup' => 'EXP',
                'ProductType' => 'PPX',
                'ActualWeight' => array('Value' => 0.5, 'Unit' => 'KG'),
                'ChargeableWeight' => array('Value' => 0.5, 'Unit' => 'KG'),
                'NumberOfPieces' => $items_count,
            ),
        );
        $soapClient = new SoapClient(asset('rate.xml'));
        $results = $soapClient->CalculateRate($params);
        return $results;
    }

    public function trackShipments($shipment)
    {
        // $soapClient = new SoapClient('http://ws.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc?singleWsdl');
        $soapClient = new SoapClient('https://ws.dev.aramex.net/ShippingAPI.V2/Tracking/Service_1_0.svc?singleWsdl');

        $params = array(
            'ClientInfo' => $this->ClientInfo,

            'Transaction' => array(
                'Reference1' => time(),
            ),
            'Shipments' => array(
                $shipment,
            ),
        );

        // calling the method and printing results
        try {
                $auth_call = $soapClient->TrackShipments($params);
            if ($auth_call->HasErrors) {
                return $auth_call;
            } else {
                // dd($auth_call);
                return $auth_call->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
            }

        } catch (SoapFault $fault) {
            die('Error : ' . $fault->faultstring);
        }

    }

    public function fetchCountries()
    {
        $data = Aramex::fetchCountries();
        if (!$data->error) {
            dd($data);
        } else {
            dd('something went error');
        }
    }

    public function fetchCountry($countryCode)
    {
        $data = Aramex::fetchCountries($countryCode);
        if (!$data->error) {
            dd($data);
        } else {
            dd('something went error');
        }
    }

    public function fetchCities($countryCode = 'EG')
    {
        $country = Country::where('code', $countryCode )->first();
        $data = Aramex::fetchCities($countryCode);
        if (!$data->HasErrors) {
            foreach ($data->Cities->string as $city) {
                // return $city;
                $new_city = new City();
                $new_city->name_en = $city;
                $new_city->name_ar = $city;
                $new_city->country_id = $country->id;
                $new_city->type = 1;
                $new_city->save();
            }
            return 1;
        } else {
            // handle error
            return 0;
        }
    }

    public function validateAddress()
    {
        $data = Aramex::validateAddress([
            'line_1' => 'Test', // optional (Passing it is recommended)
            'line_2' => 'Test', // optional
            'line_3' => 'Test', // optional
            'country_code' => 'JO',
            'postal_code' => '', // optional
            'city' => 'Amman',
        ]);

        if (!$data->error) {
            // Code Here
            dd($data);
        } else {
            // handle error
            dd('something went error');
        }
    }
    
        public function exchange($from, $to = 'EGP', $amount)
    {
        // set API Endpoint, access key, required parameters
        $access_key = 'b52147bd8fe8a9706304';
        // initialize CURL:
        $ch = curl_init('https://free.currconv.com/api/v7/convert?compact=ultra&apiKey=' . $access_key . '&q=' . $from . '_' . $to . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $conversionResult = json_decode($json, true);

        // access the conversion result
        return $conversionResult['' . $from . '_' . $to] * $amount;
    }
    

}
