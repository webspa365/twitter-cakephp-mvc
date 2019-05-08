<?= $this->element('../Dialog/tweet_dialog_style') ?>
<?php
  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');

  $msg = '';
?>
<?php if(isset($auth)) : ?>
<div class='tweetDialog' onclick='close_tweet_dialog(event)'>
  <form class='wrapper modal-content' method='POST' action='/tweets/add'>
    <div class='modal-header'>
      <h3>Compose new Tweet</h3>
      <i class='fa fa-times closeDialog' onclick='close_dialog(event)'></i>
    </div>
    <div class='modal-body'>
      <div class='avatar'>
        <i class='fa fa-user'></i>
        <?php echo $avatar; ?>
      </div>
      <div class='textarea'>
        <textarea class='form-control' type='text' name='tweet' placeholder="What's happening?" onkeyup='on_key_up(event)'></textarea>
      </div>
    </div>
    <div class='modal-footer'>
      <?php echo $msg; ?>
      <div>
        <ul class='icons'>
          <li><i class='fa fa-image'></i></li>
          <li><i class='fa fa-camera'></i></li>
          <li><i class='fa fa-map-o'></i></li>
          <li><i class='fa fa-map-marker'></i></li>
        </ul>
        <input id='tweetButton' class='button btn btn-primary tweetButton' type='submit' value='Tweet' />
        <button class='button btn btn-default addButton'><i class='fa fa-plus'></i></button>
      </div>
    </div>
  </form>
</div>
<?php endif; ?>
<script>
function close_tweet_dialog(e) {
  console.log('close_tweet_dialog()');
  e.stopPropagation();
  var list = e.target.classList.toString();
  if(list.indexOf('tweetDialog') > -1 || list.indexOf('closeDialog') > -1) {
    _('.tweetDialog').style.display = 'none';
  }
}

function on_key_up(e) {
  //console.log(e.target.value.length);
  var len = e.target.value.length;
  if(len > 1) $('.tweetButton').addClass('active');
  else $('.tweetButton').removeClass('active');
}

function post_tweet() {

}
</script>
