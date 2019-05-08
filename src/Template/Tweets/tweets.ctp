<?= $this->element('../Tweets/tweets_style'); ?>
<?= $this->element('../Tweets/tweet_style'); ?>
<?php
  //var_dump($tweets);

  $session = $this->request->session();
  $auth = (object)$session->read('Auth.User');
?>
<div class='tweets'>
  <div class='header'>
    <ul class='tweets_ul'>
      <li class='li_tweets active' onclick='get_tweets()'>
        <router-link :to="'/profile?user='+this.username">Tweets</router-link>
      </li>
      <li class='li_replies' onclick='get_replies()'>
        <router-link :to="'/profile/replies?user='+this.username">Tweets & replies</router-link>
      </li>
      <li class='li_media' onclick='get_media()'>
        <router-link :to="'/profile/media?user='+this.username">Media</router-link>
      </li>
    </ul>
  </div>
  <div class='body'>
    <ul>
      <?php if(isset($tweets)) : ?>
        <?php foreach($tweets as $t) : ?>
          <li>
            <?= $this->element('../Tweets/tweet', ['tweet' => $t]); ?>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
  <div v-if='true' class='footer' onclick='show_more()'>
    <span>Show more...</span>
  </div>
  <div else='' class='footer' onclick='back_to_top()'>
    <span>Back to Top</span>
  </div>
</div>

<script>
var tweets = <?php echo json_encode($tweets); ?>;
//console.log('tweets='+JSON.stringify(tweets));
</script>
<?= $this->element('../Tweets/tweet_functions'); ?>
