<?= $this->element('../Profile/edit_profile_style'); ?>
<?php
  $bg = '';
  if(isset($profile->bg)) {
    $bg = '/media/'.$profile->id.'/bg/bg.'.$profile->bg;
  }

  $avatar = '';
  if(isset($profile->avatar)) {
    $avatar = '/media/'.$profile->id.'/avatar/avatar.'.$profile->avatar;
  }

  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');

  //var_dump($profile);
?>
<form class='editProfile' method='post' action=<?php echo '/profile/editProfile/'.$profile->id; ?> enctype='multipart/form-data'>
  <div class='bg'>
    <img id='img_bg' src=<?php echo $bg; ?> />
    <div class='message'>
      <i class='fa fa-camera'></i><br />
      <span>Add a header photo</span>
      <input id='input_bg' class='form-control' type='file' name='bg' onchange='change_bg(event)' />
    </div>
  </div>
  <div class='nav'>
    <div class='container'>
      <div class='avatar'>
        <img id='img_avatar' src=<?php echo $avatar; ?> />
        <div class='message'>
          <i class='fa fa-image'></i><br />
          <span>Change your profile photo</span>
        </div>
        <input id='input_avatar' class='form-control' type='file' name='avatar' onchange='change_avatar(event)' />
      </div>
      <input class='button btn btn-default' type='submit' value='Save cahnges' />
      <a class='button btn btn-default' href=<?php echo '/profile/tweets/'.$profile->username; ?>>Cancel</a>
    </div>
  </div>
  <div class='main'>
    <div class='container'>
      <div class='left'>
        <div class='info'>
          <label>Name:</label>
          <input class='name form-control' type='text' name='name' value=<?php echo $profile->name; ?> />
          <label>Username:</label>
          <input class='username form-control' type='text' name='username' value=<?php echo $profile->username; ?> required />
          <label>Email:</label>
          <input class='email form-control' type='text' name='email' value=<?php echo $profile->email; ?> required />
          <label>Bio:</label>
          <textarea class='bio form-control' type='text' name='bio'><?php echo $profile->bio; ?></textarea>
        </div>
      </div>
    </div>
  </div>
</form>


<script>
function change_bg(e) {
  console.log(e.target.files[0]);
  var src = URL.createObjectURL(e.target.files[0]);
  var bg = _id('img_bg');
  bg.setAttribute('src', src);
  var img = new Image();
  img.src = src;
  img.onload = () => {
    var w = img.naturalWidth;
    var h = img.naturalHeight;
    console.log('change_bg() w/h='+w+'/'+h);
    if((w/h) > 4) {
      bg.style.width = 'auto';
      bg.style.height = '100%';
      bg.style.maxWidth = 'auto';
      bg.style.maxHeight = '100%';
    }
  }
}

function change_avatar(e) {
  this.avatar = e.target.files[0];
  var src = URL.createObjectURL(e.target.files[0]);
  var avatar = _id('img_avatar');
  avatar.setAttribute('src', src);
  var img = new Image();
  img.src = src;
  img.onload = () => {
    var w = img.naturalWidth;
    var h = img.naturalHeight;
    console.log('change_avatar() w/h='+w+'/'+h);
    if(w > h) {
      avatar.style.width = 'auto';
      avatar.style.height = '100%';
      avatar.style.maxWidth = (200*w/h)+'px';
      avatar.style.maxHeight = '200px';
    } else {
      avatar.style.width = '100%';
      avatar.style.height = 'auto';
      avatar.style.maxWidth = '200px';
      avatar.style.maxHeight = (200*h/w)+'px';
    }
  }
}
</script>
