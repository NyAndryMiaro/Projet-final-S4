<?php namespace App\Controllers\Operateur;
use App\Controllers\BaseController;
use App\Models\TypeOperationModel;
use App\Models\BaremeModel;

class TypesOperation extends BaseController
{
    public function index()
    {
        return view('operateur/types/index', [
            'types' => (new TypeOperationModel())->findAll()
        ]);
    }

    // Bareme partage (retrait + transfert), non lie a un type specifique
    public function baremes()
    {
        return view('operateur/types/baremes', [
            'baremes' => (new BaremeModel())->orderBy('born_inf', 'ASC')->findAll()
        ]);
    }

    public function addBareme()
    {
        $model = new BaremeModel();
        if ($this->request->getMethod() === 'post') {
            $model->insert([
                'born_inf' => $this->request->getPost('born_inf'),
                'born_sup' => $this->request->getPost('born_sup'),
                'valeur'   => $this->request->getPost('valeur'),
            ]);
            return redirect()->to('/operateur/types/baremes');
        }
        return view('operateur/types/add_bareme');
    }

    public function editBareme($id)
    {
        $model = new BaremeModel();
        if ($this->request->getMethod() === 'post') {
            $model->update($id, [
                'born_inf' => $this->request->getPost('born_inf'),
                'born_sup' => $this->request->getPost('born_sup'),
                'valeur'   => $this->request->getPost('valeur'),
            ]);
            return redirect()->to('/operateur/types/baremes');
        }
        return view('operateur/types/edit_bareme', ['bareme' => $model->find($id)]);
    }

    public function deleteBareme($id)
    {
        (new BaremeModel())->delete($id);
        return redirect()->to('/operateur/types/baremes');
    }
}