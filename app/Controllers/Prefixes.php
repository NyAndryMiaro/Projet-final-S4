<?php
 namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PrefixeOperateurModel;
use Throwable;

class Prefixes extends BaseController
{
    protected PrefixeOperateurModel $model;

    public function __construct()
    {
        $this->model = new PrefixeOperateurModel();
    }

    public function index()
    {
        $prefixes = [];
        $error = null;

        try {
            $prefixes = $this->model->findAll();
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les préfixes pour le moment.';
            log_message('error', 'Prefixe list DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/prefixes/index', ['prefixes' => $prefixes, 'error' => $error]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            try {
                $this->model->insert(['prefixe' => $this->request->getPost('prefixe')]);
                return redirect()->to('/operateur/prefixes');
            } catch (Throwable $exception) {
                log_message('error', 'Prefixe create DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/prefixes/create', ['error' => 'Impossible d’enregistrer le préfixe pour le moment.']);
            }
        }
        return view('operateur/prefixes/create');
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'post') {
            try {
                $this->model->update($id, ['prefixe' => $this->request->getPost('prefixe')]);
                return redirect()->to('/operateur/prefixes');
            } catch (Throwable $exception) {
                log_message('error', 'Prefixe edit DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/prefixes/edit', [
                    'prefixe' => $this->model->find($id),
                    'error' => 'Impossible de mettre à jour le préfixe pour le moment.',
                ]);
            }
        }
        return view('operateur/prefixes/edit', ['prefixe' => $this->model->find($id)]);
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
        } catch (Throwable $exception) {
            log_message('error', 'Prefixe delete DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return redirect()->to('/operateur/prefixes');
    }
}