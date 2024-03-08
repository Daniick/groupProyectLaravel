<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return response()->json($productos, 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'string',
            'cod' => 'string',
            'precio' => 'numeric|min:0',
            'marca' => 'string',
            'id_categoria' => 'numeric',
            'costo' =>  'numeric|min:0',
            'cantidad' => 'numeric|min:0',

        ]);

        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'string',
            'cod' => 'string',
            'precio' => 'numeric|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'marca' => 'string',
            'id_categoria' => 'numeric',
            'costo' =>  'numeric|min:0',
            'cantidad' => 'numeric|min:0',

        ]);

        $producto->update($request->all());
        return response()->json($producto, 200);
    }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  \App\Models\Producto  $producto
//      * @return \Illuminate\Http\Response
//      */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return response()->json(null, 204);
    }
}
