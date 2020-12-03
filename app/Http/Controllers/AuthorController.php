<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\AuthorModel;
use App\Models\BookModel;
use Illuminate\Http\Request;


class AuthorController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $search =  $request->input('search');
        if($search!=""){
            $authors = AuthorModel::where(function ($query) use ($search){
                $query->orderBy('name', 'desc');
                $query->where('name', 'like', '%'.$search.'%');
            })->paginate(15);
            $authors->appends(['q' => $search]);
        }
        else{
            $authors = AuthorModel::orderBy('name')->paginate(15);
        }

        return View('author.index',compact('authors'));

    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('author.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {


        AuthorModel::create($request->all());

        return redirect()->route('author.index')
            ->with('success', 'Authors created successfully.');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {

        $authors = AuthorModel::find($id);
        return view('author.show', compact('authors'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $authors = AuthorModel::find($id);
        return view('author.edit', compact('authors'));

    }

    /**
     * @param AuthorRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AuthorRequest $request, $id)
    {

        AuthorModel::find($id)->fill($request->all())->save();

        return redirect(route('author.index'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $authors = AuthorModel::findOrFail($id)->delete();
        return redirect()->route('author.index')
            ->with('success', 'Book deleted successfully');
    }

}
