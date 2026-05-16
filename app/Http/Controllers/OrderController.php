<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('client')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $clients = Client::all();
        return view('orders.create', compact('products', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'client_id' => 'nullable|exists:clients,id',
                'products_json' => 'required|json',
                'payments_json' => 'required|json',
            ]);

            $productsOrders = json_decode($request->products_json, true);
            $paymentsOrder = json_decode($request->payments_json, true);
            $paymentMethod = $paymentsOrder[0]['paymentMethod'];
            $installmentCount = count($paymentsOrder);
            $total = 0;
            $totalPayments = 0;

            foreach ($productsOrders as $product) {
                $total += round($product['price'] * $product['quantity'], 2);
            }

            foreach ($paymentsOrder as $payment) {
                $totalPayments += round($payment['value'], 2);
            }


            if (round($total, 2) != round($totalPayments, 2)) {
                return redirect()->route('orders.create')->with('error', 'Erro ao criar pedido: O total dos pagamentos não corresponde ao total do pedido');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'client_id' => empty($request->client_id) ? null : $request->client_id,
                'total' => $total,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'installment_count' => $installmentCount,
            ]);

            foreach ($productsOrders as $product) {
                $order->products()->create([
                    'product_id' => $product['productId'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['price'] * $product['quantity'],
                ]);
            }

            foreach ($paymentsOrder as $payment) {
                $order->payments()->create([
                    'client_id' => empty($request->client_id) ? null : $request->client_id,
                    'value' => $payment['value'],
                    'due_date' => $payment['dueDate'],
                    'payment_date' => null,
                ]);
            }

            return redirect()->route('orders.index')->with('success', 'Pedido criado com sucesso');
        } catch (\Exception $e) {
            if (isset($order)) {
                $order->delete();
            }
            return redirect()->route('orders.create')->with('error', 'Erro ao criar pedido: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('client', 'products', 'payments')->find($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pedido deletado com sucesso');
    }
}
