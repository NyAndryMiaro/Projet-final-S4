<?php namespace App\Controllers\Operateur;
use App\Controllers\BaseController;
use App\Models\PrefixeOperateurModel;

class Prefixes extends BaseController
{
    protected PrefixeOperateurModel $model;

    public function __construct()
    {
        $this->model = new PrefixeOperateurModel();
    }

    public function index()
    {
        return view('operateur/prefixes/index', ['prefixes' => $this->model->findAll()]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $this->model->insert(['prefixe' => $this->request->getPost('prefixe')]);
            return redirect()->to('/operateur/prefixes');
        }
        return view('operateur/prefixes/create');
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'post') {
            $this->model->update($id, ['prefixe' => $this->request->getPost('prefixe')]);
            return redirect()->to('/operateur/prefixes');
        }
        return view('operateur/prefixes/edit', ['prefixe' => $this->model->find($id)]);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/operateur/prefixes');
    }
}