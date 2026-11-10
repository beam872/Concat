<?php $title='ดูดวงวันเกิด';require 'includes/config.php';$out='';$sign='';
if(posted()){$d=$_POST['birth']??'';$g=in_array($_POST['sex']??'',['หญิง','ชาย'])?$_POST['sex']:'ไม่ระบุ';
 if(valid_date($d)){$sign=zodiac($d);
  $out=reading('ดูดวงวันเกิด',"เกิดวันที่ $d $sign เพศ $g ช่วยบอกลักษณะนิสัย ความรัก การงาน การเงิน และคำแนะนำ แบ่งเป็นหัวข้อสั้น ๆ",$sign);}}
require 'includes/header.php'; ?>
<h2>ดูดวงวันเกิด</h2>
<form method="post" class="panel"><?= csrf() ?>
<label>วันเกิด</label><input type="date" name="birth" required value="<?= e($_POST['birth']??'') ?>">
<label>เพศ (ไม่บังคับ)</label><select name="sex"><option>ไม่ระบุ</option><option>หญิง</option><option>ชาย</option></select>
<p><button class="cta">เปิดดวงชะตา</button></p>
<?php if($out): ?><div class="out"><b class="gold"><?= e($sign) ?></b><br><?= nl2br(e($out)) ?></div><?php endif; ?></form>
<?php require 'includes/footer.php'; ?>
