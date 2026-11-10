<?php $title='ประวัติการดูดวง';require 'includes/config.php';need_login();
$s=db()->prepare('SELECT * FROM readings WHERE user_id=? ORDER BY id DESC LIMIT 50');$s->execute([user()['id']]);$rows=$s->fetchAll();
require 'includes/header.php'; ?>
<h2>ประวัติการดูดวง</h2>
<?php foreach($rows as $r): ?><details class="panel"><summary><b class="gold"><?= e($r['type']) ?></b> · <?= e($r['summary']) ?> <small><?= e($r['created_at']) ?></small></summary><div class="out"><?= nl2br(e($r['content'])) ?></div></details>
<?php endforeach; if(!$rows): ?><p class="sub">ยังไม่มีประวัติ ลองไปดูดวงสักครั้ง</p><?php endif; ?>
<?php require 'includes/footer.php'; ?>
