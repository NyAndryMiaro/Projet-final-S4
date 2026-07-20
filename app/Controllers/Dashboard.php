<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\OperationModel;
use Throwable;

class Dashboard extends BaseController
{
    public function index()
    {
        $periode = $this->request->getGet('periode');
        $model = new OperationModel();
        $totalGains = 0.0;
        $error = null;

        try {
            $totalGains = $model->totalGains($periode);
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les gains pour le moment.';
            log_message('error', 'Dashboard DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/dashboard', [
            'total_gains' => $totalGains,
            'periode'     => $periode,
            'error'       => $error,
        ]);
    }
}