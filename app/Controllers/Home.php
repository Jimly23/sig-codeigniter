<?php

namespace App\Controllers;

use App\Models\SekolahModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model   = new SekolahModel();
        $sekolah = $model->orderBy('nama', 'ASC')->findAll();

        return view('landing', [
            'sekolah' => $sekolah,
        ]);
    }
}
