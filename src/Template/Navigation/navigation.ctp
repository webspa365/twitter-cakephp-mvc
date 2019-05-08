<?= $this->element('../Navigation/navigation_style'); ?>
<nav class='navigation'>
  <?php
    $links = array('', '', '', '');
    $url = $this->request->here(false);
    if(strrpos($url, '/home') > -1) $links[0] = 'active';
    else if(strrpos($url, '/moments') > -1) $links[1] = 'active';
    else if(strrpos($url, '/notifications') > -1) $links[2] = 'active';
    else if(strrpos($url, '/messages') > -1) $links[3] = 'active';

    $session = $this->request->session();
    $auth = (object)$session->read('Auth.User');

    $avatar = '';
    if(isset($auth->avatar)) {
      $avatar = '/media/'.$auth->id.'/avatar/thumbnail.'.$auth->avatar;
    }
  ?>
  <ul>
    <li class='left <?php echo $links[0]; ?>'>
      <a href='/home' ><i class='fa fa-home'></i><span>Home</span></a>
    </li>
    <li class='left <?php echo $links[1]; ?>'>
      <a href='/moments' ><i class='fa fa-bolt'></i><span>Moments</span></a>
    </li>
    <li class='left <?php echo $links[2]; ?>'>
      <a href='/notifications' ><i class='fa fa-bell-o'></i><span>Notifications</span></a>
    </li>
    <li class='left <?php echo $links[3]; ?>'>
      <a href='/messages' ><i class='fa fa-envelope-o'></i><span>Messages</span></a>
    </li>
    <li class='center'>
      <div class='twitter'><i class='fa fa-twitter'></i></div>
      <div class='center_loader spinner_wrapper'>
        <div class='spinner'></div>
      </div>
    </li>
    <li class='right li_post'><div onclick='open_tweet_dialog()'>Tweet</div></li>
    <li class='right li_user' onclick='show_menu()'>
      <div>
        <?php if(empty($avatar)) : ?>
          <i class='fa fa-user'></i>
        <?php else : ?>
          <img src=<?php echo $avatar; ?> onerror="this.style.display='none'" />
        <?php endif; ?>
      </div>
      <?= $this->element('../Navigation/nav_menu'); ?>
    </li>
    <li class='right li_search'><Search /></li>
  </ul>
  <?= $this->element('../Dialog/tweet_dialog'); ?>
  <?= $this->element('../Dialog/delete_dialog'); ?>
  <?= $this->element('../Dialog/reply_dialog'); ?>
  <?= $this->element('../Dialog/replies'); ?>
</nav>

<script>
spin_center(false);

function spin_center(loading) {
  if(loading) {
    _('.twitter').style.display = 'none';
    _('.center_loader').style.display = 'block';
  } else {
    _('.twitter').style.display = 'block';
    _('.center_loader').style.display = 'none';
  }
}

function show_menu() {
  console.log('show_menu()');
  var auth = <?php echo json_encode($auth); ?>;
  if(auth.id) {
    $('.navMenu').toggle();
  } else {
    window.location.href = '/login'

  }
}

function open_tweet_dialog() {
  console.log('open_tweet_dialog()');
  $('.tweetDialog').toggle();
}

function add_active(index) {
  var li = $('.navigation > ul > li').eq(index);
  li.addClass('active');
}
</script>
