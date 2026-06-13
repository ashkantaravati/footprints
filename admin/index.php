<?php
require_once __DIR__ . '/../backend/core/bootstrap.php';
$user = Auth::currentUser();
if (!$user || (int) $user['is_admin'] !== 1) { http_response_code(403); echo 'Admin login required.'; exit; }
$pdo = Database::pdo();
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create_user') {
        $min = (int) Settings::get('password_min_length', 12);
        if (strlen($_POST['password'] ?? '') < $min) { $message = 'Password too short.'; }
        else {
            $stmt = $pdo->prepare('INSERT INTO users (username, password_hash, is_admin) VALUES (?, ?, ?)');
            $stmt->execute([trim($_POST['username']), password_hash($_POST['password'], PASSWORD_DEFAULT), isset($_POST['is_admin']) ? 1 : 0]);
            $message = 'User created.';
        }
    }
    if ($action === 'disable_user') { $pdo->prepare('UPDATE users SET disabled_at = NOW() WHERE id = ?')->execute([(int) $_POST['user_id']]); $message = 'User disabled.'; }
    if ($action === 'reset_password') { $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')->execute([password_hash($_POST['password'], PASSWORD_DEFAULT), (int) $_POST['user_id']]); $message = 'Password reset.'; }
    if ($action === 'create_group') { $pdo->prepare('INSERT INTO groups (name, created_by_user_id, updated_at) VALUES (?, ?, NOW())')->execute([trim($_POST['name']), $user['id']]); $message = 'Group created.'; }
    if ($action === 'delete_group') { $pdo->prepare('UPDATE groups SET deleted_at = NOW() WHERE id = ?')->execute([(int) $_POST['group_id']]); $message = 'Group deleted.'; }
    if ($action === 'settings') { foreach (['max_groups_per_user','session_days','password_min_length','poll_interval_seconds','max_upload_mb','default_retention_days','attachment_retention_days'] as $k) Settings::set($k, (string) $_POST[$k]); $message = 'Settings saved.'; }
}
$users = $pdo->query('SELECT id, username, is_admin, disabled_at, created_at FROM users ORDER BY id DESC')->fetchAll();
$groups = $pdo->query('SELECT id, name, deleted_at, created_at FROM groups ORDER BY id DESC')->fetchAll();
function h($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><title>Footprints Admin</title><style>body{font-family:system-ui;margin:2rem;max-width:1100px}input,button{padding:.55rem;margin:.25rem}section{border:1px solid #ddd;padding:1rem;margin:1rem 0;border-radius:10px}table{width:100%;border-collapse:collapse}td,th{border-bottom:1px solid #eee;padding:.45rem;text-align:left}</style></head><body>
<h1>Footprints Admin</h1><p><?=h($message)?></p>
<section><h2>Create user</h2><form method="post"><input type="hidden" name="action" value="create_user"><input name="username" placeholder="username" required><input name="password" placeholder="temporary password" required><label><input type="checkbox" name="is_admin"> Admin</label><button>Create</button></form></section>
<section><h2>Users</h2><table><tr><th>ID</th><th>Username</th><th>Admin</th><th>Status</th><th>Actions</th></tr><?php foreach($users as $u): ?><tr><td><?=h($u['id'])?></td><td><?=h($u['username'])?></td><td><?=h($u['is_admin'])?></td><td><?=h($u['disabled_at']?'disabled':'active')?></td><td><form method="post" style="display:inline"><input type="hidden" name="action" value="disable_user"><input type="hidden" name="user_id" value="<?=h($u['id'])?>"><button>Disable</button></form><form method="post" style="display:inline"><input type="hidden" name="action" value="reset_password"><input type="hidden" name="user_id" value="<?=h($u['id'])?>"><input name="password" placeholder="new password"><button>Reset</button></form></td></tr><?php endforeach ?></table></section>
<section><h2>Groups</h2><form method="post"><input type="hidden" name="action" value="create_group"><input name="name" placeholder="Group name"><button>Create group</button></form><table><?php foreach($groups as $g): ?><tr><td><?=h($g['id'])?></td><td><?=h($g['name'])?></td><td><?=h($g['deleted_at']?'deleted':'active')?></td><td><form method="post"><input type="hidden" name="action" value="delete_group"><input type="hidden" name="group_id" value="<?=h($g['id'])?>"><button>Delete</button></form></td></tr><?php endforeach ?></table></section>
<section><h2>Settings</h2><form method="post"><input type="hidden" name="action" value="settings"><?php foreach(['max_groups_per_user'=>20,'session_days'=>60,'password_min_length'=>12,'poll_interval_seconds'=>3,'max_upload_mb'=>10,'default_retention_days'=>90,'attachment_retention_days'=>30] as $k=>$d): ?><label><?=h($k)?> <input name="<?=h($k)?>" value="<?=h(Settings::get($k,$d))?>"></label><br><?php endforeach ?><button>Save settings</button></form></section>
</body></html>
