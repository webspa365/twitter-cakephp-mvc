<?php
$auth = '';
$session = $this->request->session();
$auth = (object)$session->read('Auth.User');
?>
<script>
var auth = <?php echo json_encode($auth); ?>;
//console.log('auth.username='+auth.username);

function post_like(id) {
  console.log('post_like('+id+')');
  if(!auth.id) {
    window.location.href = '/login';
    return;
  }
  $.ajax({
    url: '/likes/add',
    type: 'POST',
    data: {userId: auth.id, tweetId: id},
    //data: {"_token": "{{ csrf_token() }}", id: id},
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success) {
        // update data
        for(var t of tweets) {
          console.log(t);
          if(t.id === parseInt(id)) {
            console.log(t.id+'='+id);
            t.likes = res.tweetLikes;
            t.liked = res.liked;
            console.log('update id='+t.id);
            console.log('updated t.likes='+t.likes);
            console.log('updated t.liked='+t.liked);
            break;
          }
        }

        // update tweet likeIcon
        var tweet = $('.tweet-'+id);
        if(tweet) {
          if(res.liked) tweet.find('.likeIcon i').addClass('active');
          else tweet.find('.likeIcon i').removeClass('active');
          tweet.find('.likeIcon span').html(res.tweetLikes);
        }

        // update reply likeIcon
        var reply = $('#reply-'+id);
        if(reply) {
          if(res.liked) reply.find('.likeIcon i').addClass('active');
          else reply.find('.likeIcon i').removeClass('active');
          reply.find('.likeIcon span').html(res.tweetLikes);
        }

        // update profile likes
        if(auth) {
          var username = tweet.attr('username');
          if(username === auth.username) {
            $('.profile-likes').html(res.userLikes);
          }
        }
      }
    }
  });
}

function post_retweet(id) {
  console.log('post_retweet('+id+')');
  if(!auth.id) {
    window.location.href = '/login';
    return;
  }
  $.ajax({
    url: '/retweets/add',
    type: 'POST',
    data: {username: auth.username, userId: auth.id, tweetId: id},
    //data: {"_token": "{{ csrf_token() }}", id: id},
    success: function(res) {
      console.log(JSON.stringify(res));
      if(res.success) {
        // update data
        for(var t of tweets) {
          if(t.id === parseInt(id)) {
            t.retweets = res.tweetRetweets;
            t.retweeted = res.retweeted;
          }
        }

        // update tweet retweetIcon
        var tweet = $('.tweet-'+id);
        if(tweet) {
          if(res.retweeted) tweet.find('.retweetIcon i').addClass('active');
          else tweet.find('.retweetIcon i').removeClass('active');
          tweet.find('.retweetIcon span').html(res.tweetRetweets);
        }

        // update reply retweetIcon
        var reply = $('#reply-'+id);
        if(reply) {
          if(res.retweeted) reply.find('.retweetIcon i').addClass('active');
          else reply.find('.retweetIcon i').removeClass('active');
          reply.find('.retweetIcon span').html(res.tweetRetweets);
        }
      }
    }
  });
}
</script>
