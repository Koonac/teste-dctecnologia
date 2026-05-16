<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('orders.create') }}" class="flex items-center justify-center text-center gap-2 shadow-sm rounded-lg p-4 bg-gray-800 text-white hover:bg-gray-700 transition ease-in-out duration-150 h-40">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                    <path d="M0 0h24v24H0z" fill="none" />
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="14" height="17" x="5" y="4" rx="2" />
                        <path stroke-linecap="round" d="M9 9h6m-6 4h6m-6 4h4" />
                    </g>
                </svg>
                <span class="text-2xl font-bold">Gerar Pedido</span>
            </a>

            <div class="grid grid-cols-3 gap-4 mt-4">
                <a href="{{ route('orders.index') }}" class="flex items-center justify-center text-center gap-2 shadow-sm rounded-lg p-4 bg-gray-800 text-white hover:bg-gray-700 transition ease-in-out duration-150 h-40">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="14" height="17" x="5" y="4" rx="2" />
                            <path stroke-linecap="round" d="M9 9h6m-6 4h6m-6 4h4" />
                        </g>
                    </svg>
                    <span class="text-2xl font-bold">Pedidos</span>
                </a>
                <a href="{{ route('clients.index') }}" class="flex items-center justify-center text-center gap-2 shadow-sm rounded-lg p-4 bg-gray-800 text-white hover:bg-gray-700 transition ease-in-out duration-150 h-40">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path fill="currentColor" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3s1.34 3 3 3m-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5S5 6.34 5 8s1.34 3 3 3m0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5m8 0c-.29 0-.62.02-.97.05c1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5" />
                    </svg>
                    <span class="text-2xl font-bold">Clientes</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center justify-center text-center gap-2 shadow-sm rounded-lg p-4 bg-gray-800 text-white hover:bg-gray-700 transition ease-in-out duration-150 h-40">
                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 512 512">
                        <path d="M0 0h512v512H0z" fill="none" />
                        <path fill="currentColor" fill-rule="evenodd" d="m256 34.347l192 110.851v221.703L256 477.752L64 366.901V145.198zm-64.001 206.918L192 391.536l42.667 24.635V265.899zM106.667 192v150.267l42.666 24.635V216.633zm233.324-59.894l-125.578 72.836L256 228.952l125.867-72.669zM256 83.614l-125.867 72.67l41.662 24.052l125.579-72.835z" />
                    </svg>

                    <span class="text-2xl font-bold">Produtos</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>