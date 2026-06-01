<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validate($attributes = [
    'email' =>  $_POST['email'],
    'password' => $_POST['password']
]);
$signedIn = (new Authenticator)->attempt($attributes['email'], $attributes['password']);
if (!$signedIn) {
    $form->error('email', 'No matching password found for that email address.')->throw();
    }
$user = $_SESSION['user'] ?? [];

if (($user['role'] ?? null) === 'Dumbledore') {
    redirect('/dashboard');
}

if (($user['role'] ?? null) === 'Student') {
    redirect('/student-panel');
}

if (($user['role'] ?? null) === 'Professor') {
    redirect('/dashboard');
}

redirect('/');
