<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Retweets Controller
 *
 *
 * @method \App\Model\Entity\Retweet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RetweetsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $retweets = $this->paginate($this->Retweets);

        $this->set(compact('retweets'));
    }

    /**
     * View method
     *
     * @param string|null $id Retweet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $retweet = $this->Retweets->get($id, [
            'contain' => []
        ]);

        $this->set('retweet', $retweet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        error_log('RetweetsController add() tweetId='.$this->request->data['tweetId']);
        if ($this->request->is('post')) {

          $username = $this->request->data['username'];
          $userId = $this->request->data['userId'];
          $tweetId = $this->request->data['tweetId'];
          $success = false;
          $retweeted = false;

          // get like if already exits
          $r = $this->Retweets->find()->where(['userId' => $userId])->where(['tweetId' => $tweetId])->first();

          error_log('$r='.json_encode($r));

          if(isset($r) === false) {
            // new retweet
            error_log('new retweet');
            $retweet = $this->Retweets->newEntity();
            $retweet = $this->Retweets->patchEntity($retweet, $this->request->getData());
            $retweet->username = $username;
            $retweet->boolean = true;
            $retweeted = true;
            if ($this->Retweets->save($retweet)) {
              error_log('saved new retweet');
              $success = true;
            } else {
              error_log('not saved new retweet');
            }
          } else {
            if($r->boolean) {
              // remove retweet
              $r->boolean = false;
              if ($this->Retweets->save($r)) {
                error_log('removed retweet');
                $success = true;
                $retweeted = false;
              }
            } else {
              // retweet again
              $r->boolean = true;
              if ($this->Retweets->save($r)) {
                error_log('retweeted again');
                $success = true;
                $retweeted = true;
              }
            }
          }
      }

      // count tweet retweets
      $tweetRetweets = $this->Retweets->find()->where(['tweetId' => $tweetId])->where(['boolean' => true])->select('id');
      $tweetRetweets = count($tweetRetweets->toArray());

      // save tweet retweets
      $tweet = $this->loadModel('Tweets')->get($tweetId);
      $tweet->retweets = $tweetRetweets;
      $this->Tweets->save($tweet);

      // count user retweets
      $userRetweets = $this->Retweets->find()->where(['userId' => $userId])->where(['boolean' => true])->select('id');
      $userRetweets = count($userRetweets->toArray());

      // save user retweets
      $user = $this->loadModel('Users')->get($userId);
      $user->retweets = $userRetweets;
      $this->Users->save($user);

      //$this->set(compact('like'));
      $this->set([
          'data' => [
            'success' => $success,
            'retweeted' => $retweeted,
            'tweetRetweets' => $tweetRetweets,
            'userRetweets' => $userRetweets
          ],
          '_serialize' => 'data',
      ]);
      $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * Edit method
     *
     * @param string|null $id Retweet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $retweet = $this->Retweets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $retweet = $this->Retweets->patchEntity($retweet, $this->request->getData());
            if ($this->Retweets->save($retweet)) {
                $this->Flash->success(__('The retweet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The retweet could not be saved. Please, try again.'));
        }
        $this->set(compact('retweet'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Retweet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $retweet = $this->Retweets->get($id);
        if ($this->Retweets->delete($retweet)) {
            $this->Flash->success(__('The retweet has been deleted.'));
        } else {
            $this->Flash->error(__('The retweet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
