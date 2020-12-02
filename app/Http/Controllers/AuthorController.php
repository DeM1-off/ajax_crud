<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'surname' => 'required',

        ]);

        AuthorModel::create($request->all());

        return redirect()->route('author.index')
            ->with('success', 'Authors created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $authors = AuthorModel::find($id);
        return view('author.show', compact('authors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authors = AuthorModel::find($id);
        return view('author.edit', compact('authors'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,AuthorModel $authors)
    {
        $request->validate([
            'name' => 'required',
            'descriptions' => 'required',

        ]);
        $authors->update($request->all());

        return redirect()->route('author.index')
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
