<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = Categoria::all();
        return response()->json($categoria, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string'
        ]);

        $categoria = Categoria::create($request->all());
        return response()->json($categoria, 201);
    }

    /**
     * Display the specified resource.
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json(['Categoria:' => $categoria], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *  @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string'
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all());
        return response()->json(['message' => 'Datos del Trabajador actualizado correctamente', 'Trabajador: ' => $categoria], 201);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
{
    $categoria = Categoria::findOrFail($id);

    $categoria->delete();

    return response()->json(['message' => 'Categoría eliminada correctamente'], 200);
}

}
