<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Relationships Controller
 *
 * @property \App\Model\Table\RelationshipsTable $Relationships
 *
 * @method \App\Model\Entity\Relationship[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RelationshipsController extends AppController
{
    public function add() {
      error_log('RelationshipsController follow()');
      if($this->request->is('post')) {
        $this->loadModel('Relationships');
        $this->loadModel('Users');
        $userId = $this->request->data['userId'];
        $authId = $this->Auth->user()['id'];
        $success = false;
        $followed = false;

        $rel = $this->Relationships->find()->where(['follower' => $authId, 'followed' => $userId])->first();

        if(!isset($rel)) {
          // new follow
          $new = $this->Relationships->newEntity();
          $new->follower = $authId;
          $new->followed = $userId;
          $new->boolean = true;
          if($this->Relationships->save($new)) {
            $success = true;
            $followed = true;
          }
        } else {
          if($rel->boolean) {
            // unfollow
            $rel->boolean = false;
          } else {
            // follow again
            $rel->boolean = true;
            $followed = true;
          }
          if($this->Relationships->save($rel)) {
            $success = true;
          }
        }

        // update user followers
        $user = array();
        $followers = $this->Relationships->find()->where(['followed' => $userId, 'boolean' => true])->select('id')->toArray();
        $followers = count($followers);
        $user = $this->Users->find()->where(['id' => $userId])->first();
        $user->followers = $followers;
        $this->Users->save($user);

        // update auth following
        $user = array();
        $following = $this->Relationships->find()->where(['follower' => $authId, 'boolean' => true])->select('id')->toArray();
        $following = count($following);
        $user = $this->Users->find()->where(['id' => $authId])->first();
        $user->following = $following;
        $this->Users->save($user);


        // response
        $this->set([
            'data' => [
              'success' => $success,
              'followed' => $followed,
              'profileFollowers' => $followers
            ],
            '_serialize' => 'data',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
      }
    }
}
