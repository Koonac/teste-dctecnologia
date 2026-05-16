<x-app-layout>
    <script>
        window.orderProducts = @json($products);
    </script>
    @vite(['resources/js/orders.js'])
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
                    <form action="{{ route('orders.store') }}" method="post">
                        <input type="hidden" name="products_json" id="products_json">
                        @csrf
                        <div>
                            <label for="name">Cliente</label>
                            <select name="client_id" id="client_id" class="w-full p-2 border border-gray-300 rounded-md">
                                <option value="" selected>Selecione...</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="product_id">Produto <span class="text-red-500">*</span></label>
                            <div class="flex gap-2">
                                <select id="product_id" class="w-full p-2 border border-gray-300 rounded-md" required>
                                    <option value="" selected>Selecione...</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" id="quantity" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Quantidade" required>
                                <input type="number" id="price" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Preço" required>
                                <button type="button" id="add_product_button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Adicionar</button>
                            </div>
                        </div>
                        <div>
                            <label for="payment_method">Forma de pagamento</label>
                            <div class="flex gap-2">
                                <select name="payment_method" id="payment_method" class="w-full p-2 border border-gray-300 rounded-md">
                                    <option value="" selected>Selecione...</option>
                                    <option value="cash">Dinheiro (à vista)</option>
                                    <option value="pix">Pix (à vista)</option>
                                    <option value="card">Cartão (à vista)</option>
                                    <option value="installment">Parcelado</option>
                                </select>
                                <input type="number" id="installment_count" class="w-22 p-2 border border-gray-300 rounded-md hidden" placeholder="Parcelas" required>
                                <button type="button" id="add_payment_button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Adicionar</button>
                            </div>
                        </div>
                        @if (session('error'))
                        <div class="text-red-500">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="flex w-full gap-2 mt-4">
                            <div class="w-full">
                                <h3 class="text-lg font-bold">Produtos</h3>
                                <div class="border border-gray-300 rounded-md p-2 w-full">
                                    <table class="w-full">
                                        <thead>
                                            <tr>
                                                <th class="text-left p-2">Produto</th>
                                                <th class="text-center p-2">Quantidade</th>
                                                <th class="text-right p-2">Preço</th>
                                                <th class="text-center p-2">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products_table" class="py-4 border-t border-gray-300">
                                            <tr>
                                                <td colspan="3" class="text-center text-gray-500 py-4">Nenhum produto adicionado</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="w-full">
                                <h3 class="text-lg font-bold">Pagamentos</h3>
                                <div class="border border-gray-300 rounded-md p-2 w-full">
                                    <table class="w-full">
                                        <thead>
                                            <tr>
                                                <th class="text-left p-2">Forma de pagamento</th>
                                                <th class="text-left p-2">Parcela</th>
                                                <th class="text-left p-2">Vencimento</th>
                                                <th class="text-right p-2">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody class="py-4 border-t border-gray-300">
                                            <tr>
                                                <td colspan="3" class="text-center text-gray-500 py-4">Nenhum produto adicionado</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-end justify-end gap-2 mt-4 border-t border-gray-300 pt-4">
                            <label for="total" class="text-lg font-bold">Total: </label>
                            <span id="total_order" class="text-lg font-bold">R$ 0,00</span>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Gerar Pedido</button>
                            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>