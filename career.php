<?php $title='ดูดวงการงาน';require 'includes/config.php';$out='';
$tp=['งานปัจจุบัน','การเรียน','การสมัครงาน','โอกาสใหม่'];
if(posted()){$s=$_POST['topic']??'';$d=$_POST['birth']??'';
 if(in_array($s,$tp,true)&&valid_date($d)) $out=reading('การงาน',"เกิดวันที่ $d ".zodiac($d)." หัวข้อ: $s ช่วยวิเคราะห์ดวงการงาน/การเรียนช่วงนี้และให้คำแนะนำ",$s.' / '.zodiac($d));}
require 'includes/header.php'; ?>
<h2>ดูดวงการงาน</h2>
<form method="post" class="panel"><?= csrf() ?>
<label>หัวข้อ</label><select name="topic"><?php foreach($tp as $s): ?><option><?= $s ?></option><?php endforeach; ?></select>
<label>วันเกิด</label><input type="date" name="birth" required value="<?= e($_POST['birth']??'') ?>">
<p><button class="cta">ให้ AI วิเคราะห์</button></p>
<?php if($out): ?><div class="out"><?= nl2br(e($out)) ?></div><?php endif; ?></form>
<?php require 'includes/footer.php'; ?>
