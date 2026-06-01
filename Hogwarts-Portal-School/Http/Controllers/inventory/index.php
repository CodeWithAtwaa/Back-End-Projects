<?php

use Http\Models\InventoryModel;
use Http\Models\StudentModel;
use Http\Models\WandModel;
use Core\Session;

$studentId      = $_SESSION['user']['student_id'];
$inventoryModel = new InventoryModel();
$studentModel   = new StudentModel();
$wandModel      = new WandModel();

$items   = $inventoryModel->getAllItems($studentId);
$student = $studentModel->findStudent($studentId);
$wand    = $wandModel->findWand($studentId);

view("inventory/index", [
    'items'   => $items,
    'balance' => $student['balance'],
    'wand'    => $wand,
    'success' => Session::get('success')
]);
