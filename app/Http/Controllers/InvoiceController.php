<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Dormitory;
use App\Models\AdditionalRate;
use App\Models\BankAccount;
use App\Models\Bill;
use PDF;
use Farzai\PromptPay\Generator;
use Illuminate\Support\Facades\Auth;



class InvoiceController extends Controller
{
    public function index()
    {  
        
        $user_id = Auth::id();

        $invoices = Invoice::join('tenants', 'invoices.tenant_id', '=', 'tenants.id')
                ->where('invoices.is_published', '1')
                ->where('tenants.user_id', $user_id)
                ->select('invoices.*')
                ->paginate(5); 

        $dorms = Dormitory::all();

        return view('invoice.index',compact('invoices', 'dorms'));
    }

    public function invoice_detail($id)
    {
        $invoice = Invoice::find($id);
        $additionals = AdditionalRate::where('invoice_id', $id)->get();

        $total_additional = 0;
        foreach ($additionals as $additional) {
            $total_additional += $additional->additional_rate;
        }
    
        $dorms = Dormitory::all();


        return view('invoice.detail', compact('invoice','additionals' ,'dorms'));
    }

    public function generatePDF($id)
    {
        $dormitory = Dormitory::first();
        $invoice = Invoice::find($id);
        $additionals = AdditionalRate::where('invoice_id', $id)->get();
        $total_additional = 0;
        foreach ($additionals as $additional) {
            $total_additional += $additional->additional_rate;
        }
    

        $data = [
            'dormitory' => $dormitory,
            'title' => 'Invoice',
            'date' => date('m/d/Y'),
            'invoice' => $invoice,
            'additionals' => $additionals,
            'amount' => $invoice->total_amount,
        ]; 
            
        $pdf = PDF::loadView('invoice.pdf', $data);
        
        return $pdf->download('invoice.pdf');
    }

    public function form_payment($id)
    {
        $invoice_detail = $this->invoice_detail($id);

        $invoice = Invoice::find($id);
        $bank = BankAccount::where('bank_name', 'PP')->first();
        $promtpay = $bank->account_no;
        $promtpay = substr_replace($bank->account_no, '-', 3, 0);
        $promtpay = substr_replace($promtpay, '-', 7, 0);
        
        $generator = new Generator();
        $qrCode = $generator->generate(
            target: $promtpay, 
            amount: $invoice->total_amount,
        );

        $qrCodeimg = public_path('images/qrcode/qrcode_' . $invoice->invoice_ref . '.png');
        $qrCode->save($qrCodeimg);

        return view('invoice.form_payment', compact('invoice','bank', 'qrCodeimg'));
    }

    public function payment_invoice(Request $request, $id)
    {
        $invoice_detail = $this->invoice_detail($id);

        $invoice = Invoice::find($id);
        $invoice->status = '1';
        $invoice->save();

        $bill = new Bill();
        $bill->invoice_id = $invoice->id;
        $bill->amount = $invoice->total_amount;
        $slipName = 'slip_' . $invoice->invoice_ref . '.png';
        $slipPath = $request->file('slip')->storeAs('/public/images/slip', $slipName);
        $bill->slip = 'images/slip/' . $slipName;

        $bill->invoice_receipt_ref = $invoice->ref;
        $bill->save();

        return redirect()->back()->with('success', 'Payment Successfully');

    }
}
