<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\AuthorModel;



class AuthorController extends Controller
{


    public function index(AuthorRequest $request)
    {

        $search =  $request->input('search');
        if($search!=""){
            $author = AuthorModel::where(function ($query) use ($search){
                $query->orderBy('name', 'desc');
                $query->where('name', 'like', '%'.$search.'%');
            })
                ->paginate(2);
            $author->appends(['q' => $search]);
        }
        else{
            $author = AuthorModel::orderBy('name')->paginate(5);
        }
        return View('author.index')->with('authors',$author);

    }


    public function create()
    {
        return view('author.create');
    }


    public function store(AuthorRequest $request)
    {


        AuthorModel::create($request->all());

        return redirect()->route('author.index')
            ->with('success', 'Authors created successfully.');
    }


    public function show($id)
    {

        $authors = AuthorModel::find($id);
        return view('author.show', compact('authors'));
    }


    public function edit($id)
    {
        $authors = AuthorModel::find($id);
        return view('author.edit', compact('authors'));

    }

    public function update(AuthorRequest $request,AuthorModel $authors)
    {

        $authors->update($request->all());

        return redirect()->route('author.index')
            ->with('success', 'Book updated successfully');
    }

    public function destroy($id)
    {
        $authors = AuthorModel::findOrFail($id);
        $authors->delete();

        return redirect()->route('author.index')
            ->with('success', 'Book deleted successfully');
    }

    public function search($id) {

        $authors = AuthorModel::find($id);

        if (empty($article)) {
            abort(404);
        }

        return view('author.index', compact('authors'));

    }
}
