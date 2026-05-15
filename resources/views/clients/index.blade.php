<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cliente
            </h2>
            <a href="{{ route('clients.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Novo Cliente</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left px-4" width="100%">Nome</th>
                                <th class="text-left px-4" width="1%">Email</th>
                                <th class="text-left px-4" width="1%">Telefone</th>
                                <th class="text-center px-4" width="1%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($models->count() > 0)
                            @else
                            <tr>
                                <td colspan="4" class="text-center px-4 py-2">Nenhum cliente encontrado</td>
                            </tr>
                            @endif
                            @foreach ($models as $model)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $model->name }}</td>
                                <td class="px-4 py-2">{{ $model->email }}</td>
                                <td class="px-4 py-2">{{ $model->phone }}</td>
                                <td class="flex items-center justify-center gap-2 text-center px-4 py-2">
                                    <a href="{{ route('clients.edit', $model->id) }}" class="text-blue-500 px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-700">Editar</a>
                                    <form action="{{ route('clients.destroy', $model->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white px-2 py-1 bg-red-500 rounded-md hover:bg-red-700">
                                            Deletar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>