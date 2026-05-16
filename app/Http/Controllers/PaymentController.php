<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentOrder;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function pay(Request $request, string $id)
    {
        $payment = PaymentOrder::find($id);
        if (!$payment) {
            return redirect()->back()->with('error', 'Pagamento não encontrado');
        }
        $payment->payment_date = now();
        $payment->status = 'paid';
        $payment->save();

        $paymentPending = PaymentOrder::where('order_id', $payment->order_id)->where('status', 'pending')->count();
        if ($paymentPending == 0) {
            $order = Order::find($payment->order_id);
            $order->status = 'paid';
            $order->save();
        }

        return redirect()->back()->with('success', 'Pagamento realizado com sucesso');
    }
}
