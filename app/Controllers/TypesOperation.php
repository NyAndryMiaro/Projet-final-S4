<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
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
            $error = 'Impossible de charger les types d’opération pour le moment.';
            log_message('error', 'Type operation DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/types/index', [
            'types' => $types,
            'error' => $error,
        ]);
    }

    // Bareme partage (retrait + transfert), non lie a un type specifique
    public function baremes()
    {
        $baremes = [];
        $error = null;

        try {
            $baremes = (new BaremeModel())->orderBy('born_inf', 'ASC')->findAll();
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les barèmes pour le moment.';
            log_message('error', 'Bareme list DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/types/baremes', [
            'baremes' => $baremes,
            'error' => $error,
        ]);
    }

    public function addBareme()
    {
        $model = new BaremeModel();
        if ($this->request->getMethod() === 'post') {
            try {
                $model->insert([
                    'born_inf' => $this->request->getPost('born_inf'),
                    'born_sup' => $this->request->getPost('born_sup'),
                    'valeur'   => $this->request->getPost('valeur'),
                ]);
                return redirect()->to('/operateur/types/baremes');
            } catch (Throwable $exception) {
                log_message('error', 'Bareme add DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/types/add_bareme', ['error' => 'Impossible d’enregistrer le barème pour le moment.']);
            }
        }
        return view('operateur/types/add_bareme');
    }

    public function editBareme($id)
    {
        $model = new BaremeModel();
        if ($this->request->getMethod() === 'post') {
            try {
                $model->update($id, [
                    'born_inf' => $this->request->getPost('born_inf'),
                    'born_sup' => $this->request->getPost('born_sup'),
                    'valeur'   => $this->request->getPost('valeur'),
                ]);
                return redirect()->to('/operateur/types/baremes');
            } catch (Throwable $exception) {
                log_message('error', 'Bareme edit DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/types/edit_bareme', [
                    'bareme' => $model->find($id),
                    'error' => 'Impossible de mettre à jour le barème pour le moment.',
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