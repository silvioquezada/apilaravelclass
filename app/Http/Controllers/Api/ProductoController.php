<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    
    public function index()
    {
        return Producto::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|numeric',
            'precio' => 'required|numeric',
            'iva' => 'required|numeric'
        ]);

        Producto::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio' => $request->precio,
            'iva' => $request->iva
        ]);

        return response()->json([
            'estado' => 1,
            'mensaje' => "Producto almacenado correctamente"
        ], 201);
    }

    public function show(string $id)
    {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $producto->codigo = $request->codigo;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->iva = $request->iva;

        $producto->save();

        return response()->json([
            'estado'  => 1,
            'mensaje' => 'Producto actualizado exitosamente'
        ], 200);
    }

    public function destroy($id)
    {
        Producto::destroy($id);
        return response()->json(null, 204);
    }
}
