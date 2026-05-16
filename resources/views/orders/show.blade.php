<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('orders.index') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedido
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex gap-4">
                        <div>
                            <label for="created_at" class="font-bold">Criado em</label>
                            <h3 id="created_at" class="text-lg text-gray-600">{{ $order->created_at->format('d/m/Y H:i:s') }}</h3>
                        </div>
                        <div>
                            <label for="client_name" class="font-bold">Cliente</label>
                            <h3 id="client_name" class="text-lg text-gray-600">{{ $order->client ? $order->client->name : 'Não informado' }}</h3>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-4 mt-4">
                        <div>
                            <label for="status" class="font-bold">Status</label>
                            <h3 id="status" class="text-lg text-gray-600 text-{{ $order->status == 'paid' ? 'green-500' : 'red-500' }} font-bold">{{ $order->status_label }}</h3>
                        </div>
                        <div>
                            <label for="payment_method" class="font-bold">Forma de pagamento</label>
                            <h3 id="payment_method" class="text-lg text-gray-600">{{ $order->payment_method_label }}</h3>
                        </div>
                        <div>
                            <label for="total" class="font-bold">Total</label>
                            <h3 id="total" class="text-lg text-gray-600">R$ {{ number_format($order->total, 2, ',', '.') }} {{ $order->payment_method == 'installment' ? 'em ' . $order->installment_count . 'x' : '' }}</h3>
                        </div>
                    </div>
                    @if (session('error'))
                    <div class="text-red-500">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="w-full mt-4">
                        <h3 class="text-lg font-bold">Produtos</h3>
                        <div class="border border-gray-300 rounded-md p-2 w-full">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left p-2">Produto</th>
                                        <th class="text-center p-2">Quantidade</th>
                                        <th class="text-right p-2">Preço Un.</th>
                                        <th class="text-right p-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="py-4 border-t border-gray-300">
                                    @foreach ($order->products as $product)
                                    <tr>
                                        <td class="text-left p-2">{{ $product->product->name }}</td>
                                        <td class="text-center p-2">{{ $product->quantity }}</td>
                                        <td class="text-right p-2">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                        <td class="text-right p-2">R$ {{ number_format($product->total, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-full mt-4">
                        <h3 class="text-lg font-bold">Pagamentos</h3>
                        <div class="border border-gray-300 rounded-md p-2 w-full">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-center p-2" width="1%">Parcela</th>
                                        <th class="text-center p-2">Vencimento</th>
                                        <th class="text-center p-2">Pagamento</th>
                                        <th class="text-right p-2">Valor</th>
                                        <th class="text-center p-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="payments_table" class="py-4 border-t border-gray-300">
                                    @foreach ($order->payments as $index => $payment)
                                    <tr>
                                        <td class="text-center p-2">{{ $index + 1 }}</td>
                                        <td class="text-center p-2">{{ $payment->due_date->format('d/m/Y') }}</td>
                                        <td class="text-center p-2 text-{{ $payment->payment_date ? 'green-500' : 'red-500' }} font-bold">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'Não pago' }}</td>
                                        <td class="text-right p-2">R$ {{ number_format($payment->value, 2, ',', '.') }}</td>
                                        <td class="text-center p-2">
                                            @if ($payment->status == 'pending')
                                            <form action="{{ route('payments.pay', $payment->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                                                        <path d="M0 0h16v16H0z" fill="none" />
                                                        <path fill="currentColor" d="M7 2H5a3.5 3.5 0 1 0 0 7h2v3H2.5v2H7v2h2v-2h2a3.5 3.5 0 1 0 0-7H9V4h4.5V2H9V0H7zm2 7h2a1.5 1.5 0 0 1 0 3H9zM7 7H5a1.5 1.5 0 1 1 0-3h2z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700">Voltar</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>