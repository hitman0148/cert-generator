<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crud;

class CrudController extends Controller
{

    public function index()
    {
         $res = Crud::all();
         return response()->json(['data' => $res]);
    }

    public function store(Request $request)
    {
        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'date_created' => now()
        ];
        Crud::create($data);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request)
    {
        $data = [
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
        ];
        Crud::where('id',$request->id)->update($data);
        return response()->json(['data' => $data]);
    }

    public function destroy($id)
    {
        Crud::where('id',$id)->delete();
        return true;
    }
}
