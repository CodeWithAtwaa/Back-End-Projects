<?php

use Http\Models\ShopModel;
use Core\Session;

$shopModel = new ShopModel();
$items = $shopModel->getAllItems();


view("shop/index", [
    'items'   => $items,
    'errors'  => Session::get('errors'),
    'success' => Session::get('success')
]);
