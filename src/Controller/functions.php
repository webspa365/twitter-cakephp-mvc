<?php

use App\Controller\AppController;

function check_tweets_by_auth($th, $auth, $tweets) {
    foreach($tweets as $t) {
      // check liked or not
      $l = $th->loadModel('Likes')->find()->where(['userId' => $auth['id'], 'tweetId' => $t->id, 'boolean' => true])->first();
      if(isset($l)) {
        $t->liked = true;
      } else {
        $t->liked = false;
      }
      // check retweeted or not
      $r = $th->loadModel('Retweets')->find()->where(['userId' => $auth['id'], 'tweetId' => $t->id, 'boolean' => true])->first();
      if(isset($r)) {
        $t->retweeted = true;
      } else {
        $t->retweeted = false;
      }
    }
    return $tweets;
}

function check_users_by_auth($th, $auth, $users) {
    foreach($users as $u) {
      // check followed or not
      $r = $th->loadModel('Relationships')->find()->where(['follower' => $auth['id'], 'followed' => $u->id, 'boolean' => true])->first();
      if(isset($r)) {
        $u->followed = true;
      } else {
        $u->followed = false;
      }
    }
    return $users;
}

function check_profile_by_auth($th, $auth, $user) {
    $r = $th->loadModel('Relationships')->find()->where(['follower' => $auth['id'], 'followed' => $user->id, 'boolean' => true])->first();
    if(isset($r)) {
      $user->followed = true;
    } else {
      $user->followed = false;
    }
    return $user;
}

function convert_replyTo($th, $tweets) {
  foreach($tweets as $t) {
    if(isset($t->replyTo)) {
      $un = $th->loadModel('Tweets')->find()->where(['id' => $t->replyTo])->select('username')->first();
      $t->replyTo = json_encode(array('id' => $t->replyTo, 'username' => $un['username']));
    }
  }
  return $tweets;
}

function get_user_path($userId) {
  if(file_exists(WWW_ROOT.'/media/') === false) mkdir(WWW_ROOT.'/'.'media/');
  if(file_exists(WWW_ROOT.'/media/'.$userId) === false) mkdir(WWW_ROOT.'/'.'media/'.$userId);
  if(file_exists(WWW_ROOT.'/media/'.$userId.'/bg') === false) mkdir(WWW_ROOT.'/'.'media/'.$userId.'/bg');
  if(file_exists(WWW_ROOT.'/media/'.$userId.'/avatar') === false) mkdir(WWW_ROOT.'/'.'media/'.$userId.'/avatar');
  return WWW_ROOT.'/'.'media/'.$userId;
}

function resize_bg($path) {
  $size = getimagesize($path);
  $w = $size[0];
  $h = $size[1];
  $new = imagecreatetruecolor(1000, 250);
  $src = get_image_from_path($path);
  imagecopyresampled($new, $src, 0, 0, 0, 0, 1000, 250,  $w, $w/4);
  $success = save_image_to_path($new, $path);
  error_log('resize_bg() save_image_to_path($new, $path)='.$success);
  // create bg thumbnail
  $dir = pathinfo($path, PATHINFO_DIRNAME);
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  $thumb = imagecreatetruecolor(300, 75);
  imagecopyresampled($thumb, $src, 0, 0, 0, 0, 300, 75,  $w, $w/4);
  $success = save_image_to_path($thumb, $dir.'/thumbnail.'.$ext);
  error_log('resize_bg() save_image_to_path($thumb, $path)='.$success);
}

function resize_avatar($path) {
  $size = getimagesize($path);
  $w = $size[0];
  $h = $size[1];
  $new = imagecreatetruecolor(200, 200);
  $src = get_image_from_path($path);
  if($w < $h) imagecopyresampled($new, $src, 0, 0, 0, 0, 200, 200,  $w, $w);
  else imagecopyresampled($new, $src, 0, 0, 0, 0, 200, 200,  $h, $h);
  $success = save_image_to_path($new, $path);
  error_log('resize_avatar() save_image_to_path($new, $path)='.$success);
  // create avatar thumbnail
  $dir = pathinfo($path, PATHINFO_DIRNAME);
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  $thumb = imagecreatetruecolor(75, 75);
  if($w < $h) imagecopyresampled($thumb, $src, 0, 0, 0, 0, 75, 75,  $w, $w);
  else imagecopyresampled($thumb, $src, 0, 0, 0, 0, 75, 75,  $h, $h);
  $success = save_image_to_path($thumb, $dir.'/thumbnail.'.$ext);
  error_log('resize_avatar() save_image_to_path($thumb, $path)='.$success);
}

function get_image_from_path($path) {
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  if($ext === 'jpeg' || $ext === 'jpg') $image = imagecreatefromjpeg($path);
  elseif($ext === 'png') $image = imagecreatefrompng($path);
  elseif($ext === 'gif') $image = imagecreatefromgif($path);
  else $image = null;
  return $image;
}

function save_image_to_path($image, $path) {
  $success = false;
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  if($ext === 'jpeg' || $ext === 'jpg') $success = imagejpeg($image, $path);
  elseif($ext === 'png') $success = imagepng($image, $path);
  elseif($ext === 'gif') $success = imagegif($image, $path);
  return $success;
}
