<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients',
                'phone' => 'required|string|max:255',
            ]);

            $client = Client::create($request->all());
            return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('clients.create')->with('error', 'Erro ao criar cliente: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::find($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'required|string|max:255',
            ]);
            $client = Client::find($id);
            if (!$client) {
                return redirect()->route('clients.index')->with('error', 'Cliente não encontrado');
            }
            $client->update($request->all());
            return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Erro ao atualizar cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client = Client::find($id);
            if (!$client) {
                return redirect()->route('clients.index')->with('error', 'Cliente não encontrado');
            }
            $client->delete();
            return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'Erro ao deletar cliente');
        }
    }
}
