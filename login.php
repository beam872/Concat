<?php $title='เข้าสู่ระบบ';require 'includes/config.php';$err='';
if(posted()){$s=db()->prepare('SELECT * FROM users WHERE username=? OR email=?');$s->execute([trim($_POST['login']??''),trim($_POST['login']??'')]);$r=$s->fetch();
 if($r&&password_verify($_POST['password']??'',$r['password_hash'])){session_regenerate_id(true);$_SESSION['u']=['id'=>(int)$r['id'],'username'=>$r['username'],'admin'=>(bool)$r['is_admin']];header('Location: index.php');exit;}
 $err='ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';}
require 'includes/header.php'; ?>
<h2>เข้าสู่ระบบ</h2>
<form method="post" class="panel narrow"><?= csrf() ?>
<?php if($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
<label>ชื่อผู้ใช้หรืออีเมล</label><input name="login" required>
<label>รหัสผ่าน</label><input type="password" name="password" required>
<p><button class="cta">เข้าสู่ระบบ</button></p><p class="note">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p></form>
<?php require 'includes/footer.php'; ?>
