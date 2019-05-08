<?= $this->element('../Home/timeline_style'); ?>
<?= $this->element('../Tweets/tweet_style'); ?>
<?= $this->element('../Tweets/tweet_functions'); ?>
<?php
  //$tweets = array();
?>
<div class='timeline'>
  <?php if(isset($tweets)) : ?>
    <ul>
      <?php foreach($tweets as $t) : ?>
        <li>
          <?= $this->element('../Tweets/tweet', ['tweet' => $t]); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

<script>
var tweets = <?php echo json_encode($tweets); ?>;
</script>
