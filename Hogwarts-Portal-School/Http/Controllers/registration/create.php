<?php

use Core\Session;

view("registration/create", [
    'errors' => Session::get('errors') ?? [],
    'old'    => Session::get('old') ?? []
]);