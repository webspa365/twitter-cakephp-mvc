<?= $this->element('../Navigation/nav_menu_style'); ?>
<?php
/*
  Auth::user() = (object)[
    'name' => '',
    'username' => 'username',
    'following' => 0,
    'followers' => 0,
    'likes' => 0
  ];
*/
  //$auth = Auth::user();
  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');

  //var_dump($auth);
?>
<?php if(isset($auth)) : ?>
<div class='navMenu'>
  <div><div></div></div>
  <ul>
    <li class='' onclick='to_profile()'>
      <a href=<?php echo '/profile/tweets/'.$auth->username; ?>>
        <span><?php echo $auth->name; ?></span>
        <span><?php echo '@'.$auth->username; ?></span>
      </a>
    </li>
    <li class='following'>
      <a href=<?php echo '/profile/following/'.$auth->username; ?>>
        <?php echo $auth->following; ?> Following
      </a>
    </li>
    <li class='followers'>
      <a href=<?php echo '/profile/followers/'.$auth->username; ?>>
        <?php echo $auth->followers; ?> Followers
      </a>
    </li>
    <li class='likes'>
      <a href=<?php echo '/profile/likes/'.$auth->username; ?>>
        <?php echo $auth->likes; ?> Likes
      </a>
    </li>
    <li class='logout'><a href='/logout'>Log out</a></li>
  </ul>
</div>
<?php endif; ?>

<script>
function to_profile() {

}

function log_out() {

}
</script>
