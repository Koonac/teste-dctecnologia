<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:2000',
                'price' => 'required|numeric|min:0',
            ]);

            $product = Product::create([
                ...$request->all(),
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('products.index')->with('success', 'Produto criado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('products.create')->with('error', 'Erro ao criar produto: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'price' => 'required|numeric|min:0',
            ]);
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('products.index')->with('error', 'Produto não encontrado');
            }
            $product->update($request->all());
            return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Erro ao atualizar produto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('products.index')->with('error', 'Produto não encontrado');
            }
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Produto deletado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Erro ao deletar produto');
        }
    }
}
