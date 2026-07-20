<?php

namespace App\Controllers;

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
        $db = \Config\Database::connect();
        $prefixes = [];
        $autresPrefixes = [];
        $error = null;

        try {
            $prefixes = $this->model->findAll();
            $autresPrefixes = $db->query("SELECT * FROM prefixe_autre_operateur ORDER BY nom_operateur ASC")->getResultArray();
        } catch (Throwable $exception) {
            $error = 'Impossible de charger les préfixes pour le moment.';
            log_message('error', 'Prefixe list DB error: {message}', ['message' => $exception->getMessage()]);
        }

        return view('operateur/prefixes/index', [
            'prefixes'        => $prefixes,
            'autres_prefixes' => $autresPrefixes,
            'error'           => $error
        ]);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $db = \Config\Database::connect();
            $typePrefixe = $this->request->getPost('type_prefixe');
            $prefixe = trim((string) $this->request->getPost('prefixe'));

            try {
                if ($typePrefixe === 'externe') {
                    $nomOperateur = trim((string) $this->request->getPost('nom_operateur'));
                    $db->query("INSERT INTO prefixe_autre_operateur (nom_operateur, prefixe) VALUES (?, ?)", [$nomOperateur, $prefixe]);
                } else {
                    $this->model->insert(['prefixe' => $prefixe]);
                }

                return redirect()->to('/operateur/prefixes')->with('message', 'Préfixe ajouté avec succès.');
            } catch (Throwable $exception) {
                log_message('error', 'Prefixe create DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/prefixes/create', ['error' => 'Impossible d’enregistrer le préfixe.']);
            }
        }

        return view('operateur/prefixes/create');
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'post') {
            try {
                $this->model->update($id, ['prefixe' => $this->request->getPost('prefixe')]);
                return redirect()->to('/operateur/prefixes')->with('message', 'Préfixe mis à jour.');
            } catch (Throwable $exception) {
                log_message('error', 'Prefixe edit DB error: {message}', ['message' => $exception->getMessage()]);
                return view('operateur/prefixes/edit', [
                    'prefixe' => $this->model->find($id),
                    'error'   => 'Impossible de mettre à jour le préfixe.',
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