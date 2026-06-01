<?php

use Http\Models\ShopModel;
use Http\Models\StudentModel;
use Http\Models\InventoryModel;
use Core\Session;

$studentId = $_SESSION['user']['student_id'];
$itemId    = $_POST['item_id'] ?? null;

if (!$itemId) {
    redirect('/shop');
    exit();
}

$shopModel      = new ShopModel();
$studentModel   = new StudentModel();
$inventoryModel = new InventoryModel();

$item    = $shopModel->findItem($itemId);
$student = $studentModel->findStudent($studentId);

if (!$item || !$student) {
    redirect('/shop');
    exit();
}

// Not enough balance — flash error, stay on shop
if ($student['balance'] < $item['item_price']) {
    Session::flash('errors', ['balance' => 'Not enough Galleons to purchase this item!']);
    redirect('/shop');
    exit();
}

$studentModel->deductBalance($studentId, $item['item_price']);

$inventoryItem = $inventoryModel->findItem($studentId, $itemId);

if ($inventoryItem) {
    $inventoryModel->incrementItem($studentId, $itemId);
} else {
    $inventoryModel->addItem($studentId, $itemId);
}

// Success — flash message then redirect to inventory
Session::flash('success', $item['item_name'] . ' has been added to your inventory!');
redirect('/inventory');
exit();