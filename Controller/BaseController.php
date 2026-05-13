<?php
session_start();

abstract class Controller
{
    protected $model;

    public function __construct($modelInstance)
    {
        $this->model = $modelInstance;
    }

    public function index()
    {
        return $this->model->getAll();
    }

    public function show($id)
    {
        return $this->model->getById($id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
