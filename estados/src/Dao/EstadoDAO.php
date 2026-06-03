<?php

namespace Dao;

class EstadoDAO extends Dao
{
    public static function obtenerPedidos(): array
    {
        return PedidoDao::getAll();
    }

    public static function cambiarEstado(int $id, string $estado, int $version): bool
    {
        return PedidoDao::actualizarEstado($id, $estado, $version);
    }
}