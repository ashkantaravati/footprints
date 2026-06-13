<?php
final class Auth
{
    public static function config(): array
    {
        return require __DIR__ . '/../config/config.php';
    }

    public static function currentUser(): ?array
    {
        $cookie = self::config()['app']['cookie_name'];
        if (empty($_COOKIE[$cookie])) {
            return null;
        }
        $hash = hash('sha256', $_COOKIE[$cookie]);
        $stmt = Database::pdo()->prepare('SELECT u.* FROM sessions s JOIN users u ON u.id = s.user_id WHERE s.token_hash = ? AND s.expires_at > NOW() AND u.disabled_at IS NULL LIMIT 1');
        $stmt->execute([$hash]);
        return $stmt->fetch() ?: null;
    }

    public static function requireUser(): array
    {
        $user = self::currentUser();
        if (!$user) {
            Response::json(['error' => 'Authentication required'], 401);
        }
        return $user;
    }

    public static function requireAdmin(): array
    {
        $user = self::requireUser();
        if ((int) $user['is_admin'] !== 1) {
            Response::json(['error' => 'Admin access required'], 403);
        }
        return $user;
    }

    public static function login(string $username, string $password): bool
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE username = ? AND disabled_at IS NULL LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }
        self::issueSession((int) $user['id']);
        return true;
    }

    public static function issueSession(int $userId): void
    {
        $config = self::config();
        $token = bin2hex(random_bytes(32));
        $days = (int) Settings::get('session_days', $config['app']['session_days']);
        $expires = (new DateTimeImmutable('now'))->modify('+' . $days . ' days')->format('Y-m-d H:i:s');
        $stmt = Database::pdo()->prepare('INSERT INTO sessions (user_id, token_hash, expires_at) VALUES (?, ?, ?)');
        $stmt->execute([$userId, hash('sha256', $token), $expires]);
        setcookie($config['app']['cookie_name'], $token, [
            'expires' => time() + ($days * 86400),
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    public static function logout(): void
    {
        $config = self::config();
        $cookie = $config['app']['cookie_name'];
        if (!empty($_COOKIE[$cookie])) {
            $stmt = Database::pdo()->prepare('DELETE FROM sessions WHERE token_hash = ?');
            $stmt->execute([hash('sha256', $_COOKIE[$cookie])]);
        }
        setcookie($cookie, '', ['expires' => time() - 3600, 'path' => '/']);
    }
}
