<?php

namespace App\Models\Todo\Repositories;
use App\Models\Todo\Todo;

class TodosRepository 
{
    	public function model()
    	{
        	return app(Todo::class);
	}

	public  function all()
	{
		return $this->model()->all();
	}

	public function create()
	{
		if(request()->ajax())
		{
			return $this->model()->create(request()->all());
		}
	}

	public function delete($id)
	{
		if(request()->ajax())
		{
			return $this->model()->destroy($id);
		}
	}

	public function update($data, $id)
	{
		if(request()->ajax())
		{
			$update = $this->model()->find($id);
			$update->status = $data['status'];
			$update->save();
			return $update;
		}
	}
}
