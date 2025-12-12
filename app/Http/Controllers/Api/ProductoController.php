<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductoRepository;
use Exception;

class ProductoController extends Controller
{
    protected $repo;

    public function __construct(ProductoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return $this->repo->obtenerTodos();
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:255',
            'descripcion' => 'required',
            'stock' => 'required|integer',
            'precio' => 'required|numeric',
            'iva' => 'required|numeric'
        ]);

        $this->repo->guardar($request->all());

        return response()->json([
            'estado' => 1,
            'mensaje' => 'Producto almacenado correctamente'
        ], 201);
    }

    public function show($id)
    {
        $producto = $this->repo->obtenerPorId($id);

        if (!$producto) {
            return response()->json([
                'estado' => 0,
                'mensaje' => "Producto no encontrado con ID: $id"
            ], 404);
        }

        return $producto;
    }

    public function update(Request $request, $id)
    {
        $filas = $this->repo->actualizar($id, $request->all());

        if ($filas === 0) {
            return response()->json([
                'estado' => 0,
                'mensaje' => "No se encontró el producto con ID $id para actualizar"
            ], 404);
        }

        return response()->json([
            'estado' => 1,
            'mensaje' => 'Producto actualizado exitosamente'
        ]);
    }

    public function destroy($id)
    {
        try {
            $filas = $this->repo->eliminar($id);

            if ($filas === 0) {
                throw new Exception("El producto con ID $id no existe.");
            }

            return response()->json([
                'estado'  => 1,
                'mensaje' => 'Producto eliminado exitosamente'
            ]);
        }
        catch (Exception $e) {

            if (str_contains($e->getMessage(), 'no existe')) {
                return response()->json([
                    'estado'  => 0,
                    'mensaje' => $e->getMessage()
                ], 404);
            }

            return response()->json([
                'estado'  => 0,
                'mensaje' => 'Error al intentar eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}
