<?php

namespace App\Http\Controllers;

use App\Models\AuthorModel;
use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function index(Request $request)
    {
        $search =  $request->input('search');
        if($search!=""){
            $books = BookModel::where(function ($query) use ($search){
                $query->orderBy('name', 'desc');
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(2);

            $books->appends(['q' => $search]);
        }
        else{

            $books = BookModel::paginate(2);
        }

        return view('book.index',compact('books'));
    }


    public function create()
    {
        $autours = AuthorModel::all();

        return view('book.create',compact('autours'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);
        $books= new BookModel();

        $books->name =   $request->input('name');
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
        $attributes = DB::table('books_to_autors')->where('book_id', $id)
            ->leftJoin('authors', 'authors.author_id', '=', 'books_to_autors.author_id')
            ->get();

        $books = BookModel::find($id);
        return view('book.show', compact('books','attributes'));
    }


    public function edit($id)
    {
        $authors= AuthorModel::all();
        $books = BookModel::find($id);
        return view('book.edit', compact('books','authors'));

    }


    public function update(Request $request, $id)
    {
        BookModel::find($id)->fill($request->all())->save();

        return redirect()->route('book.index')
            ->with('success', 'Book updated successfully');
    }


    public function destroy($id)
    {
        $books = BookModel::findOrFail($id);
        $books->delete();
        if($books->image == null){

        }
        else{
        $image_path = "upload/".$books->image;
        unlink($image_path);
            }


        return redirect()->route('book.index')
            ->with('success', 'Book deleted successfully');
    }


}

