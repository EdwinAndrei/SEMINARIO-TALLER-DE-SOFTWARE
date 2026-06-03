<?php
 
namespace Dao;
 
class PedidoDao extends Dao
{
    public static function getAll(): array
    {
        $stmt = self::getConn()->prepare("
            SELECT p.id, p.estado, p.version, p.creado_en,
                u.nombre as cliente_nombre,
                GROUP_CONCAT(pl.nombre SEPARATOR ', ') as platos_nombres,
                SUM(pp.cantidad) as total_items
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id
            JOIN pedido_platos pp ON pp.pedido_id = p.id
            JOIN platos pl ON pp.plato_id = pl.id
            WHERE p.estado IN ('pendiente', 'en_proceso', 'listo')
            GROUP BY p.id, p.estado, p.version, p.creado_en, u.nombre
            ORDER BY p.creado_en ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
 
    public static function getHistorial(): array
    {
        $stmt = self::getConn()->prepare("
            SELECT p.id, p.estado, p.version, p.creado_en,
                u.nombre as cliente_nombre,
                GROUP_CONCAT(pl.nombre SEPARATOR ', ') as platos_nombres,
                SUM(pp.cantidad) as total_items
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id
            JOIN pedido_platos pp ON pp.pedido_id = p.id
            JOIN platos pl ON pp.plato_id = pl.id
            WHERE p.estado IN ('entregado', 'cancelado')
            GROUP BY p.id, p.estado, p.version, p.creado_en, u.nombre
            ORDER BY p.creado_en DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
 
    public static function getById(int $id): array|false
    {
        $stmt = self::getConn()->prepare("
            SELECT p.id, p.estado, p.version, p.creado_en,
                   u.nombre as cliente_nombre,
                   GROUP_CONCAT(pl.nombre SEPARATOR ', ') as platos_nombres,
                   SUM(pp.cantidad) as total_items
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id
            JOIN pedido_platos pp ON pp.pedido_id = p.id
            JOIN platos pl ON pp.plato_id = pl.id
            WHERE p.id = :id
            GROUP BY p.id, p.estado, p.version, p.creado_en, u.nombre
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
 
    public static function actualizarEstado(int $id, string $nuevoEstado, int $version): bool
    {
        $stmt = self::getConn()->prepare('
            UPDATE pedidos
            SET estado = :estado, version = version + 1
            WHERE id = :id AND version = :version
        ');
        $stmt->execute([
            'estado'  => $nuevoEstado,
            'id'      => $id,
            'version' => $version
        ]);
        return $stmt->rowCount() > 0;
    }
}