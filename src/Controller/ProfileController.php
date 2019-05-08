<?php
namespace App\Controller;

use App\Controller\AppController;

include 'functions.php';

/**
 * Profile Controller
 *
 *
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfileController extends AppController
{
    public function editProfile($id) {
        error_log('ProfileController editProfile() $id='.$id);
        // get
        $profile = $this->loadModel('Users')->find()->where(['id' => $id])->first();
        $this->set('profile', $profile);

        // post
        if($this->request->is(['post', 'put'])) {
          error_log('post, put');
          $auth = $this->Auth->user();
          if(!isset($auth) || (int)$auth['id'] !== (int)$id) {
            error_log('Error: $auth='.$auth['id']);
            return $this->redirect('/login');
          }

          $userPath = get_user_path($auth['id']);

          // upload bg
          $bgName = $_FILES['bg']['name'];
          //error_log('$_FILES["bg"]["name"]='.$_FILES['bg']['name']);
          if(!empty($bgName)) {
            error_log('$bgName='.$bgName);
            $bgExt = pathinfo($bgName, PATHINFO_EXTENSION);
            $bgPath = $userPath.'/bg/bg.'.$bgExt;
            error_log('bg $path='.$bgPath);
            if (move_uploaded_file($_FILES['bg']['tmp_name'], $bgPath)) {
              // resize bg
              resize_bg($bgPath);
              // remove old files
              $files = glob($userPath.'/bg/*');
              foreach($files as $f){
                if(isset($f)) {
                  if($f !== $bgPath && $f !== $userPath.'/bg/thumbnail.'.$bgExt) unlink($f);
                }
              }
            }
          }

          // upload avatar
          $avatar = $_FILES['avatar']['name'];
          //error_log('$_FILES["bg"]["name"]='.$_FILES['bg']['name']);
          if(!empty($avatar)) {
            $avaExt = pathinfo($avatar, PATHINFO_EXTENSION);
            $avaPath = $userPath.'/avatar/avatar.'.$avaExt;
            error_log('avatar $path='.$avaPath);
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avaPath)) {
              resize_avatar($avaPath);
              // remove old files
              $files = glob($userPath.'/avatar/*');
              foreach($files as $f){
                if(isset($f)) {
                  if($f !== $avaPath && $f !== $userPath.'/avatar/thumbnail.'.$avaExt) unlink($f);
                }
              }
            }
          }

          // get edited data
          $user = $this->Users->find()->where(['id' => $auth['id']])->first();
          $user->name = $this->request->data('name');
          //$user->username = $this->request->data('username');
          $user->email = $this->request->data('email');
          $user->bio = $this->request->data('bio');
          if(!empty($bg)) $user->bg = $bgExt;
          if(!empty($avatar)) $user->avatar = $avaExt;
          error_log(json_encode($user));
          if ($this->Users->save($user)) {
            error_log('The user has been saved.');
            $this->set('profile', $user);
            return $this->redirect('/profile/tweets/'.$user->username);
          } else {
            error_log('The user has Not been saved.');
          }
        }
    }



    public function getTweets($un) {
        $profile = $this->loadModel('Users')->find()->where(['username' => $un])->first();
        $userId = $profile->id;
        error_log('ProfileController getTweets() $userId='.$userId);

        // get tweets
        $tweets = array();
        $tweets = $this->loadModel('Tweets')->find()->limit(30)->order(['id' => 'desc'])->where(['userId' => $userId])->toArray();
        if(isset($tweets)) {
          foreach($tweets as $t) {
            $t->time = strtotime($t->created_at);
            $t->avatar = $this->loadModel('Users')->find()->where(['id' => $userId])->select('avatar')->first()->avatar;
          }

          // get retweets
          $retweets = array();
          $rows = $this->loadModel('Retweets')->find()->where(['userId' => $userId, 'boolean' => true])->toArray();
          if(isset($rows)) {
            foreach($rows as $r) {
              $retweet = $this->loadModel('Tweets')->find()->where(['id' => $r->tweetId])->first();
              if(isset($retweet)) {
                $retweet->retweetedBy = $r->username;
                $retweet->time = strtotime($r->updated_at);
                //error_log('$retweet='.json_encode($retweet));
                array_push($tweets, $retweet);
              }
            }
          }
        }

      // sort by time
      usort($tweets, function($a, $b) {
        return $b->time - $a->time;
      });

      // check auth user already had liked or retweeted
      $auth = $this->Auth->user();
      if(isset($auth) && isset($tweets)) {
        $tweets = check_tweets_by_auth($this, $auth, $tweets);
      }

      $profile = check_profile_by_auth($this, $auth, $profile);

      $tweets = convert_replyTo($this, $tweets);

      $this->set(['profile' => $profile, 'tweets' => $tweets]);
      $this->render('profile');
    }



    public function getLikes($un) {
        $profile = $this->loadModel('Users')->find()->where(['username' => $un])->first();
        $userId = $profile->id;
        error_log('ProfileController $userId='.$userId);

        // get liked tweet ids
        $tweets = array();
        $likes = array();
        $likes = $this->loadModel('Likes')->find()->where(['userId' => $userId, 'boolean' => true])->toArray();
        if(!empty($likes)) {
          foreach($likes as $l) {
            $t = $this->loadModel('Tweets')->find()->where(['id' => $l->tweetId])->first();
            if(isset($t)) {
              $t->time = strtotime($l->updated_at);
              array_push($tweets, $t);
            }
          }
        }

        if(isset($tweets)) {
          // sort by time
          usort($tweets, function($a, $b) {
            return $b->time - $a->time;
          });

          // check auth user already had liked or retweeted
          $auth = $this->Auth->user();
          if(isset($auth) && isset($tweets)) {
            $tweets = check_tweets_by_auth($this, $auth, $tweets);
          }
        }

        $tweets = convert_replyTo($this, $tweets);

        $profile = check_profile_by_auth($this, $auth, $profile);
        $this->set(['profile' => $profile, 'tweets' => $tweets]);
        $this->render('profile');
    }



    public function getFollowing($un) {
        $profile = $this->loadModel('Users')->find()->where(['username' => $un])->first();
        $userId = $profile->id;

        // get following users
        $users = array();
        $rows = $this->loadModel('Relationships')->find()->where(['follower' => $userId, 'boolean' => true])->toArray();
        if(isset($rows)) {
          foreach($rows as $r) {
            $u = $this->Users->find()->where(['id' => $r->followed])->first();
            if(isset($u)) {
              $u->time = strtotime($r->updated_at);
              array_push($users, $u);
            }
          }

          // sort users
          usort($users, function($a, $b) {
            return $b->time - $a->time;
          });

          // check auth user already had followed
          $auth = $this->Auth->user();
          if(isset($auth) && isset($users)) {
            $users = check_users_by_auth($this, $auth, $users);
          }
        }

        $profile = check_profile_by_auth($this, $auth, $profile);
        $this->set(['profile' => $profile, 'users' => $users]);
        $this->render('profile');
    }



    public function getFollowers($un) {
        $profile = $this->loadModel('Users')->find()->where(['username' => $un])->first();
        $userId = $profile->id;

        // get followers
        $users = array();
        $rows = $this->loadModel('Relationships')->find()->where(['followed' => $userId, 'boolean' => true])->toArray();
        if(isset($rows)) {
          foreach($rows as $r) {
            $u = $this->Users->find()->where(['id' => $r->follower])->first();
            if(isset($u)) {
              $u->time = strtotime($r->updated_at);
              array_push($users, $u);
            }
          }

          // sort users
          usort($users, function($a, $b) {
            return $b->time - $a->time;
          });

          // check auth user already had followed
          $auth = $this->Auth->user();
          if(isset($auth) && isset($users)) {
            $users = check_users_by_auth($this, $auth, $users);
          }
        }

        $profile = check_profile_by_auth($this, $auth, $profile);
        $this->set(['profile' => $profile, 'users' => $users]);
        $this->render('profile');
    }
}
