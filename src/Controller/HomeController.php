<?php
namespace App\Controller;

use App\Controller\AppController;

include 'functions.php';

/**
 * Home Controller
 *
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{
    public function getTimeline() {
      $this->loadModel('Tweets');
      $this->loadModel('Users');
      $this->loadModel('Relationships');

      $auth = $this->Auth->user();
      if(isset($auth) === false) { // if not logged in
        $tweets = $this->Tweets->find('all')->limit(10)->toArray();
        $this->set(['tweets' => $tweets]);
        $this->render('home');
      } else {
        // get following ids
        $ids = array($auth['id']);
        $rows = $this->Relationships->find()->where(['follower' => $auth['id'], 'boolean' => true])->toArray();
        if(isset($rows)) {
          //error_log('$following='.json_encode($rows));
          foreach($rows as $r) {
            array_push($ids, (int)$r->followed);
          }
          //error_log('$ids='.json_encode($ids));

          // get tweets by auth and following
          $tweets = $this->Tweets->find()->limit(100)->order(['id' => 'desc'])->where(['Tweets.userId IN' => $ids])->toArray();
          if(isset($tweets)) {
            foreach($tweets as $t) {
              $t->time = strtotime($t->created_at);
            }
          }

          // check liked or retweeted by auth
          $tweets = check_tweets_by_auth($this, $auth, $tweets);
          // convert replyTo
          $tweets = convert_replyTo($this, $tweets);

          $this->set(['tweets' => $tweets]);
        }
      }

      $this->render('home');
    }
}
