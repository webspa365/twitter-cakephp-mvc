<?= $this->element('../Auth/auth_style'); ?>
<div class='auth'>
  <div class='left'>
    <ul>
      <li>
        <i class='fa fa-search'></i>
        <span>Follow your interests.</span>
      </li>
      <li>
        <i class='fa fa-user-o'></i>
        <span>Hear what people are talking about.</span>
      </li>
      <li>
        <i class='fa fa-comment-o'></i>
        <span>Join the conversation.</span>
      </li>
    </ul>
    <div class='bg'><i class='fa fa-twitter'></i></div>
  </div>
  <div class='right' >
    <?php if($form === 'auth') : ?>
      <div class='wrapper'>
        <i class='fa fa-twitter'></i>
        <p>See what’s happening in<br /> the world right now</p>
        <h1>Join Twitter today.</h1>
        <button class='btn btn-primary toSignUp' onclick='switch_form("signup")'>Sign Up</button>
        <button class='btn btn-default toLogIn' onclick='switch_form("login")'>Log In</button>
      </div>
    <?php elseif($form === 'signup') : ?>
      <?= $this->element('../Auth/signup', ['err' => $err, 'username' => $username, 'email' => $email]); ?>
    <?php elseif($form === 'login') : ?>
      <?= $this->element('../Auth/login', ['err' => $err, 'username' => $username]); ?>
    <?php endif; ?>
  </div>
</div>
<script>
function switch_form(name) {
  console.log('switch_form='+name);
  window.location.href = name;
}
</script>
