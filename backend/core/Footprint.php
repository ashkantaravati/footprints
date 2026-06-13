<?php
final class Footprint
{
    public static function record(string $type, int $actorId, ?int $groupId, array $payload): int
    {
        $stmt = Database::pdo()->prepare('INSERT INTO footprints (type, actor_user_id, group_id, payload_json, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$type, $actorId, $groupId, json_encode($payload, JSON_UNESCAPED_SLASHES)]);
        return (int) Database::pdo()->lastInsertId();
    }
}
