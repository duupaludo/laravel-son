<?php

namespace App\Http\Controllers\Admin;

use App\Forms\CategoryForm;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Facades\FormBuilder;

class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $categories = $this->repository->paginate();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = FormBuilder::create(CategoryForm::class, [
            'url' => route('admin.categories.store'),
            'method' => 'POST'
        ]);
        return view('admin.categories.create', compact('form'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = FormBuilder::create(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $data = $form->getFieldValues();
        $this->repository->create($data);
        session()->flash('message', 'Categoria criada com sucesso.');
        return redirect()->route('admin.categories.index');
    }
    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function edit(Category $category)
    {
        $form = FormBuilder::create(CategoryForm::class, [
            'url' => route('admin.categories.update', ['category' => $category->id]),
            'method' => 'PUT',
            'model' => $category
        ]);
        return view('admin.categories.edit', compact('form'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     * @internal param User $user
     */
    public function update($id)
    {
        $form = FormBuilder::create(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $data = $form->getFieldValues();
        $this->repository->update($data, $id);
        session()->flash('message', 'Categoria alterada com sucesso.');
        return redirect()->route('admin.categories.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param User $user
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        session()->flash('message', 'Categoria excluída com sucesso.');
        return redirect()->route('admin.categories.index');
    }
}
