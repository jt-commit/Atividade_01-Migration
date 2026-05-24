<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    // Exibe uma lista de Publishers
    public function index()
    {
        $publishers = Publisher::all();

        return view('publisher.index', compact('publishers'));
    }

    // Mostra o formulário para criar uma nova Publisher
    public function create()
    {
        return view('publisher.create');
    }

    // Armazena uma nova Publisher no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:publishers|max:255',
        ]);

        Publisher::create($request->all());

        return redirect()
            ->route('publishers.index')
            ->with('success', 'Publisher criada com sucesso.');
    }

    // Exibe uma Publisher específica
    public function show(Publisher $publisher)
    {
        return view('publisher.show', compact('publisher'));
    }

    // Mostra o formulário para editar uma Publisher existente
    public function edit(Publisher $publisher)
    {
        return view('publisher.edit', compact('publisher'));
    }

    // Atualiza uma Publisher no banco de dados
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|unique:publishers,name,' . $publisher->id . '|max:255',
        ]);

        $publisher->update($request->all());

        return redirect()
            ->route('publishers.index')
            ->with('success', 'Publisher atualizada com sucesso.');
    }

    // Remove uma Publisher do banco de dados
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()
            ->route('publishers.index')
            ->with('success', 'Publisher excluída com sucesso.');
    }
}