<?= $this->element('../Profile/profile_style'); ?>
<?php
  $links = array('', '', '', '');
  //$url = $this->here; //url()->current();
  $url = '_'.$this->request->here(false);
  //echo $url;
  if(strrpos($url, '/profile/tweets/')) $links[0] = 'active';
  else if(strrpos($url, '/profile/following/')) $links[1] = 'active';
  else if(strrpos($url, '/profile/followers/')) $links[2] = 'active';
  else if(strrpos($url, '/profile/likes/')) $links[3] = 'active';

  $session = $this->request->session();
  $auth = $session->read('Auth.User');

  $bg = '';
  if(isset($profile->bg)) {
    $bg = '/media/'.$profile->id.'/bg/bg.'.$profile->bg;
  }

  $avatar = '';
  if(isset($profile->avatar)) {
    $avatar = '/media/'.$profile->id.'/avatar/avatar.'.$profile->avatar;
  }

  // get created date
  $time = strtotime($profile->created_at);
  $date = 'Joined '.date('M', $time).' '.date('Y', $time);
?>
<div class='profile'>
  <div class='bg'>
    <img src=<?php echo $bg; ?> onerror="this.style.display='none'" />
  </div>
  <div class='nav'>
    <div class='container'>
      <a class='avatar' href=<?php echo 'profile/tweets/'.$profile->id; ?>>
        <img src=<?php echo $avatar ?> onerror="this.style.display='none'" />
      </a>
      <ul class='profile_ul'>
        <li class=<?php echo $links[0]; ?>>
          <a href=<?php echo '/profile/tweets/'.$profile->username; ?>>
            <span>Tweets</span>
            <span class='profile-tweets'><?php echo $profile->tweets; ?></span>
          </a>
        </li>
        <li class=<?php echo $links[1]; ?>>
          <a href=<?php echo '/profile/following/'.$profile->username; ?>>
            <span>Following</span>
            <span class='profile-following'><?php echo $profile->following; ?></span>
          </a>
        </li>
        <li class=<?php echo $links[2]; ?>>
          <a href=<?php echo '/profile/followers/'.$profile->username; ?>>
            <span>Followers</span>
            <span class='profile-followers'><?php echo $profile->followers; ?></span>
          </a>
        </li>
        <li class=<?php echo $links[3]; ?>>
          <a href=<?php echo '/profile/likes/'.$profile->username; ?>>
            <span>Likes</span>
            <span class='profile-likes'><?php echo $profile->likes; ?></span>
          </a>
        </li>
      </ul>
      <?php if(isset($auth) && $profile->username === $auth['username']) : ?>
        <button class='btn btn-default edit' onclick='edit_profile(<?php echo $auth['id']; ?>)'>
          Edit Profile
        </button>
      <?php elseif($profile->followed === true) : ?>
        <button class='btn btn-primary follow followed' onclick='follow_profile(<?php echo $profile->id; ?>)'></button>
      <?php elseif($profile->followed === false) : ?>
        <button class='btn btn-primary follow' onclick='follow_profile(<?php echo $profile->id; ?>)'></button>
      <?php endif; ?>
    </div>
  </div>
  <div class='main container'>
   <div>
     <div class='left'>
       <div class='content'>
          <h1>
            <span class='name'><?php echo $profile->name; ?></span>
            <span class='username'><?php echo '@'.$profile->username; ?></span>
          </h1>
          <p class='bio'><?php echo $profile->bio; ?></p>
          <div class='date'>
            <i class='fa fa-calendar'></i>
            <?php echo $date; ?>
          </div>
        </div>
      </div>
      <div class='center'>
        <?php if($links[0] || $links[3]) : ?>
          <div class='col-lg-8'>
            <?= $this->element('../Tweets/tweets'); ?>
          </div>
          <div class='col-lg-4'>
          </div>
        <?php else : ?>
          <ul class='users'>
            <?php if(count($users) > 0) : ?>
              <?php foreach($users as $u) : ?>
                <?= $this->element('../Profile/user', ['user' => $u]); ?>
              <?php endforeach; ?>
              <?php for($i=0; $i<100; $i++) : ?>
                <!--?= $this->element('../Profile/user', ['user' => $u]); ?-->
              <?php endfor; ?>
            <?php endif; ?>
          </ul>
        <?php endif; ?>
      </div>
      <div class='right'>
      </div>
    </div>
  </div>
</div>

<script>
function edit_profile(authId) {
  console.log('edit_profile()');
  window.location.href = '/profile/edit/'+authId;
}

function follow_profile(id) {
  console.log('follow_profile('+id+')');
  $.ajax({
    url: '/relationships/add',
    type: 'POST',
    //data: {"_token": "{{ csrf_token() ; ?>", id: id},
    data: {userId: id},
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success) {
        // update button
        var button = $('.profile .follow');
        if(res.followed) button.addClass('followed');
        else button.removeClass('followed');
        // update followers
        $('.profile-followers').html(res.profileFollowers);
      }
    }
  });
}
</script>
