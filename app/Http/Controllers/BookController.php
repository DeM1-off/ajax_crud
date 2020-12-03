<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\AuthorModel;
use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search =  $request->input('search');
        if($search!=""){
            $books = BookModel::where(function ($query) use ($search){
                $query->orderBy('name', 'desc');
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(15);

            $books->appends(['q' => $search]);
        }
        else{

            $books = BookModel::paginate(15);
        }

        return view('book.index',compact('books'));
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $autours = AuthorModel::all();

        return view('book.create',compact('autours'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BookRequest $request)
    {

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


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $attributes = DB::table('books_to_autors')->where('book_id', $id)
            ->leftJoin('authors', 'authors.author_id', '=', 'books_to_autors.author_id')
            ->get();

        $books = BookModel::find($id);
        return view('book.show', compact('books','attributes'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $authors= AuthorModel::all();
        $books = BookModel::find($id);
        return view('book.edit', compact('books','authors'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        BookModel::find($id)->fill($request->all())->save();

        return redirect()->route('book.index')
            ->with('success', 'Book updated successfully');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $books = BookModel::findOrFail($id);
        $books->delete();
        if($books->image != null){
            $image_path = "upload/".$books->image;
            unlink($image_path);
        }

        return redirect()->route('book.index')
            ->with('success', 'Book deleted successfully');
    }


}

