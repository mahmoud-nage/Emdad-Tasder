<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use PDF;
use Auth;

class InvoiceController extends Controller
{
    //downloads customer invoice
    public function customer_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        // $pdf = PDF::setOptions([
        //                 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
        //                 'logOutputFile' => storage_path('logs/log.htm'),
        //                 'tempDir' => storage_path('logs/')
        //             ])->loadView('invoices.customer_invoice', compact('order'));
        // return $pdf->download('order-'.$order->code.'.pdf');
        
        return view('invoices.customer_invoice', compact('order'));
    }
    public function admin_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        // $pdf = PDF::setOptions([
        //                 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
        //                 'logOutputFile' => storage_path('logs/log.htm'),
        //                 'tempDir' => storage_path('logs/')
        //             ])->loadView('invoices.customer_invoice', compact('order'));
        // return $pdf->download('order-'.$order->code.'.pdf');
        
        return view('invoices.admin_invoice', compact('order'));
    }

    //downloads seller invoice
    public function seller_invoice_download($id)
    {
        $order = Order::findOrFail($id);
        // $pdf = PDF::setOptions([
        //                 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
        //                 'logOutputFile' => storage_path('logs/log.htm'),
        //                 'tempDir' => storage_path('logs/')
        //             ])->loadView('invoices.seller_invoice', compact('order'));
        // return $pdf->download('order-'.$order->code.'.pdf');
                return view('invoices.seller_invoice', compact('order'));
    }
}
