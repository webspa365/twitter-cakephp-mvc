<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tweets Controller
 *
 * @property \App\Model\Table\TweetsTable $Tweets
 *
 * @method \App\Model\Entity\Tweet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TweetsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $tweets = $this->paginate($this->Tweets);

        $this->set(compact('tweets'));
    }

    /**
     * View method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tweet = $this->Tweets->get($id, [
            'contain' => []
        ]);

        $this->set('tweet', $tweet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Users');
        error_log('TweetsController add()');
        $tweet = $this->Tweets->newEntity();
        $auth = $this->Auth->User();
        if ($this->request->is('post') && isset($auth)) {
            $auth = $this->Auth->user();
            $tweet = $this->Tweets->patchEntity($tweet, $this->request->getData());
            $tweet->userId = $auth['id'];
            $tweet->username = $auth['username'];
            error_log('TweetsController add() $tweet='.json_encode($tweet));
            if ($this->Tweets->save($tweet)) {
              //$this->Flash->success(__('The tweet has been saved.'));
              error_log('The tweet has been saved.');

              // update user tweets
              $user = $this->Users->get($auth['id']);
              $user = count_tweets($this, $user->id);
            } else {
              //$this->Flash->error(__('The tweet could not be saved. Please, try again.'));
              error_log('The tweet could not be saved. Please, try again.');
            }
            return $this->redirect('/profile/tweets/'.$tweet->username);
        }
        $this->set(compact('tweet'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tweet = $this->Tweets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tweet = $this->Tweets->patchEntity($tweet, $this->request->getData());
            if ($this->Tweets->save($tweet)) {
                $this->Flash->success(__('The tweet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tweet could not be saved. Please, try again.'));
        }
        $this->set(compact('tweet'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tweet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $id = $this->request->id;
        error_log('TweetsController $id='.$id);
        error_log('get json = '.$this->request->data['id']);
        $this->request->allowMethod(['post', 'delete']);
        $tweet = $this->Tweets->get($id);
        $userId = $tweet->userId;
        if ($this->Tweets->delete($tweet)) {
            //$this->Flash->success(__('The tweet has been deleted.'));
            error_log('The tweet has been deleted.');

            // count current tweets
            count_tweets($this, $userId);

            $this->set([
              'data' => [
                'success' => true,
                'msg' => 'The tweet has been deleted.'
              ],
              '_serialize' => 'data',
            ]);

            //return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/profile/tweets/'.$userId);
        } else {
            //$this->Flash->error(__('The tweet could not be deleted. Please, try again.'));
            error_log('The tweet could not be deleted. Please, try again.');

            count_tweets($this, $userId);

            $this->set([
              'data' => [
                'success' => false,
                'msg' => 'The tweet could not be deleted. Please, try again.'
              ],
              '_serialize' => 'data',
            ]);
            //return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/profile/tweets/'.$userId);
        }

        //$this->RequestHandler->renderAs($this, 'json');

        //return $this->redirect(['action' => 'index']);
        //return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/profile/tweets/'.$userId);
    }
}

function count_tweets($th, $userId) {
  $user = $th->loadModel('Users')->get($userId);
  $tweets = $th->loadModel('Tweets')->find()->where(['userId' => $user->id])->select('id')->toArray();
  $count = count($tweets);
  $user->tweets = $count;
  $th->Users->save($user);
  return $user;

}
