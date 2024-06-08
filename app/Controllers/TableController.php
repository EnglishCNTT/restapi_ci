<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TableController extends BaseController
{
    public function index()
    {
        return view('tables/usertable');
    }
}
