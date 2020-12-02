<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use App\Models\BookModel;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $books = BookModel::orderBy('name')->paginate(15);;

         return view('book.index', compact('books'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
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
            'descriptions' => 'required',

        ]);

        BookModel::create($request->all());

        return redirect()->route('book.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $books = BookModel::find($id);
        return view('book.show', compact('books'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books = BookModel::find($id);
        return view('book.edit', compact('books'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,BookModel $books)
    {
        $request->validate([
            'name' => 'required',
            'descriptions' => 'required',

        ]);
        $books->update($request->all());

        return redirect()->route('book.index')
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
        $books = BookModel::findOrFail($id);
        $books->delete();

        return redirect()->route('book.index')
            ->with('success', 'Book deleted successfully');
    }
}
