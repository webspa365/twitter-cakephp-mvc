<?= $this->element('../Auth/login_style'); ?>
<div class='logIn'>
  <header>
    <i class='fa fa-twitter'></i>
    <h1>Log In to Twitter</h1>
  </header>
  <form method="post" action="/users/login">
    <div class="form-group">
      <label>Username:</label>
      <input type="text" class="form-control" id="username" name="username" value=<?php echo $username; ?> >
    </div>
    <div class="form-group">
      <label>Password:</label>
      <input type="password" class="form-control" id="password" name="password" />
      <?php if(isset($err)) : ?>
        <span class="err">
            <strong><?php echo $err; ?></strong>
        </span>
      <?php endif; ?>
    </div>
    <div class="form-group">
      <label class='msg'></label>
      <input type="submit" class="form-control button" id="login" value="Log In" />
    </div>
  </form>
  <div class='toSignUp'>
    <p>New to Twitter? <span onclick='switch_form("signup")'>Sign up now »</span></p>
  </div>
</div>

<script>
var username = $('#username');
var password = $('#password');
var msg = $('.msg');
</script>
