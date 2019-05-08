<?= $this->element('../Dialog/replies_style'); ?>
<?php
  $msg = '';
?>
<div class='replies' onclick='close_replies(event)'>
    <div class='wrapper'>
      <div class='replied'>
        <!--Tweet v-if='this.$store.state.replied' :data='this.$store.state.replied' /-->
        <?= $this->element('../Tweets/reply'); ?>
        <!--div v-else class='notFound' style='color: #888'><?php echo $msg; ?>t</div-->
      </div>
      <div class='header'>
        <div class='input'>
          <input class='form-control' placeholder='Tweet your reply'>
          <i class='fa fa-image'></i>
        </div>
        <div class='avatar'>
          <!--img src=''-->
          <i class='fa fa-user'></i>
        </div>
      </div>
      <div class='body'>
        <ul>
          <!--li v-for='reply in this.$store.state.replies'><Tweet :data='reply' /></li-->
          <li>

          </li>
        </ul>
      </div>
      <div class='footer'>
        <span>Show more replies</span>
      </div>
    </div>
</div>

<script>

function close_replies(e) {
  var classList = e.target.classList.toString();
  if(classList.indexOf('replies') > -1 || classList.indexOf('closeButton') > -1) {
    //this.msg = '';
    $('.replies .body ul').html('');
    _('.replies').style.display = 'none';
  }
}

function open_replies(e, parentId) {
  classList = e.target.classList.toString();
  console.log('open_replies('+parentId+') classList='+classList);
  if(classList.indexOf('fa') > -1 || classList.indexOf('replying') > -1) {
    return;
  } else {
    _('.replies').style.display = 'block';
    _('.replies .body ul').innerHTML = '';
  }

  get_parent_of_replies(parentId);
  get_replies(parentId);
}

function open_replied(e, parentId) {
  classList = e.target.classList.toString();
  console.log('open_replies('+parentId+') classList='+classList);
  if(classList.indexOf('fa') > -1) {
    return;
  } else {
    _('.replies').style.display = 'block';
    _('.replies .body ul').innerHTML = '';

  }

  get_parent_of_replies(parentId);
  get_replies(parentId);
}

function get_parent_of_replies(parentId) {
  var reply = $('.replies .reply');
  reply.attr('id', 'reply-'+parentId);
  // get data
  for(var t of tweets) {
    if(t.id === parseInt(parentId)) {
      set_reply_data('#reply-'+parentId, t);
      break;
    }
  }
}

function get_replies(parentId) {
  $.ajax({
    url: '/replies/index',
    type: 'GET',
    data: {tweetId: parentId},
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success && res.tweets) {
        var replies = res.tweets;
        var ul = $('.replies .body ul');
        for(var r of replies) {
          //$('.replies .body ul').append(clone);
          var clone = $('.replies .reply').clone();
          clone = '<li class="reply" id="reply-'+r.id+'">'+clone.html()+'</li>';
          ul.append(clone);
          set_reply_data('#reply-'+r.id, r);
          console.log('ul.append(clone); done');


        }
      }
    }
  });
}

function set_reply_data(id, data) {
  var r = $(id);
  // set name, username and tweet
  r.attr('id', 'reply-'+data.id);
  r.attr('onclick', 'open_replies(event, '+data.id+')');

  r.find('span.name').html(data.name);
  r.find('span.username').html('@'+data.username);
  r.find('.content > p').html(data.tweet);
  // set replyIcon
  r.find('.replyIcon').attr('onclick', 'open_reply_dialog('+data.id+')');

  // set likeIcon
  r.find('.likeIcon').attr('onclick', 'post_like('+data.id+')');
  r.find('.likeIcon span').html(data.likes);
  if(data.liked) r.find('.likeIcon i').addClass('active');
  else r.find('.likeIcon i').removeClass('active');
  // set retweetIcon
  r.find('.retweetIcon').attr('onclick', 'post_retweet('+data.id+')');
  r.find('.retweetIcon span').html(data.retweets);
  if(data.retweeted) r.find('.retweetIcon i').addClass('active');
  else r.find('.retweetIcon i').removeClass('active');
  // set replying parent link
  if(data.replyTo.id) {
    console.log('data.replyTo='+JSON.stringify(data.replyTo));
    r.find('.replyingTo').attr('onclick', 'open_replied(event, '+data.replyTo.id+')');
    r.find('.replying span').html('Replying to @'+data.replyTo.username);
    r.find('.replyingTo').show();
  } else {
    r.find('.replyingTo').hide();
  }
}
</script>
