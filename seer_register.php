<?php $title='โปรไฟล์หมอดู';require 'includes/config.php';need_login();$uid=user()['id'];$err='';$ok='';
$q=db()->prepare('SELECT * FROM seers WHERE user_id=?');$q->execute([$uid]);$row=$q->fetch();
if(posted()){
 $n=trim(mb_substr($_POST['display_name']??'',0,60));$sp=trim(mb_substr($_POST['specialty']??'',0,80));
 $ex=max(0,min(60,(int)($_POST['exp']??0)));$bio=trim(mb_substr($_POST['bio']??'',0,1500));
 if($n===''||$bio==='')$err='กรุณากรอกชื่อที่แสดงและประวัติ/แนะนำตัว';
 else{
  if($row)db()->prepare('UPDATE seers SET display_name=?,specialty=?,experience_years=?,bio=? WHERE user_id=?')->execute([$n,$sp,$ex,$bio,$uid]);
  else db()->prepare('INSERT INTO seers(user_id,display_name,specialty,experience_years,bio) VALUES(?,?,?,?,?)')->execute([$uid,$n,$sp,$ex,$bio]);
  $ok=$row?'บันทึกการแก้ไขแล้ว':'ส่งใบสมัครแล้ว รอแอดมินตรวจสอบและอนุมัติ';
  $q->execute([$uid]);$row=$q->fetch();}}
$stl=['pending'=>'รอแอดมินอนุมัติ','approved'=>'อนุมัติแล้ว','rejected'=>'ไม่ผ่านการอนุมัติ'];
require 'includes/header.php'; ?>
<h2><?= $row?'โปรไฟล์หมอดูของคุณ':'สมัครเป็นหมอดู' ?></h2>
<form method="post" class="panel"><?= csrf() ?>
<?php if($row): ?><p>สถานะ: <b class="gold"><?= $stl[$row['status']] ?></b> <?php if($row['status']==='approved'): ?>· <a href="seer.php?id=<?= $uid ?>">ดูหน้าโปรไฟล์สาธารณะ</a><?php endif; ?></p><?php endif; ?>
<?php if($err): ?><p class="err"><?= e($err) ?></p><?php endif; ?><?php if($ok): ?><p class="gold"><?= e($ok) ?></p><?php endif; ?>
<label>ชื่อที่แสดง (ชื่อหมอดู)</label><input name="display_name" required maxlength="60" value="<?= e($row['display_name']??'') ?>">
<label>แขนงที่ถนัด เช่น ไพ่ยิปซี, โหราศาสตร์ไทย, ดูลายมือ</label><input name="specialty" maxlength="80" value="<?= e($row['specialty']??'') ?>">
<label>ประสบการณ์ (ปี)</label><input type="number" name="exp" min="0" max="60" value="<?= e($row['experience_years']??0) ?>">
<label>แนะนำตัวและประวัติ</label><textarea name="bio" rows="6" maxlength="1500" required><?= e($row['bio']??'') ?></textarea>
<p class="note">ใบสมัครจะแสดงบนเว็บหลังแอดมินอนุมัติ ห้ามให้คำแนะนำด้านการแพทย์ กฎหมาย หรือการลงทุนในฐานะหมอดู</p>
<p><button class="cta"><?= $row?'บันทึก':'ส่งใบสมัคร' ?></button></p></form>
<?php require 'includes/footer.php'; ?>
