<?php $title='แอดมิน';require 'includes/config.php';need_login();
$a=db()->prepare('SELECT is_admin FROM users WHERE id=?');$a->execute([user()['id']]);
if(!$a->fetchColumn()){http_response_code(403);exit('ไม่มีสิทธิ์เข้าถึง');}
if(posted()&&in_array($_POST['do']??'',['approved','rejected'],true))
 db()->prepare('UPDATE seers SET status=? WHERE user_id=?')->execute([$_POST['do'],(int)($_POST['id']??0)]);
$rows=db()->query("SELECT s.*,u.username,u.email FROM seers s JOIN users u ON u.id=s.user_id ORDER BY FIELD(s.status,'pending','approved','rejected'),s.created_at DESC")->fetchAll();
require 'includes/header.php'; ?>
<h2>จัดการหมอดู</h2>
<?php foreach($rows as $r): ?><div class="panel"><b><?= e($r['display_name']) ?></b> <small class="note">(<?= e($r['username']) ?> · <?= e($r['email']) ?>)</small> — <b class="gold"><?= e($r['status']) ?></b>
<p class="sub"><?= e($r['specialty']) ?> · <?= (int)$r['experience_years'] ?> ปี</p><p><?= nl2br(e($r['bio'])) ?></p>
<form method="post" style="display:flex;gap:8px"><?= csrf() ?><input type="hidden" name="id" value="<?= (int)$r['user_id'] ?>">
<button class="cta" name="do" value="approved">อนุมัติ</button><button class="cta" name="do" value="rejected" style="background:#7f1d1d">ปฏิเสธ</button></form></div>
<?php endforeach; if(!$rows): ?><p class="sub">ยังไม่มีใบสมัคร</p><?php endif; ?>
<?php require 'includes/footer.php'; ?>
