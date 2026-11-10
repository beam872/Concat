<?php $title='แชทหมอดู';require 'includes/config.php';need_login();$uid=user()['id'];
if(isset($_GET['seer'])){$sid=(int)$_GET['seer'];
 $ok=db()->prepare("SELECT 1 FROM seers WHERE user_id=? AND status='approved'");$ok->execute([$sid]);
 if(!$ok->fetchColumn()||$sid===$uid){header('Location: seers.php');exit;}
 db()->prepare('INSERT IGNORE INTO chats(user_id,seer_id) VALUES(?,?)')->execute([$uid,$sid]);
 $c=db()->prepare('SELECT id FROM chats WHERE user_id=? AND seer_id=?');$c->execute([$uid,$sid]);header('Location: chat.php?id='.(int)$c->fetchColumn());exit;}
$id=(int)($_GET['id']??0);$chat=null;
if($id){$q=db()->prepare('SELECT c.id,u.id other_id,u.username,s.display_name FROM chats c JOIN users u ON u.id=IF(c.user_id=?,c.seer_id,c.user_id) LEFT JOIN seers s ON s.user_id=u.id WHERE c.id=? AND (c.user_id=? OR c.seer_id=?)');
 $q->execute([$uid,$id,$uid,$uid]);$chat=$q->fetch();}
if(!$chat){$q=db()->prepare('SELECT c.id,COALESCE(s.display_name,u.username) name,(SELECT body FROM messages m WHERE m.chat_id=c.id ORDER BY m.id DESC LIMIT 1) last_msg,(SELECT created_at FROM messages m WHERE m.chat_id=c.id ORDER BY m.id DESC LIMIT 1) last_at FROM chats c JOIN users u ON u.id=IF(c.user_id=?,c.seer_id,c.user_id) LEFT JOIN seers s ON s.user_id=u.id WHERE c.user_id=? OR c.seer_id=? ORDER BY COALESCE(last_at,c.created_at) DESC');
 $q->execute([$uid,$uid,$uid]);$list=$q->fetchAll();}
$tok=csrf();
require 'includes/header.php'; ?>
<?php if($chat): ?>
<h2>💬 <?= e($chat['display_name']?:$chat['username']) ?></h2>
<p class="note"><a href="chat.php">← กลับไปรายการแชท</a><?php if($chat['display_name']): ?> · <a href="seer.php?id=<?= (int)$chat['other_id'] ?>">ดูโปรไฟล์</a><?php endif; ?></p>
<div class="panel"><div id="msgs" class="chatbox" data-chat="<?= (int)$chat['id'] ?>" data-token="<?= e($_SESSION['t']) ?>"></div>
<form id="sendf" class="sendrow"><input name="body" maxlength="1000" placeholder="พิมพ์ข้อความ..." autocomplete="off" required><button class="cta">ส่ง</button></form>
<p class="note">คำทำนายเพื่อความบันเทิง ไม่ควรโอนเงินหรือให้ข้อมูลส่วนตัวสำคัญกับใครในแชท</p></div>
<script src="js/chat.js"></script>
<?php else: ?>
<h2>แชทของฉัน</h2>
<?php foreach($list as $r): ?><a class="panel" href="chat.php?id=<?= (int)$r['id'] ?>"><b><?= e($r['name']) ?></b> <small class="note"><?= e($r['last_at']) ?></small><br><span class="sub"><?= e(mb_substr((string)$r['last_msg'],0,80)) ?></span></a><?php endforeach; ?>
<?php if(!$list): ?><p class="sub">ยังไม่มีแชท <a href="seers.php">เลือกหมอดู</a> เพื่อเริ่มต้น</p><?php endif; ?>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
