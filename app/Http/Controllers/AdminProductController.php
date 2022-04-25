<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    //Mostrar a página de Editar
    public function edit()
    {
        return view('admin.product_edit');
    }

    //Recebe a requisição do formulário de edição (PUT)
    public function update()
    {

    }

    //Mostrar a página de Criar
    public function create()
    {
        return view('admin.product_create');
    }

    //Recebe a requisição do formulário de criação (POST)
    public function store()
    {

    }
}
