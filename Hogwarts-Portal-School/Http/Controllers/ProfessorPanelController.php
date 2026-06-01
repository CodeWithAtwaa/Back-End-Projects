<?php

if (!is_professor()) {
    abort(403);
}

redirect('/dashboard');
