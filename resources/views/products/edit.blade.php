<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('products.index') }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Produto
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.update', $product->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div>
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $product->name }}">
                        </div>
                        <div>
                            <label for="description">Descrição</label>
                            <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md">{{ $product->description }}</textarea>
                        </div>
                        <div>
                            <label for="price">Preço</label>
                            <input type="number" name="price" id="price" class="w-full p-2 border border-gray-300 rounded-md" value="{{ $product->price }}" step="0.01">
                        </div>
                        @if (session('error'))
                        <div class="text-red-500">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="flex items-center gap-2 mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Salvar</button>
                            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>