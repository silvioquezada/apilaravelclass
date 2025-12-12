<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductoRepository
{
    public function obtenerTodos()
    {
        return DB::select('SELECT * FROM productos');
    }

    public function guardar($data)
    {
        $now = Carbon::now();

        return DB::insert(
            'INSERT INTO productos (codigo, descripcion, stock, precio, iva, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
            [
                $data['codigo'],
                $data['descripcion'],
                $data['stock'],
                $data['precio'],
                $data['iva'],
                $now,
                $now
            ]
        );
    }

    public function obtenerPorId($id)
    {
        $producto = DB::select('SELECT * FROM productos WHERE id = ?', [$id]);
        return $producto ? $producto[0] : null;
    }

    public function actualizar($id, $data)
    {
        return DB::update(
            'UPDATE productos SET codigo = ?, descripcion = ?, stock = ?, precio = ?, iva = ?, updated_at = ? WHERE id = ?',
            [
                $data['codigo'],
                $data['descripcion'],
                $data['stock'],
                $data['precio'],
                $data['iva'],
                Carbon::now(),
                $id
            ]
        );
    }

    public function eliminar($id)
    {
        return DB::delete('DELETE FROM productos WHERE id = ?', [$id]);
    }
}
