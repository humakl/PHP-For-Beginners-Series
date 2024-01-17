<?php

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;


$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if ($form->validate($email, $password)) {
   if ((new Authenticator)->attenpt($email, $password)) {
      redirect('/');
   }

   $form->error('email', 'No matching account found for that email address or password');
};

Session::flash('errors', $form->errors());

return redirect('/login');
