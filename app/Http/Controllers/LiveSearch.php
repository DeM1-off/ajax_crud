<?php

namespace App\Http\Controllers;

use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveSearch extends Controller
{
    function index()
    {
        return view('search');
    }

    function action(Request $request)
    {
        
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('books')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('descriptions', 'like', '%'.$query.'%')
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
         <td>'.$row->descriptions.'</td>
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
