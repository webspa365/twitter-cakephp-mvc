<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Replies Controller
 *
 * @property \App\Model\Table\RepliesTable $Replies
 *
 * @method \App\Model\Entity\Reply[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RepliesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //$replies = $this->paginate($this->Replies);
        //$this->set(compact('replies'));
        $id = $this->request->query('tweetId');
        error_log('RepliesController index() $tweetId='.$id);
        $replies = $this->Replies->find()->where(['replyTo' => $id])->toArray();
        if(isset($replies)) {
          error_log('$replies='.json_encode($replies));
          $tweets = array();
          foreach($replies as $r) {
            $t = $this->loadModel('Tweets')->find()->where(['id' => $r->replyId])->first();
            if(isset($t)) {
              array_push($tweets, $t);
            }
          }
        }

        $this->set([
            'data' => ['success' => true, 'tweets' => $tweets],
            '_serialize' => 'data',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * View method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => []
        ]);

        $this->set('reply', $reply);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auth = $this->Auth->user();
        if ($this->request->is('post') && isset($auth)) {
          error_log('RepliesController add() data='.json_encode($this->request->data));
          // save as tweet
          $tweet = $this->loadModel('Tweets')->newEntity();
          $tweet->userId = $auth['id'];
          $tweet->username = $auth['username'];
          $tweet->tweet = $this->request->data['text'];
          $tweet->replyTo = $this->request->data['replyTo'];
          if($this->Tweets->save($tweet)) {
            error_log('after Tweets->save() $tweet->id='.$tweet->id);
            // update count tweets
            $tweets = $this->Tweets->find()->where(['userId' => $tweet->userId])->select('id')->toArray();
            $user = $this->loadModel('Users')->get($tweet->userId);
            $user->tweets = count($tweets);
            $this->Users->save($user);
            // save as reply
            $reply = $this->Replies->newEntity();
            $reply->replyId = $tweet->id;
            $reply->replyTo = $tweet->replyTo;
            $this->Replies->save($reply);
          }
          return $this->redirect('/profile/tweets/'.$auth['username']);
        }
        return $this->redirect('/login');
    }

    /**
     * Edit method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reply = $this->Replies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reply = $this->Replies->patchEntity($reply, $this->request->getData());
            if ($this->Replies->save($reply)) {
                $this->Flash->success(__('The reply has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reply could not be saved. Please, try again.'));
        }
        $this->set(compact('reply'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reply id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reply = $this->Replies->get($id);
        if ($this->Replies->delete($reply)) {
            $this->Flash->success(__('The reply has been deleted.'));
        } else {
            $this->Flash->error(__('The reply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function cleanUp() {
        error_log('RepliesController cleanUp()');
        $this->loadModel('Tweets');
        $replies = $this->Replies->find('all')->toArray();
        if(isset($replies)) {
          foreach($replies as $r) {
            $t = $this->Tweets->find()->where(['id' => ''])->first();
          }
        }
        $this->redirect('/login');
    }
}
