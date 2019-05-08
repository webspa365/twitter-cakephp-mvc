<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            error_log('UsersController add() $username='.$this->request->data('username'));
            $username = $this->request->data['username'];
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                //$this->Flash->success(__('The user has been saved.'));
                error_log('The user has been saved.');
                $u = $this->Users->findByUsername($user->username)->first();
                //return $this->redirect(['action' => 'index']);
                return $this->redirect('/profile/tweets/'.$u['username']);
            } else {
              //$this->Flash->error(__('The user could not be saved. Please, try again.'));
              $err = 'The user could not be saved. Please, try again.';
              return $this->redirect('/signup?username='.$username.'&email='.$user->email.'&err='.$err);
            }

        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        error_log('UsersController login()');
        if ($this->request->is('post')) {
            $username = $this->request->data['username'];
            $auth = $this->Auth->identify();
            if ($auth) {
                error_log('UsersController login() $user='.$auth['username']);
                $this->Auth->setUser($auth);
                error_log('Logged in. $user->username='.$auth['username']);
                return $this->redirect('/profile/tweets/'.$auth['username']);
            } else {
              error_log('Your username or password is incorrect.');
              $err = 'Your username or password is incorrect.';
              return $this->redirect('/login?err='.$err.'&username='.$username);
            }
        }
    }

    public function logout()
    {
        //$this->Flash->success('You are now logged out.');
        //return $this->redirect($this->Auth->logout());
        $this->Auth->logout();
        return $this->redirect('http://'.$_SERVER['HTTP_HOST']);
    }
}
