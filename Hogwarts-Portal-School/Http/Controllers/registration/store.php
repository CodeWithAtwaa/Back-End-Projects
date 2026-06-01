<?php

use Http\Models\UserModel;
use Core\App;
use Core\Database;
use Core\Validator;
use Http\Models\HouseModel;
use Http\Models\StudentModel;
use Core\Authenticator;
use Core\Session;
use Http\Models\WandModel;

$db = App::resolve(Database::class);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password_confirmation'];


$errors = [];
// check is not empty 
if (!Validator::string($name, 1, 100)) {
    $errors['name'] = 'Please provide a valid name.';
}
if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}
if (!Validator::string($password, 6, 255)) {
    $errors['password'] = 'Please provide a password at least sex characters.';
}
if ($password != $password_confirmation) {
    $errors['password_confirmation'] = 'Passwords must match';
};

if (!empty($errors)) {
    Session::flash('errors', $errors);
    Session::flash('old', ['name' => $name, 'email' => $email]);
    redirect('/register');
    exit();
}

$user = new  UserModel();
$existingUser = $user->FindUser($email);
if ($existingUser) {
    Session::flash('errors', ['email' => 'Email already taken.']);
    Session::flash('old', ['name' => $name, 'email' => $email]);
    redirect('/register');
    exit();
} else {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userId = $user->CreateUser($name, $email, $hashedPassword);
    $houseModel = new HouseModel();
    $houses = $houseModel->GetHouses();
    $randomIndex = array_rand($houses);
    $houseId = $houses[$randomIndex]['house_id'];
    $studentModel = new StudentModel();
    $studentId = $studentModel->CreateStudent($userId, $houseId);

    $woods = ['Holly', 'Yew', 'Elder', 'Willow', 'Hawthorn', 'Oak'];
    $cores = ['Phoenix Feather', 'Dragon Heartstring', 'Unicorn Hair', 'Thestral Tail Hair'];

    $randomWood = $woods[array_rand($woods)];
    $randomCore = $cores[array_rand($cores)];

    $wandModel = new WandModel();
    $wandModel->CreateWand($studentId, $randomWood, $randomCore);
    $auth = new Authenticator();
    $auth->login([
        'user_id'    => $userId,
        'student_id' => $studentId,
        'email'      => $email,
        'role'       => 'Student',
        'house_id'   => $houseId
    ]);

    header('location: /');
    exit(); //
}
