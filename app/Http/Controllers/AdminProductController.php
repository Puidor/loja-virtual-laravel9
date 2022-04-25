<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ProductStoreRequest;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    //Mostrar a página de Editar
    public function edit(Product $product)
    {
        return view('admin.product_edit', compact('product'));
    }

    //Recebe a requisição do formulário de edição (PUT)
    public function update(ProductStoreRequest $request, Product $product)
    {
        
        $input = $request->validated();

        if(!empty($input['cover']) && $input['cover']->isValid()){
            Storage::delete($product->cover ?? '');
            $file = $input['cover'];
            $path = $file->store('public');
            $input['cover'] = $path;
        }

        $product->fill($input);
        $product->save();

        return redirect()->route('admin.products');
    }

    //Mostrar a página de Criar
    public function create()
    {
        return view('admin.product_create');
    }

    //Recebe a requisição do formulário de criação (POST)
    public function store(ProductStoreRequest $request)
    {
        $input = $request->validated();

        $input['slug'] = Str::slug($input['name']);

        if(!empty($input['cover']) && $input['cover']->isValid()){
            $file = $input['cover'];
            $path = $file->store('public');
            $input['cover'] = $path;
        }

        Product::create($input);

        return redirect()->route('admin.products');
    }

    //Deletar um produto
    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete($product->cover ?? '');
        return redirect()->route('admin.products');
    }

    public function destroyImage(Product $product){
        Storage::delete($product->cover);
        $product->cover = null;
        $product->save();

        return redirect()->back();
    }

}
