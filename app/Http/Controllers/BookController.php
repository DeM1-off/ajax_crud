<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use App\Models\BookModel;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $search =  $request->input('search');
        if($search!=""){
            $book = BookModel::where(function ($query) use ($search){
                $query->orderBy('name', 'desc');
                $query->where('name', 'like', '%'.$search.'%');
            })
                ->paginate(2);
            $book->appends(['q' => $search]);
        }
        else{
            $book = BookModel::paginate(2);
        }
        return View('book.index')->with('books',$book);
    }


    public function create()
    {
        $authors= AuthorModel::all();
        return view('book.create', compact('authors'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);
        $books= new BookModel();

        $books->name =   $request->input('name');
        $books->author_id =   $request->input('author_id');
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid(). '.'. $extension;
            $file->move('upload/',$filename);
            $books->image = $filename;
        }
        else
        {
            $books->image = '';
        }


        $books->save();


            return redirect()->route('book.index')
                ->with('success', 'Book created successfully.');
    }


    public function show($id)
    {

        $books = BookModel::find($id);
        return view('book.show', compact('books'));
    }


    public function edit($id)
    {
        $authors= AuthorModel::all();
        $books = BookModel::find($id);
        return view('book.edit', compact('books','authors'));

    }


    public function update(Request $request,BookModel $books)
    {
        $request->validate([
            'name' => 'required'

        ]);
        $books->update($request->all());

        return redirect()->route('book.index')
            ->with('success', 'Book updated successfully');
    }


    public function destroy($id)
    {
        $books = BookModel::findOrFail($id);
        $books->delete();
        $image_path = "upload/".$books->image;
        unlink($image_path);

        return redirect()->route('book.index')
            ->with('success', 'Book deleted successfully');
    }
}
