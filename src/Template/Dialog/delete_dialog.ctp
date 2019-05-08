<?= $this->element('../Dialog/delete_dialog_style') ?>
<?php
/*
  $authId = -1;
  if(Auth::check()) {
    $authId = Auth::user()->id;
  }
*/
  $auth = '';
  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');

?>
<div class='deleteDialog' id='deleteDialog' onclick='close_dialog(event)'>
  <div class='dialog_wrapper'>
    <div class='header'>
      Delete tweet?
    </div>
    <div class='body'>
      <h6></h6>
      <p></p>
      <div class='msg'></div>
    </div>

    <!--form class='footer' method='POST' action='/tweets/delete'-->
      <!--input class='inputTweetId' type='hidden' name='id' value=''>
      <input class='button btn-danger deleteButton' type='submit' value='Delete'>
    <form-->
    <div class='footer'>
      <button class='button btn-danger deleteButton' onclick='delete_tweet()'>Delete</button>
      <button class='button btn btn-default closeButton' onclick='close_dialog(event)'>Cancel</button>
    </div>
  </div>
</div>

<script>
var auth = <?php echo json_encode($auth); ?>;
var tweetToDelete;

function open_delete_dialog(tweetId) {
  console.log('tweetId='+tweetId);
  var tweet;
  for(var t of tweets) {
    if(t.id === tweetId) {
      tweetToDelete = t;
    }
  }
  var dialog = _id('deleteDialog');
  dialog.style.display = 'block';
  dialog.querySelector('body h6').innerHTML = '@'+tweetToDelete.username;
  dialog.querySelector('body p').innerHTML = tweetToDelete.tweet;
  $('.inputTweetId').val(tweetId);
}

function delete_tweet() {
  console.log('delete_tweet() tweetToDelete.id='+tweetToDelete.id);
  //console.log('jquery='+$('.tweet-'+tweetToDelete.id).css('color', 'red'));
  $.ajax({
    //url: '/tweets/delete/'+tweetToDelete.id,
    url: '/tweets/delete/'+tweetToDelete.id,
    type: 'delete',
    cache: false,
    data: {id: tweetToDelete.id},
    dataType: "json",
    //data: {"_token": "{{ csrf_token() }}"},
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success && auth) {
        window.location.href = '/profile/tweets/'+auth.username;
      } else {

      }
    }
  });
}

function close_dialog(e) {
  var list = e.target.classList.toString();
  if(list.indexOf('deleteDialog') > -1 || list.indexOf('closeButton') > -1) {
    _id('deleteDialog').style.display = 'none';
  }
}
</script>
