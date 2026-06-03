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
        $conn = self::getConn();
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare("
                INSERT INTO pedidos (usuario_id, estado)
                VALUES (:usuario_id, 'pendiente')
            ");
            $stmt->bindParam(':usuario_id', $usuario_id, \PDO::PARAM_INT);
            $stmt->execute();
 
            $pedido_id = (int) $conn->lastInsertId();
 
            $stmt2 = $conn->prepare("
                INSERT INTO pedido_platos (pedido_id, plato_id, cantidad)
                VALUES (:pedido_id, :plato_id, :cantidad)
            ");
            $stmt2->bindParam(':pedido_id', $pedido_id, \PDO::PARAM_INT);
            $stmt2->bindParam(':plato_id',  $plato_id,  \PDO::PARAM_INT);
            $stmt2->bindParam(':cantidad',  $cantidad,  \PDO::PARAM_INT);
            $stmt2->execute();
 
            $conn->commit();
            return $pedido_id;
        } catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    }
 
    public static function getPedidosByUser(
        int $usuario_id
    ) {
        $sqlstr = "
            SELECT
                p.id,
                p.usuario_id,
                pp.plato_id,
                pp.cantidad,
                p.estado,
                p.creado_en,
                pl.nombre,
                pl.precio
            FROM pedidos p
            INNER JOIN pedido_platos pp ON pp.pedido_id = p.id
            INNER JOIN platos pl ON pl.id = pp.plato_id
            WHERE p.usuario_id = :usuario_id
            ORDER BY p.creado_en DESC;
        ";
 
        return self::obtenerRegistros(
            $sqlstr,
            ['usuario_id' => $usuario_id]
        );
    }
 
    public static function getPedidoById(
        int $id
    ) {
        $sqlstr = "
            SELECT
                p.id,
                p.usuario_id,
                pp.plato_id,
                pp.cantidad,
                p.estado,
                p.creado_en
            FROM pedidos p
            INNER JOIN pedido_platos pp ON pp.pedido_id = p.id
            WHERE p.id = :id
            LIMIT 1;
        ";
 
        return self::obtenerUnRegistro(
            $sqlstr,
            ['id' => $id]
        );
    }
 
    public static function cancelarPedido(
        int $id
    ) {
        $sqlstr = "
            UPDATE pedidos
            SET estado = 'cancelado'
            WHERE id = :id
            AND estado = 'pendiente';
        ";
 
        return self::executeNonQuery(
            $sqlstr,
            ['id' => $id]
        );
    }
 
    public static function getLastInsertId()
    {
        return self::getConn()->lastInsertId();
    }
}