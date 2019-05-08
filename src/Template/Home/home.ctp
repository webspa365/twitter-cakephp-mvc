<?= $this->element('../Home/home_style'); ?>
<?php
  $session = $this->request->session();
  $auth = $session->read('Auth.User');

  $avatar = '';
  if(isset($auth['avatar'])) $avatar = '/media/'.$auth['id'].'/avatar/avatar.'.$auth['avatar'];

  $bg = '';
  if(isset($auth['bg'])) $bg = '/media/'.$auth['id'].'/bg/thumbnail.'.$auth['bg'];

  $users = [];
?>
<!--h1 style='margin-top: 50px; text-align: center;'>Home</h1-->
<div class='home container'>
  <div class='left'>
    <?php if(isset($auth)) : ?>
      <div class='authUser'>
        <div class='avatar'>
          <img src=<?php echo $avatar; ?>>
        </div>
        <a class='bg'>
          <img src=<?php echo $bg; ?>>
        </a>
        <div class='content'>
          <h2>
            <span><?php echo $auth['name']; ?></span>
            <span>@<?php echo $auth['username']; ?></span>
          </h2>
          <ul>
            <li>
              <a href="<?php echo '/profile/tweets/'.$auth['username'] ?>">
                <span>Tweets</span>
                <span><?php echo $auth['tweets']; ?></span>
              </a>
            </li>
            <li>
              <a href="<?php echo '/profile/following/'.$auth['username'] ?>">
                <span>Following</span>
                <span><?php echo $auth['following']; ?></span>
              </a>
            </li>
            <li>
              <a href="<?php echo '/profile/followers/'.$auth['username'] ?>">
                <span>Followers</span>
                <span><?php echo $auth['followers']; ?></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class='center'>
    <?= $this->element('../Home/timeline'); ?>
  </div>

  <div class='right'>
    <?php if(isset($auth)) : ?>
      <div class='users'>
        <h3>Who to follow</h3>
        <?php if(isset($users)) : ?>
          <ul>
            <?php foreach($users as $u) : ?>
              <?= $this->element('../Home/right_user', ['user' => $u]); ?>
            <?php endforeach; ?>
          </ul>
        <?php endif;?>
      </div>
    <?php endif; ?>
  </div>
</div>
