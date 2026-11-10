<?php require 'includes/config.php';header('Content-Type: application/json; charset=utf-8');
if(!user()){http_response_code(401);exit('{}');}
$uid=user()['id'];$id=(int)($_REQUEST['chat']??0);
$c=db()->prepare('SELECT 1 FROM chats WHERE id=? AND (user_id=? OR seer_id=?)');$c->execute([$id,$uid,$uid]);
if(!$c->fetchColumn()){http_response_code(403);exit('{}');}
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!posted()){http_response_code(400);exit('{}');}
 $b=trim(mb_substr($_POST['body']??'',0,1000));
 if($b!=='')db()->prepare('INSERT INTO messages(chat_id,sender_id,body) VALUES(?,?,?)')->execute([$id,$uid,$b]);}
$s=db()->prepare('SELECT id,sender_id,body,created_at FROM messages WHERE chat_id=? AND id>? ORDER BY id LIMIT 100');
$s->execute([$id,(int)($_REQUEST['after']??0)]);
echo json_encode(['me'=>$uid,'messages'=>$s->fetchAll()],JSON_UNESCAPED_UNICODE);
