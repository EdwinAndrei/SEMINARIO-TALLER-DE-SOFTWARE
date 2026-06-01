<?php

namespace Dao\Tracking;

use Dao\Table;

class Pedidos extends Table
{
    /**
     * Crear cabecera de pedido
     */
    public static function insertPedido(int $usercod)
    {
        $sqlstr = "
            INSERT INTO pedidos
            (
                usercod,
                pedidoEstado
            )
            VALUES
            (
                :usercod,
                'PEN'
            );
        ";

        return self::executeNonQuery($sqlstr, [
            "usercod" => $usercod
        ]);
    }

    /**
     * Insertar detalle del pedido
     */
    public static function insertDetallePedido(
        int $pedidoId,
        int $platoId,
        int $cantidad,
        float $precioUnitario
    ) {
        $sqlstr = "
            INSERT INTO pedidodetalle
            (
                pedidoId,
                platoId,
                cantidad,
                precioUnitario
            )
            VALUES
            (
                :pedidoId,
                :platoId,
                :cantidad,
                :precioUnitario
            );
        ";

        return self::executeNonQuery($sqlstr, [
            "pedidoId" => $pedidoId,
            "platoId" => $platoId,
            "cantidad" => $cantidad,
            "precioUnitario" => $precioUnitario
        ]);
    }

    /**
     * Obtener pedidos por usuario
     */
    public static function getPedidosByUser(int $usercod)
    {
        $sqlstr = "
            SELECT
                p.pedidoId,
                pl.platoNombre,
                pd.cantidad,
                p.pedidoEstado,
                p.pedidoFecha,
                pd.precioUnitario,
                pd.platoId
            FROM pedidos p
            INNER JOIN pedidodetalle pd ON p.pedidoId = pd.pedidoId
            INNER JOIN platos pl ON pd.platoId = pl.platoId
            WHERE p.usercod = :usercod
            ORDER BY p.pedidoFecha DESC;
        ";

        return self::obtenerRegistros($sqlstr, [
            "usercod" => $usercod
        ]);
    }

    /**
     * Obtener pedido por ID
     */
    public static function getPedidoById(int $pedidoId)
    {
        $sqlstr = "
            SELECT
                p.pedidoId,
                p.usercod,
                p.pedidoEstado,
                pd.platoId,
                pd.cantidad
            FROM pedidos p
            INNER JOIN pedidodetalle pd
                ON p.pedidoId = pd.pedidoId
            WHERE p.pedidoId = :pedidoId
            LIMIT 1;
        ";

        return self::obtenerUnRegistro($sqlstr, [
            "pedidoId" => $pedidoId
        ]);
    }

    /**
     * Último ID insertado
     */
    public static function getLastInsertId()
    {
        return self::getConn()->lastInsertId();
    }

    /**
     * Cancelar pedido
     */
    public static function cancelarPedido(int $pedidoId)
    {
        $sql = "
            UPDATE pedidos
            SET pedidoEstado = 'CAN'
            WHERE pedidoId = :pedidoId
            AND pedidoEstado = 'PEN';
        ";

        return self::executeNonQuery($sql, [
            "pedidoId" => $pedidoId
        ]);
    }
}
