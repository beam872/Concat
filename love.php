<?php $title='ดูดวงความรัก';require 'includes/config.php';$out='';
$st=['โสด','มีคนคุย','มีแฟน','ไม่แน่ใจในความสัมพันธ์'];
if(posted()){$s=$_POST['status']??'';$d=$_POST['birth']??'';
 if(in_array($s,$st,true)&&valid_date($d)) $out=reading('ความรัก',"เกิดวันที่ $d ".zodiac($d)." สถานะความรัก: $s ช่วยทำนายความรักช่วงนี้และให้คำแนะนำ",$s.' / '.zodiac($d));}
require 'includes/header.php'; ?>
<h2>ดูดวงความรัก</h2>
<form method="post" class="panel"><?= csrf() ?>
<label>สถานะ</label><select name="status"><?php foreach($st as $s): ?><option><?= $s ?></option><?php endforeach; ?></select>
<label>วันเกิด</label><input type="date" name="birth" required value="<?= e($_POST['birth']??'') ?>">
<p><button class="cta">ให้ AI ทำนาย</button></p>
<?php if($out): ?><div class="out"><?= nl2br(e($out)) ?></div><?php endif; ?></form>
<?php require 'includes/footer.php'; ?>
