<?php
require_once __DIR__ . '/../core/bootstrap.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = trim($_GET['route'] ?? '', '/');
$input = json_decode(file_get_contents('php://input') ?: '[]', true) ?: [];

try {
    if ($path === 'auth/login' && $method === 'POST') {
        if (Auth::login((string) ($input['username'] ?? ''), (string) ($input['password'] ?? ''))) {
            Response::json(['ok' => true, 'user' => Auth::currentUser()]);
        }
        Response::json(['error' => 'Invalid username or password'], 401);
    }
    if ($path === 'auth/logout' && $method === 'POST') {
        Auth::logout();
        Response::json(['ok' => true]);
    }
    if ($path === 'me' && $method === 'GET') {
        Response::json(['user' => Auth::requireUser()]);
    }
    if ($path === 'auth/change-password' && $method === 'POST') {
        $user = Auth::requireUser();
        $min = (int) Settings::get('password_min_length', Auth::config()['app']['password_min_length']);
        $new = (string) ($input['new_password'] ?? '');
        if (strlen($new) < $min) Response::json(['error' => 'Password too short'], 422);
        $stmt = Database::pdo()->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute([password_hash($new, PASSWORD_DEFAULT), $user['id']]);
        Footprint::record('user.password_changed', (int) $user['id'], null, ['user_id' => (int) $user['id']]);
        Response::json(['ok' => true]);
    }
    if ($path === 'groups' && $method === 'GET') {
        $user = Auth::requireUser();
        $stmt = Database::pdo()->prepare('SELECT g.* FROM groups g JOIN group_members gm ON gm.group_id = g.id WHERE gm.user_id = ? AND g.deleted_at IS NULL ORDER BY g.updated_at DESC');
        $stmt->execute([$user['id']]);
        Response::json(['groups' => $stmt->fetchAll()]);
    }
    if ($path === 'groups' && $method === 'POST') {
        $user = Auth::requireUser();
        $name = trim((string) ($input['name'] ?? ''));
        if ($name === '') Response::json(['error' => 'Group name required'], 422);
        Database::pdo()->beginTransaction();
        $stmt = Database::pdo()->prepare('INSERT INTO groups (name, created_by_user_id, updated_at) VALUES (?, ?, NOW())');
        $stmt->execute([$name, $user['id']]);
        $groupId = (int) Database::pdo()->lastInsertId();
        Database::pdo()->prepare('INSERT INTO group_members (group_id, user_id, role) VALUES (?, ?, ?)')->execute([$groupId, $user['id'], 'owner']);
        Footprint::record('group.created', (int) $user['id'], $groupId, ['name' => $name]);
        Database::pdo()->commit();
        Response::json(['ok' => true, 'group_id' => $groupId], 201);
    }
    if (preg_match('#^groups/(\d+)/messages$#', $path, $m) && $method === 'GET') {
        $user = Auth::requireUser();
        $groupId = (int) $m[1];
        assertMember($groupId, (int) $user['id']);
        $before = isset($_GET['before_id']) ? (int) $_GET['before_id'] : PHP_INT_MAX;
        $stmt = Database::pdo()->prepare('SELECT m.*, u.username FROM messages m JOIN users u ON u.id = m.sender_user_id WHERE m.group_id = ? AND m.id < ? AND m.deleted_at IS NULL ORDER BY m.id DESC LIMIT 50');
        $stmt->execute([$groupId, $before]);
        Response::json(['messages' => array_reverse($stmt->fetchAll())]);
    }
    if (preg_match('#^groups/(\d+)/messages$#', $path, $m) && $method === 'POST') {
        $user = Auth::requireUser();
        $groupId = (int) $m[1];
        assertMember($groupId, (int) $user['id']);
        $body = trim((string) ($input['body'] ?? ''));
        if ($body === '') Response::json(['error' => 'Message body required'], 422);
        $stmt = Database::pdo()->prepare('INSERT INTO messages (group_id, sender_user_id, body, retention_until, created_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL COALESCE((SELECT retention_days FROM retention_policies WHERE group_id = ?), 90) DAY), NOW())');
        $stmt->execute([$groupId, $user['id'], $body, $groupId]);
        $id = (int) Database::pdo()->lastInsertId();
        Database::pdo()->prepare('UPDATE groups SET updated_at = NOW() WHERE id = ?')->execute([$groupId]);
        Footprint::record('message.created', (int) $user['id'], $groupId, ['message_id' => $id]);
        Response::json(['ok' => true, 'message_id' => $id], 201);
    }
    if ($path === 'poll' && $method === 'GET') {
        $user = Auth::requireUser();
        $after = (int) ($_GET['after_id'] ?? 0);
        $stmt = Database::pdo()->prepare('SELECT f.* FROM footprints f JOIN group_members gm ON gm.group_id = f.group_id WHERE gm.user_id = ? AND f.id > ? ORDER BY f.id ASC LIMIT 100');
        $stmt->execute([$user['id'], $after]);
        Response::json(['footprints' => $stmt->fetchAll(), 'poll_interval_seconds' => (int) Settings::get('poll_interval_seconds', 3)]);
    }
    Response::json(['error' => 'Not found'], 404);
} catch (Throwable $e) {
    if (Database::pdo()->inTransaction()) Database::pdo()->rollBack();
    Response::json(['error' => 'Server error'], 500);
}

function assertMember(int $groupId, int $userId): void
{
    $stmt = Database::pdo()->prepare('SELECT 1 FROM group_members WHERE group_id = ? AND user_id = ? LIMIT 1');
    $stmt->execute([$groupId, $userId]);
    if (!$stmt->fetchColumn()) Response::json(['error' => 'Group access denied'], 403);
}
