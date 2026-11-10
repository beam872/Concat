<?php $title='โปรไฟล์หมอดู';require 'includes/config.php';$id=(int)($_GET['id']??0);
$q=db()->prepare("SELECT * FROM seers WHERE user_id=? AND status='approved'");$q->execute([$id]);$s=$q->fetch();
if(!$s){http_response_code(404);require 'includes/header.php';echo '<h2>ไม่พบหมอดูท่านนี้</h2>';require 'includes/footer.php';exit;}
$me=user()['id']??0;
$c=db()->prepare('SELECT 1 FROM messages m JOIN chats c ON c.id=m.chat_id WHERE c.user_id=? AND c.seer_id=? AND m.sender_id=? LIMIT 1');$c->execute([$me,$id,$me]);
$canReview=$me&&$me!==$id&&$c->fetchColumn();$msg='';
if(posted()&&isset($_POST['rating'])){
 if(!$canReview)$msg='ต้องเคยแชทกับหมอดูท่านนี้ก่อนจึงจะรีวิวได้';
 else{$rt=(int)$_POST['rating'];
  if($rt<1||$rt>5)$msg='กรุณาเลือกคะแนน 1-5';
  else{db()->prepare('INSERT INTO reviews(seer_id,user_id,rating,comment) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE rating=VALUES(rating),comment=VALUES(comment),created_at=NOW()')->execute([$id,$me,$rt,trim(mb_substr($_POST['comment']??'',0,500))]);$msg='ขอบคุณสำหรับรีวิว';}}}
$st=db()->prepare('SELECT AVG(rating) a,COUNT(*) n FROM reviews WHERE seer_id=?');$st->execute([$id]);$st=$st->fetch();
$rv=db()->prepare('SELECT r.*,u.username FROM reviews r JOIN users u ON u.id=r.user_id WHERE r.seer_id=? ORDER BY r.id DESC LIMIT 50');$rv->execute([$id]);
require 'includes/header.php'; ?>
<div class="panel"><h2 style="margin-top:0">🔮 <?= e($s['display_name']) ?></h2>
<p class="gold"><?= $st['n']?stars($st['a']).' '.number_format($st['a'],1).' · '.$st['n'].' รีวิว':'ยังไม่มีรีวิว' ?></p>
<p class="sub"><?= e($s['specialty']) ?> · ประสบการณ์ <?= (int)$s['experience_years'] ?> ปี</p>
<p><?= nl2br(e($s['bio'])) ?></p>
<?php if($me!==$id): ?><a class="cta" href="chat.php?seer=<?= $id ?>">💬 เริ่มแชทกับหมอดู</a><?php else: ?><a href="seer_register.php">แก้ไขโปรไฟล์ของฉัน</a><?php endif; ?></div>

<h2>รีวิว</h2>
<?php if($msg): ?><p class="gold"><?= e($msg) ?></p><?php endif; ?>
<?php if($canReview): ?><form method="post" class="panel"><?= csrf() ?><b>ให้คะแนนและรีวิว</b>
<label>คะแนน</label><select name="rating" style="max-width:200px"><?php for($i=5;$i>=1;$i--): ?><option value="<?= $i ?>"><?= str_repeat('★',$i) ?> (<?= $i ?>)</option><?php endfor; ?></select>
<label>ความคิดเห็น</label><textarea name="comment" rows="3" maxlength="500"></textarea><p><button class="cta">ส่งรีวิว</button></p></form>
<?php elseif($me!==$id): ?><p class="note">เริ่มแชทกับหมอดูก่อน จึงจะรีวิวได้</p><?php endif; ?>
<?php foreach($rv as $r): ?><div class="panel"><span class="gold"><?= stars($r['rating']) ?></span> <b><?= e($r['username']) ?></b> <small class="note"><?= e($r['created_at']) ?></small><br><?= nl2br(e($r['comment'])) ?></div><?php endforeach; ?>
<?php require 'includes/footer.php'; ?>
