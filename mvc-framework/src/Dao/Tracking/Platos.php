<?php

namespace Dao\Tracking;

use Dao\Table;

class Platos extends Table
{
    public static function getAll()
    {
        $sqlstr = "
            SELECT
                platoId,
                platoNombre,
                platoDescripcion,
                platoPrecio,
                platoStock,
                platoEstado
            FROM platos
            ORDER BY platoId DESC;
        ";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $platoId)
    {
        $sqlstr = "
            SELECT
                platoId,
                platoNombre,
                platoDescripcion,
                platoPrecio,
                platoStock,
                platoEstado
            FROM platos
            WHERE platoId = :platoId;
        ";

        return self::obtenerUnRegistro($sqlstr, [
            "platoId" => $platoId
        ]);
    }

    /**
     * Reducir stock al hacer pedido
     */
    public static function reducirStock(int $platoId, int $cantidad)
    {
        $sqlstr = "
            UPDATE platos
            SET platoStock = platoStock - :cantidad
            WHERE platoId = :platoId
            AND platoStock >= :cantidad;
        ";

        return self::executeNonQuery($sqlstr, [
            "platoId" => $platoId,
            "cantidad" => $cantidad
        ]);
    }

    /**
     * Aumentar stock (cancelación de pedido)
     */
    public static function aumentarStock(int $platoId, int $cantidad)
    {
        $sqlstr = "
            UPDATE platos
            SET platoStock = platoStock + :cantidad
            WHERE platoId = :platoId;
        ";

        return self::executeNonQuery($sqlstr, [
            "platoId" => $platoId,
            "cantidad" => $cantidad
        ]);
    }
}
