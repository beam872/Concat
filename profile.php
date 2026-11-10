<?php $title='แก้ไขข้อมูล';require 'includes/config.php';need_login();$ok='';
if(posted()){$d=valid_date($_POST['birth']??'')?$_POST['birth']:null;$g=in_array($_POST['sex']??'',['หญิง','ชาย'])?$_POST['sex']:null;
 db()->prepare('UPDATE users SET birth_date=?,gender=? WHERE id=?')->execute([$d,$g,user()['id']]);$ok='บันทึกแล้ว';}
$s=db()->prepare('SELECT birth_date,gender,email FROM users WHERE id=?');$s->execute([user()['id']]);$r=$s->fetch();
require 'includes/header.php'; ?>
<h2>แก้ไขข้อมูล</h2>
<form method="post" class="panel narrow"><?= csrf() ?>
<?php if($ok): ?><p class="gold"><?= $ok ?></p><?php endif; ?>
<label>อีเมล</label><input value="<?= e($r['email']) ?>" disabled>
<label>วันเกิด</label><input type="date" name="birth" value="<?= e($r['birth_date']) ?>">
<label>เพศ</label><select name="sex"><option value="">ไม่ระบุ</option><?php foreach(['หญิง','ชาย'] as $g): ?><option <?= $r['gender']===$g?'selected':'' ?>><?= $g ?></option><?php endforeach; ?></select>
<p><button class="cta">บันทึก</button></p></form>
<?php require 'includes/footer.php'; ?>
