<?php
namespace App\Controllers\Operateur;
use App\Controllers\BaseController;
use App\Models\OperationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $periode = $this->request->getGet('periode');
        $model = new OperationModel();

        return view('operateur/dashboard', [
            'total_gains' => $model->totalGains($periode),
            'periode'     => $periode,
        ]);
    }
}