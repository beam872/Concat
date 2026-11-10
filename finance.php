<?php $title='ดูดวงการเงิน';require 'includes/config.php';$out='';
$tp=['รายรับ','รายจ่าย','โชคลาภ','การวางแผนการเงิน'];
if(posted()){$s=$_POST['topic']??'';$d=$_POST['birth']??'';
 if(in_array($s,$tp,true)&&valid_date($d)) $out=reading('การเงิน',"เกิดวันที่ $d ".zodiac($d)." หัวข้อ: $s ช่วยทำนายดวงการเงินช่วงนี้แบบเชิงบันเทิง ห้ามแนะนำให้ลงทุนหรือซื้อสินทรัพย์เฉพาะเจาะจง",$s.' / '.zodiac($d));}
require 'includes/header.php'; ?>
<h2>ดูดวงการเงิน</h2>
<form method="post" class="panel"><?= csrf() ?>
<label>หัวข้อ</label><select name="topic"><?php foreach($tp as $s): ?><option><?= $s ?></option><?php endforeach; ?></select>
<label>วันเกิด</label><input type="date" name="birth" required value="<?= e($_POST['birth']??'') ?>">
<p><button class="cta">เปิดคำทำนาย</button></p>
<?php if($out): ?><div class="out"><?= nl2br(e($out)) ?></div><?php endif; ?>
<p class="note">คำทำนายเพื่อความบันเทิงเท่านั้น ไม่ใช่คำแนะนำทางการเงิน</p></form>
<?php require 'includes/footer.php'; ?>
