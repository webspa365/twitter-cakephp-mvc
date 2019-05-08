<?= $this->element('../Profile/user_style'); ?>
<?php
  $followsYou = '';
  $bg = '/media/'.$user->id.'/bg/thumbnail.'.$user->bg;
  $avatar = '/media/'.$user->id.'/avatar/thumbnail.'.$user->avatar;
?>
<li class='user user-<?php echo $user->id?>'>
  <div class='bg' onclick='click_user("<?php echo $user->username; ?>")'>
    <img src=<?php echo $bg; ?> onerror="this.style.display='none'" />
  </div>
  <div class='avatar' onclick='click_user("<?php echo $user->username; ?>")'>
    <img src=<?php echo $avatar; ?> onerror="this.style.display='none'" />
  </div>
  <div class='content'>
    <h3>
      <span class='name'><?php echo $user->name; ?></span>
      <span class='username' onclick='click_user("<?php echo $user->username; ?>")'><?php echo '@'.$user->username; ?><?php echo $followsYou; ?></span>
    </h3>
    <p class='bio'><?php echo $user->bio; ?></p>
    <?php if($user->followed === 0) : ?>
      <button class='btn btn-default followButton' onclick='follow_user(<?php echo $user->id; ?>)'></button>
    <?php else : ?>
      <button class='btn btn-default followButton followed' onclick='follow_user(<?php echo $user->id; ?>)'></button>
    <?php endif; ?>
  </div>
  <script>
  function follow_user(id) {
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
          var button = $('.user-'+id+' .followButton');
          if(res.followed) button.addClass('followed');
          else button.removeClass('followed');
          // update followers
          //$('.profile-followers').html(res.profileFollowers);
        }
      }
    });
  }
  </script>
</li>

<script>
function click_user(un) {
  console.log('click_user('+un+')');
  window.location.href = '/profile/tweets/'+un;
}
</script>
