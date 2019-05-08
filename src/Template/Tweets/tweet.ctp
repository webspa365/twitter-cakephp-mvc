<?php
  $retweeted = '';
  if($tweet->retweeted) $retweeted = 'active';
  $liked = '';
  if($tweet->liked) $liked = 'active';

  $auth = '';
  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');

  $avatar = '';
  if($tweet->avatar) $avatar = '/media/'.$tweet->userId.'/avatar/thumbnail.'.$tweet->avatar;

  if(isset($tweet->replyTo)) $tweet->replyTo = json_decode($tweet->replyTo);

?>
<div class="<?php echo 'tweet tweet-'.$tweet->id; ?>" onclick='open_replies(event, <?php echo $tweet->id; ?>)'>
  <?php if($tweet->retweetedBy !== '') : ?>
    <div class='retweeted'>
      <i class='fa fa-retweet'></i> <?php echo '@'.$tweet->retweetedBy; ?> retweeted
    </div>
  <?php endif; ?>
  <?php if(isset($tweet->replyTo->username)) : ?>
    <div class='replyingTo replying'>
        <span class='replying' data-replied='replyTo.id' onclick='open_replied(event, <?php echo $tweet->replyTo->id; ?>)'>
          Replying to <?php echo $tweet->replyTo->username; ?>
        </span>
    </div>
  <?php endif; ?>
  <a class='avatar' href="<?php echo '/profile/tweets/'.$tweet->username; ?>">
    <?php if(!empty($avatar)) : ?>
      <img class='avatarImg' src="<?php echo $avatar; ?>" />
    <?php else : ?>
      <i class='fa fa-user'></i>
    <?php endif; ?>
  </a>
  <div class='info'>
    <span class='name'><?php echo $tweet->name; ?></span>
    <span class='username'>
      <a href="<?php echo '/profile/tweets/'.$tweet->username; ?>"><?php echo '@'.$tweet->username; ?></a>
    </span>
    <span class='date'>・</span>
    <div class='toggle' onclick='open_menu("<?php echo 'tweetMenu-'.$tweet->id; ?>")'>
      <?php if(!$tweet->retweetedBy) : ?>
        <i class='fa fa-angle-down'></i>
        <?= $this->element('../Tweets/tweet_menu', ['tweetId' => $tweet->id]); ?>
      <?php endif; ?>
      <!--TweetMenu v-show='menu' :$tweet='$tweet' /-->
    </div>
  </div>
  <div class='content'>
    <p class='tweetText'><?php echo $tweet->tweet; ?></p>
  </div>
  <div class='icons'>
    <div class='replyIcon' onclick='open_reply_dialog(<?php echo $tweet->id; ?>)'>
      <i class='fa fa-comment-o'></i>
      <span class='span'><?php echo $tweet->replies; ?></span>
    </div>
    <div class='retweetIcon' onclick='post_retweet("<?php echo $tweet->id; ?>")'>
      <i class="<?php echo 'fa fa-retweet '.$retweeted; ?>"></i>
      <span class='span'><?php echo $tweet->retweets; ?></span>
    </div>
    <div class='likeIcon' onclick='post_like("<?php echo $tweet->id; ?>")'>
      <i class="<?php echo 'fa fa-heart-o '.$liked; ?>"></i>
      <span class='span'><?php echo $tweet->likes; ?></span>
    </div>
    <div class='chartIcon'>
      <i class='fa fa-bar-chart'></i>
    </div>
  </div>
  <script>
    var tweet = <?php echo json_encode($tweet); ?>;
    var date = get_now(new Date(tweet.created_at).getTime());
    $('.tweet-'+tweet.id).find('.date').html('・'+date);
  </script>
</div>
