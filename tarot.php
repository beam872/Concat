<?php $title='ไพ่ Tarot';require 'includes/config.php';
$deck=[['🌟','The Star','ความหวังและการเยียวยา'],['🌙','The Moon','ความไม่ชัดเจน'],['☀️','The Sun','ความสำเร็จและความสุข'],['🎡','Wheel of Fortune','จังหวะชีวิตเปลี่ยน'],['🔮','The Magician','พลังสร้างสรรค์'],['👑','The Empress','ความอุดมสมบูรณ์'],['⚖️','Justice','การตัดสินใจ'],['🗼','The Tower','การเปลี่ยนแปลงใหญ่'],['💞','The Lovers','ความรักและการเลือก'],['🕯️','The Hermit','การใคร่ครวญ'],['⚔️','Strength','ความกล้าหาญ'],['🌍','The World','การเริ่มต้นใหม่']];
$topics=['ภาพรวม','ความรัก','การงาน','การเงิน'];$cards=[];$out='';
if(posted()){$tp=in_array($_POST['topic']??'',$topics)?$_POST['topic']:'ภาพรวม';
 foreach((array)array_rand($deck,3) as $k)$cards[]=$deck[$k]; shuffle($cards);
 $names=implode(', ',array_column($cards,1));
 $out=reading('ไพ่ Tarot',"ผู้ใช้จั่วไพ่ Tarot 3 ใบ ตามลำดับอดีต ปัจจุบัน อนาคต: $names หัวข้อ: $tp ช่วยตีความ",$names);}
require 'includes/header.php'; ?>
<h2>ไพ่ Tarot</h2>
<form method="post" class="panel c"><?= csrf() ?>
<p class="sub">ตั้งจิตถึงเรื่องที่อยากรู้ แล้วกดเปิดไพ่</p>
<div class="cards"><?php if($cards): $L=['อดีต','ปัจจุบัน','อนาคต']; foreach($cards as $i=>$c): ?>
<div class="tc flip" style="animation-delay:<?= $i*.3 ?>s"><div class="b"><em><?= $c[0] ?></em><small><?= $L[$i] ?></small><b><?= e($c[1]) ?></b><small><?= e($c[2]) ?></small></div></div>
<?php endforeach; else: for($i=0;$i<3;$i++): ?><div class="tc"><div class="f">✦</div></div><?php endfor; endif; ?></div>
<select name="topic" style="max-width:240px"><?php foreach($topics as $t): ?><option><?= $t ?></option><?php endforeach; ?></select>
<p><button class="cta">เปิดไพ่</button></p>
<?php if($out): ?><div class="out left"><?= nl2br(e($out)) ?></div><?php endif; ?></form>
<?php require 'includes/footer.php'; ?>
