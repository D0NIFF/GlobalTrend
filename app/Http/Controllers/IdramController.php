<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IdramController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $amount = $request->input('amount');
        $orderId = uniqid();
        
        // ������ �������� ������� � API Idram
        $response = Http::post('https://gateway.idram.am/payment/rest/register.do', [
            'userName' => env('IDRAM_MERCHANT_ID'),
            'password' => env('IDRAM_SECRET_KEY'),
            'orderNumber' => $orderId,
            'amount' => $amount * 100, // ����� � ��������
            'returnUrl' => route('payment.success'),
            'failUrl' => route('payment.fail')
        ]);

        if ($response->successful()) {
            $paymentUrl = $response->json()['formUrl'];
            return redirect($paymentUrl);
        } else {
            return redirect()->route('payment.fail');
        }
    }

    public function getPaymentStatus(Request $request)
    {
        Log::info('Payment status callback received', $request->all());


        // ��������� ������ �������
        $orderId = $request->input('orderId');
        $status = $request->input('status');
        
        // ������ ��������� ������� �������
        if ($status == 'success') {
            // �������� ������ ������ � ���� ������
foreach($request->all() as $k=>$v){
$m.="$k=$v|";
}
file_put_contents("t.txt",$m);

            Log::info('Payment successful for order: ' . $orderId);
        } else {
            // ��������� ���������� �������
            Log::error('Payment failed for order: ' . $orderId);
        }

        return 'OK';
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }

    public function paymentFail()
    {
        return view('payment.fail');
    }

    public function paymentResults()
    {
        return view('payment.results');
    }
}
