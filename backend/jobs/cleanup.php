<?php
require_once __DIR__ . '/../core/bootstrap.php';

$pdo = Database::pdo();
$pdo->exec("UPDATE messages SET deleted_at = NOW() WHERE deleted_at IS NULL AND retention_until IS NOT NULL AND retention_until < NOW()");
$pdo->exec("UPDATE attachments SET deleted_at = NOW() WHERE deleted_at IS NULL AND retention_until IS NOT NULL AND retention_until < NOW()");
$pdo->exec("DELETE FROM sessions WHERE expires_at < NOW()");
echo "Footprints cleanup complete\n";
