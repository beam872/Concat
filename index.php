<?php $title='หน้าแรก';require 'includes/config.php';
$lines=['วันนี้เหมาะกับการเริ่มต้นสิ่งใหม่ ใจเย็นแล้วจะได้เจอคำตอบ','พลังดวงจันทร์หนุนเรื่องความสัมพันธ์ ทักคนที่คิดถึงได้เลย','ระวังคำพูดที่หลุดโดยไม่ตั้งใจ ช้าลงอีกนิดจะดี','โชคเล็ก ๆ เข้ามาทางเพื่อนหรือคนรู้จัก'];
$daily=$lines[crc32(date('Y-m-d'))%count($lines)];
require 'includes/header.php'; ?>
<section class="hero">
<h1>จักรวาลอยู่ในตัวเรา<br>ให้ดวงดาวช่วยบอกทาง</h1>
<p class="sub">Mysticora เว็บดูดวงออนไลน์ที่ผสานโหราศาสตร์ ไพ่ Tarot และ AI เข้าด้วยกัน</p>
<a class="cta" href="horoscope.php">✦ เริ่มดูดวง</a>
<div class="grid">
<a class="panel" href="tarot.php"><div class="ic">🃏</div><b>ไพ่ Tarot</b><small>เลือกไพ่ 3 ใบ อดีต ปัจจุบัน อนาคต</small></a>
<a class="panel" href="love.php"><div class="ic">❤️</div><b>ความรัก</b><small>โสด มีคนคุย มีแฟน หรือไม่แน่ใจ</small></a>
<a class="panel" href="ai.php"><div class="ic">🤖</div><b>AI หมอดู</b><small>ถามอะไรก็ได้ที่คาใจ</small></a>
<a class="panel" href="seers.php"><div class="ic">🧙</div><b>หมอดูตัวจริง</b><small>แชทกับหมอดูที่เป็นคน พร้อมรีวิว</small></a>
</div>
<div class="panel left"><b class="gold">ดวงประจำวัน</b><p><?= e($daily) ?></p></div>
</section>
<?php require 'includes/footer.php'; ?>
