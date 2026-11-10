<?php $title='AI หมอดู';require 'includes/config.php';$q='';$out='';
if(posted()){$q=trim(mb_substr($_POST['q']??'',0,300));
 if($q!=='') $out=reading('AI หมอดู',"คำถามจากผู้ใช้ (ตอบในบทบาทหมอดูเท่านั้น): $q",mb_substr($q,0,200));}
require 'includes/header.php'; ?>
<h2>AI หมอดู</h2>
<form method="post" class="panel"><?= csrf() ?>
<label>คำถามของคุณ</label><textarea name="q" rows="3" maxlength="300" placeholder="ช่วงนี้ความรักของฉันเป็นอย่างไร?" required><?= e($q) ?></textarea>
<p><button class="cta">ส่งคำถาม</button></p>
<?php if($out): ?><div class="out"><?= nl2br(e($out)) ?></div><?php endif; ?></form>
<?php require 'includes/footer.php'; ?>
