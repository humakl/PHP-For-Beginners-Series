<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
   $errors['email'] = 'Please provide a valid email address';
}

if (!Validator::string($password)) {
   $errors['password'] = 'Please provide a password';
}

if (!empty($error)) {
   return view('seesion/create.view.php', [
      'errors' => $errors
   ]);
}

//match the credentials
$user = $db->query('select * from users where email = :email', [
   'email' => $email
])->find();

if ($user) {
   if (password_verify($password, $user['password'])) {
      login([
         'email' => $email
      ]);

      header('location: /');
      exit();
   }
}

return view('sessions/create.view.php', [
   'errors' => [
      'email' => 'No matching account found for that email address or password'
   ]
]);
