<?= $this->element('../Tweets/tweet_menu_style'); ?>
<?php
  $delete = true;
?>
<div class='tweetMenu' id="<?php echo 'tweetMenu-'.$tweetId; ?>">
  <div><div></div></div>
  <ul>
    <li class='menuItem'>Pin to your profile page</li>
    <li class='menuItem'>Report Tweet</li>
    <?php if($delete) : ?>
      <li class='menuItem' onclick='open_delete_dialog(<?php echo $tweetId; ?>)'>Delete Tweet</li>
    <?php endif; ?>
  </ul>
</div>

<script>
var id = "<?php echo 'tweetMenu-'.$tweetId ?>";
_id(id).style.display = 'none';


</script>
