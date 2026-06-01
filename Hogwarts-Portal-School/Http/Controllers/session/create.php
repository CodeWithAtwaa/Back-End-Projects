<?php

use Core\Session;

view('session/create', [
    'errors' => Session::get('errors') ?? [],
    'old'    => Session::get('old') ?? []    
]);