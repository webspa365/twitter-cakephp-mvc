<?= $this->element('../Dialog/reply_dialog_style'); ?>
<?php
  $msg = '';
  $avatar = '';

?>
<div class='replyDialog' onclick='close_dialog(event)'>
    <form class='wrapper modal-content' method='post' action='/replies/add'>
      <div class='modal-header'>
        <h3></h3>
        <i class='fa fa-times closeButton' onclick='close_dialog(event)'></i>
      </div>
      <div class='replyTo'>
        <?= $this->element('../Tweets/reply'); ?>
      </div>
      <div class='modal-body'>
        <div class='replying'>
          <span>Replying to @</span>
        </div>
        <div class='textarea'>
          <textarea class='form-control replyText' name='text' placeholder='Tweet your reply'></textarea>
        </div>
        <input class='inputReplyTo' type='hidden' name='replyTo' value=''>
      </div>
      <div class='modal-footer'>
        <span class='msg'><?php echo $msg; ?></span>
        <div>
          <ul class='icons'>
            <li><i class='fa fa-image'></i></li>
            <li><i class='fa fa-camera'></i></li>
            <li><i class='fa fa-map-o'></i></li>
            <li><i class='fa fa-map-marker'></i></li>
          </ul>
          <button class='btn btn-default addButton'><i class='fa fa-plus'></i></button>
          <!--button class='btn btn-primary replyButton' onclick='post_reply()'>Reply</button-->
          <input class='btn btn-primary replyButton' type='submit' value='Reply'>
        </div>
      </div>
    </form>
</div>


<script>
var replyTo = {};

function close_dialog(e) {
  console.log('close_dialog()');
  var classList = e.target.classList.toString();
  if(classList.indexOf('replyDialog') > -1 || classList.indexOf('closeButton') > -1) {
    replyTo = {};
    _('.replyDialog').style.display = 'none';
  }
}

function open_reply_dialog(id) {
  if(!auth) {
    window.location.href = '/login';
    return;
  }

  // get this tweet data
  for(t of tweets) {
    if(t.id === id) {
      replyTo = t;
      break;
    }
  }
  console.log('replyTo='+JSON.stringify(replyTo));
  set_reply_data('.replyDialog .reply', replyTo);
  $('.replyDialog .replying').html('Replying to @'+replyTo.username);
  // set data
  var dialog = _('.replyDialog');
  var name = (replyTo.name) ? reply.name : '';
  dialog.querySelector('h3').innerHTML = 'Reply to '+name+'@'+replyTo.username;
  dialog.querySelector('.inputReplyTo').value = replyTo.id;
  dialog.style.display = 'block';
}

/*
function post_reply() {
  console.log('post_reply()');
  $.ajax({
    url: '/replies/add',
    type: 'POST',
    data: {replyTo: replyTo.id, },
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success) {

      }
    }
  });
}
*/
</script>
