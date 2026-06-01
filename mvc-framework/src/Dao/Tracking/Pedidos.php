<?php

namespace Dao\Tracking;

use Dao\Table;

class Pedidos extends Table
{
    public static function insertPedido(
        int $usercod,
        int $platoId,
        int $cantidad
    ) {
        $sqlstr = "
            INSERT INTO pedidos
            (
                usercod,
                platoId,
                pedidoCantidad,
                pedidoEstado,
                pedidoVersion
            )
            VALUES
            (
                :usercod,
                :platoId,
                :cantidad,
                'pendiente',
                1
            );
        ";

        return self::executeNonQuery(
            $sqlstr,
            [
                "usercod" => $usercod,
                "platoId" => $platoId,
                "cantidad" => $cantidad
            ]
        );
    }


    public static function getPedidosByUser(int $usercod)
    {
        $sqlstr = "
        SELECT
            p.pedidoId,
            pl.platoNombre,
            p.pedidoCantidad,
            p.pedidoEstado,
            p.pedidoFecha
        FROM pedidos p
        INNER JOIN platos pl
            ON p.platoId = pl.platoId
        WHERE p.usercod = :usercod
        ORDER BY p.pedidoFecha DESC;
    ";

        return self::obtenerRegistros(
            $sqlstr,
            [
                "usercod" => $usercod
            ]
        );
    }
}
