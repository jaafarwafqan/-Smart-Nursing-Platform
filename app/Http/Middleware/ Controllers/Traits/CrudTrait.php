<?php

trait CrudTrait
{
protected $modelClass;
protected $viewPath;

public function index()
{
$items = ($this->modelClass)::paginate();
return view("$this->viewPath.index", compact('items'));
}

public function create()
{
return view("$this->viewPath.create");
}

public function store(\App\Http\Controllers\Traits\Request $request)
{
$data = $request->validate($this->rules());
($this->modelClass)::create($data);
return redirect()->route("$this->viewPath.index");
}
public function edit($id)
{
$item = ($this->modelClass)::findOrFail($id);
return view("$this->viewPath.edit", compact('item'));
}
public function update(\App\Http\Controllers\Traits\Request $request, $id)
{
$data = $request->validate($this->rules());
$item = ($this->modelClass)::findOrFail($id);
$item->update($data);
return redirect()->route("$this->viewPath.index");
}
public function destroy($id)
{
$item = ($this->modelClass)::findOrFail($id);
$item->delete();
return redirect()->route("$this->viewPath.index");

}
}


