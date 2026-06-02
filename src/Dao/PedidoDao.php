<?php
namespace Dao;

class PedidoDao extends Dao
{
    public static function getAll(): array
    {
        $stmt = self::getConn()->prepare('
            SELECT p.*, pl.nombre as plato_nombre, u.nombre as cliente_nombre
            FROM pedidos p
            JOIN platos pl ON p.plato_id = pl.id
            JOIN usuarios u ON p.usuario_id = u.id
            ORDER BY p.creado_en ASC
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getById(int $id): array|false
    {
        $stmt = self::getConn()->prepare('
            SELECT p.*, pl.nombre as plato_nombre, u.nombre as cliente_nombre
            FROM pedidos p
            JOIN platos pl ON p.plato_id = pl.id
            JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.id = :id
        ');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function crearConTransaccion(int $usuario_id, int $plato_id, int $cantidad): int
    {
        $conn = self::getConn();
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare('
                INSERT INTO pedidos (usuario_id, plato_id, cantidad)
                VALUES (:usuario_id, :plato_id, :cantidad)
            ');
            $stmt->execute([
                'usuario_id' => $usuario_id,
                'plato_id'   => $plato_id,
                'cantidad'   => $cantidad
            ]);
            $id = (int) $conn->lastInsertId();
            $conn->commit();
            return $id;
        } catch (\Exception $e) {
            $conn->rollBack();
            throw $e;
        }
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