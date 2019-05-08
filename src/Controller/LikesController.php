<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Likes Controller
 *
 *
 * @method \App\Model\Entity\Like[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LikesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $likes = $this->paginate($this->Likes);

        $this->set(compact('likes'));
    }

    /**
     * View method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => []
        ]);

        $this->set('like', $like);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        error_log('LikesController add() tweetId='.$this->request->data['tweetId']);
        if ($this->request->is('post')) {

          $userId = $this->request->data['userId'];
          $tweetId = $this->request->data['tweetId'];
          $success = false;
          $liked = false;

          // get like if already exits
          $l = $this->Likes->find()->where(['userId' => $userId])->where(['tweetId' => $tweetId])->first();

          error_log('$l='.json_encode($l));

          if(isset($l) === false) {
            // new like
            $like = $this->Likes->newEntity();
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            $like->boolean = true;
            if ($this->Likes->save($like)) {
              error_log('new like');
              $success = true;
              $liked = true;
            }
          } else {
            if($l->boolean) {
              // unlike
              $l->boolean = false;
              if ($this->Likes->save($l)) {
                error_log('unliked');
                $success = true;
                $liked = false;
              }
            } else {
              // like again
              $l->boolean = true;
              if ($this->Likes->save($l)) {
                error_log('liked again');
                $success = true;
                $liked = true;
              }
            }
          }
        }

        // count tweet likes
        $tweetLikes = $this->Likes->find()->where(['tweetId' => $tweetId])->where(['boolean' => true])->select('id');
        $tweetLikes = count($tweetLikes->toArray());

        // save tweet likes
        $tweet = $this->loadModel('Tweets')->get($tweetId); //find()->where(['id' => $tweetId])->first();
        $tweet->likes = $tweetLikes;
        $this->Tweets->save($tweet);

        // count user likes
        $userLikes = $this->Likes->find()->where(['userId' => $userId])->where(['boolean' => true])->select('id');
        $userLikes = count($userLikes->toArray());

        // save user likes
        $user = $this->loadModel('Users')->get($userId);
        $user->likes = $userLikes;
        $this->Users->save($user);

        //$this->set(compact('like'));
        $this->set([
            'data' => [
              'success' => $success,
              'liked' => $liked,
              'tweetLikes' => $tweetLikes,
              'userLikes' => $userLikes
            ],
            '_serialize' => 'data',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * Edit method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $like = $this->Likes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $like = $this->Likes->patchEntity($like, $this->request->getData());
            if ($this->Likes->save($like)) {
                $this->Flash->success(__('The like has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The like could not be saved. Please, try again.'));
        }
        $this->set(compact('like'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Like id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $like = $this->Likes->get($id);
        if ($this->Likes->delete($like)) {
            $this->Flash->success(__('The like has been deleted.'));
        } else {
            $this->Flash->error(__('The like could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
