<?php $title='สมัครสมาชิก';require 'includes/config.php';$err='';
if(posted()){$u=trim($_POST['username']??'');$m=trim($_POST['email']??'');$p=$_POST['password']??'';
 if(!preg_match('/^[\w\-]{3,40}$/u',$u))$err='ชื่อผู้ใช้ 3-40 ตัวอักษร (ตัวอักษร ตัวเลข _ -)';
 elseif(!filter_var($m,FILTER_VALIDATE_EMAIL))$err='อีเมลไม่ถูกต้อง';
 elseif(strlen($p)<8)$err='รหัสผ่านอย่างน้อย 8 ตัวอักษร';
 else{try{db()->prepare('INSERT INTO users(username,email,password_hash) VALUES(?,?,?)')->execute([$u,$m,password_hash($p,PASSWORD_DEFAULT)]);
  session_regenerate_id(true);$_SESSION['u']=['id'=>(int)db()->lastInsertId(),'username'=>$u];header('Location: index.php');exit;
 }catch(PDOException $x){$err='ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้แล้ว';}}}
require 'includes/header.php'; ?>
<h2>สมัครสมาชิก</h2>
<form method="post" class="panel narrow"><?= csrf() ?>
<?php if($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?>
<label>ชื่อผู้ใช้</label><input name="username" required value="<?= e($_POST['username']??'') ?>">
<label>อีเมล</label><input type="email" name="email" required value="<?= e($_POST['email']??'') ?>">
<label>รหัสผ่าน</label><input type="password" name="password" required minlength="8">
<p><button class="cta">สมัครสมาชิก</button></p><p class="note">มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p></form>
<?php require 'includes/footer.php'; ?>
