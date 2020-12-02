<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorSearch extends Controller
{
    function index()
    {
        return view('search_author');
    }

    function action(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('authors')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('surname', 'like', '%'.$query.'%')
                    ->orderBy('name', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('books')
                    ->orderBy('name', 'desc')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
        <tr>
         <td>'.$row->name.'</td>
         <td>'.$row->surname.'</td>
        </tr>
        ';
                }
            }
            else
            {
                $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );

            echo json_encode($data);
        }
    }
}
