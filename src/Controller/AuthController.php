<?php
namespace App\Controller;

use App\Controller\AppController;

class AuthController extends AppController
{
    public function auth() {
      $this->set('form', 'auth');
      $this->render('auth');
    }

    public function signup() {
      if(isset($this->request->query['err'])) {
        $err = $this->request->query['err'];
        $username = $this->request->query['username'];
        $email = $this->request->query['email'];
        $this->set(['form' => 'signup', 'err' => $err, 'username' => $username, 'email' => $email]);
      } else {
        $this->set(['form' => 'signup', 'err' => '', 'username' => '', 'email' => '']);
      }
      $this->render('auth');

    }

    public function login() {
      $this->set('form', 'login');
      if(isset($this->request->query['err'])) {
        $err = $this->request->query['err'];
        $username = $this->request->query['username'];
        $this->set(['form' => 'login', 'err' => $err, 'username' => $username]);
      } else {
        $this->set(['form' => 'login', 'err' => '', 'username' => '']);
      }
      $this->render('auth');
    }
}
