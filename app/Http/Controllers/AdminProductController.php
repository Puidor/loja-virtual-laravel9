<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

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
    public function update(Request $request, Product $product)
    {
        
        $input = $request->validate([
            'name' => 'required|max:255',
            'description' => 'string|nullable',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            // 'cover' => 'file|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover' => 'file|nullable',
        ]);

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
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|max:255',
            'description' => 'string|nullable',
            'price' => 'string|required',
            'stock' => 'integer|nullable',
            // 'cover' => 'file|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover' => 'file|nullable',
        ], [
            'name.required' => 'O nome do produto é obrigatório',
            'name.max' => 'O nome do produto deve ter no máximo 255 caracteres',
            'price.required' => 'O preço do produto é obrigatório',
            'stock.integer' => 'O estoque do produto deve ser um número',
            'cover.file' => 'O arquivo deve ser uma imagem',
            'cover.max' => 'A imagem deve ter no máximo 2MB',
        ]);

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
