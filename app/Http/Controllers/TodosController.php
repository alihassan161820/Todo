<?php

namespace App\Http\Controllers;
use App\Models\Todo\Repositories\TodosRepository;

class TodosController extends Controller
{
	protected $model;
	protected $view;

    public function __construct(TodosRepository $repository)
    {
		$this->model = $repository;
		$this->view = 'todo.';
    }

    public function index()
    {
        return view( $this->view . 'index', ['data' => $this->model->all()]);
    }

    public function store()
    {
        $data = $this->model->create(request()->all());
        return ['success'=>200, 'data'=>$data];
    }

    public function update($id)
    {
        $data = $this->model->update(request()->all(), $id);
        return ['success'=>200, 'data'=>$data];
    }

    public function destroy($id)
    {
        $this->model->delete($id);
        return ['success'=>200];
    }
}
