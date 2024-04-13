<?php

namespace Controller;

use Model\Connect;

class NotFoundController
{
    public function index()
    {
        require "view/notFound.php";
    }
}