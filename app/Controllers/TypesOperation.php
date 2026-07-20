<?php 

namespace App\Controllers;

use App\Models\TypeOperationModel;
use App\Models\BaremeModel;
use Throwable;

class TypesOperation extends BaseController
{
    public function index()
    {
        $types = [];
        $error = null;

        try {
            $types = (new TypeOperationModel())->findAll();
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les types d’opération.';
            log_message('error', 'Type operation DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/types/index', [
            'types' => $types,
            'error' => $error,
        ]);
    }

    public function baremes()
    {
        $baremes = [];
        $error = null;

        try {
            // Tri sur la borne inférieure
            $baremes = (new BaremeModel())->orderBy('borne_inf', 'ASC')->findAll();
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les barèmes.';
            log_message('error', 'Bareme list DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/types/baremes', [
            'baremes' => $baremes,
            'error'   => $error,
        ]);
    }

    public function addBareme()
    {
        $model = new BaremeModel();

        if ($this->request->getMethod() === 'post') {
            try {
                $model->insert([
                    'id_type_operation' => $this->request->getPost('id_type_operation'),
                    'borne_inf'          => $this->request->getPost('borne_inf'),
                    'borne_sup'          => $this->request->getPost('borne_sup'),
                    'valeur'             => $this->request->getPost('valeur'),
                ]);
                return redirect()->to('/operateur/types/baremes')->with('message', 'Tranche ajoutée.');
            } catch (Throwable $exception) {
                log_message('error', 'Bareme add DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/types/add_baremes', ['error' => 'Impossible d’enregistrer la tranche.']);
            }
        }

        return view('operateur/types/add_baremes');
    }

    public function editBareme($id)
    {
        $model = new BaremeModel();

        if ($this->request->getMethod() === 'post') {
            try {
                $model->update($id, [
                    'borne_inf' => $this->request->getPost('borne_inf'),
                    'borne_sup' => $this->request->getPost('borne_sup'),
                    'valeur'    => $this->request->getPost('valeur'),
                ]);
                return redirect()->to('/operateur/types/baremes')->with('message', 'Tranche mise à jour.');
            } catch (Throwable $exception) {
                log_message('error', 'Bareme edit DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/types/edit_bareme', [
                    'bareme' => $model->find($id),
                    'error'  => 'Impossible de mettre à jour la tranche.',
                ]);
            }
        }

        return view('operateur/types/edit_bareme', ['bareme' => $model->find($id)]);
    }

    public function deleteBareme($id)
    {
        try {
            (new BaremeModel())->delete($id);
        } catch (Throwable $exception) {
            log_message('error', 'Bareme delete DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return redirect()->to('/operateur/types/baremes');
    }
}