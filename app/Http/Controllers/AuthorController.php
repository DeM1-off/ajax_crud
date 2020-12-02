<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use Illuminate\Http\Request;
use Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $authors  = AuthorModel::orderBy('name')->paginate(15);;

        return view('author.index', compact('authors'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
}
