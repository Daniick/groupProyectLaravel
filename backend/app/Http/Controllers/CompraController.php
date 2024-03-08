<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = Compra::with('proveedore', 'productos')->get();
        return response()->json($compras, 200);
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
            'num_factura' => 'nullable|string',
            'proveedore_id' => 'required|exists:proveedores,id',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $compra = Compra::create([
            'num_factura' => $request->num_factura,
            'proveedore_id' => $request->proveedore_id,
        ]);

        foreach ($request->productos as $producto) {
            $compra->productos()->attach($producto['producto_id'], [
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario']
            ]);
        }

        return response()->json($compra, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        // Carga las relaciones necesarias
        $compra->load('proveedore', 'productos');

        // Retorna el resultado en formato JSON
        return response()->json($compra, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        $request->validate([
            'num_factura' => 'nullable|string',
            'proveedore_id' => 'required|exists:proveedores,id',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $compra->update(['num_factura' => $request->num_factura]);
        $compra->update(['proveedore_id' => $request->proveedore_id]);

        $productosNuevos = collect($request->productos);

        $compra->productos()->detach();
        foreach ($productosNuevos as $producto) {
            $compra->productos()->attach($producto['producto_id'], [
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario']
            ]);
        }

        return response()->json($compra, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        $compra->productos()->detach();
        $compra->delete();
        return response()->json(null, 204);
    }
}
