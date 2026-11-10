<?php $title='หมอดูตัวจริง';require 'includes/config.php';
$rows=db()->query("SELECT s.user_id,s.display_name,s.specialty,s.experience_years,AVG(r.rating) avg_r,COUNT(r.id) n FROM seers s LEFT JOIN reviews r ON r.seer_id=s.user_id WHERE s.status='approved' GROUP BY s.user_id,s.display_name,s.specialty,s.experience_years ORDER BY avg_r DESC,n DESC")->fetchAll();
require 'includes/header.php'; ?>
<h2>หมอดูตัวจริง</h2><p class="sub">เลือกหมอดูที่เป็นคนจริง ดูรีวิว แล้วเริ่มแชทได้เลย</p>
<div class="grid">
<?php foreach($rows as $r): ?>
<a class="panel" href="seer.php?id=<?= $r['user_id'] ?>"><div class="ic">🔮</div><b><?= e($r['display_name']) ?></b>
<small><?= e($r['specialty']) ?> · ประสบการณ์ <?= (int)$r['experience_years'] ?> ปี</small>
<span class="gold"><?= $r['n']?stars($r['avg_r']).' '.number_format($r['avg_r'],1).' ('.$r['n'].' รีวิว)':'ยังไม่มีรีวิว' ?></span></a>
<?php endforeach; ?></div>
<?php if(!$rows): ?><p class="sub">ยังไม่มีหมอดูในระบบ</p><?php endif; ?>
<p class="c"><a class="cta" href="seer_register.php">สมัครเป็นหมอดู</a></p>
<?php require 'includes/footer.php'; ?>
