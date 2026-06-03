<?php

namespace Dao\Tracking;

use Dao\Table;

class Pedidos extends Table
{
    public static function insertPedido(
        int $usuario_id,
        int $plato_id,
        int $cantidad
    ) {
        $sqlstr = "
            INSERT INTO pedidos
            (
                usuario_id,
                plato_id,
                cantidad,
                estado
            )
            VALUES
            (
                :usuario_id,
                :plato_id,
                :cantidad,
                'PEN'
            );
        ";

        return self::executeNonQuery(
            $sqlstr,
            [
                "usuario_id" => $usuario_id,
                "plato_id" => $plato_id,
                "cantidad" => $cantidad
            ]
        );
    }

    public static function getPedidosByUser(
        int $usuario_id
    ) {
        $sqlstr = "
            SELECT
                p.id,
                p.usuario_id,
                p.plato_id,
                p.cantidad,
                p.estado,
                p.creado_en,
                pl.nombre,
                pl.precio
            FROM pedidos p
            INNER JOIN platos pl
                ON p.plato_id = pl.id
            WHERE p.usuario_id = :usuario_id
            ORDER BY p.creado_en DESC;
        ";

        return self::obtenerRegistros(
            $sqlstr,
            [
                "usuario_id" => $usuario_id
            ]
        );
    }

    public static function getPedidoById(
        int $id
    ) {
        $sqlstr = "
            SELECT
                id,
                usuario_id,
                plato_id,
                cantidad,
                estado,
                creado_en
            FROM pedidos
            WHERE id = :id
            LIMIT 1;
        ";

        return self::obtenerUnRegistro(
            $sqlstr,
            [
                "id" => $id
            ]
        );
    }

    public static function cancelarPedido(
        int $id
    ) {
        $sqlstr = "
            UPDATE pedidos
            SET estado = 'CAN'
            WHERE id = :id
            AND estado = 'PEN';
        ";

        return self::executeNonQuery(
            $sqlstr,
            [
                "id" => $id
            ]
        );
    }

    public static function getLastInsertId()
    {
        return self::getConn()->lastInsertId();
    }
}