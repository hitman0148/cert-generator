<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Lesson::all();
        if($res){
            $msg = [
                'status' => 200,
                'data' => $res,
                'message' => 'success'
            ];
        }else{
            $msg = [
                'status' => 500,
                'data' => [],
                'message' => 'error'
            ];
        }
        // return response()->json($msg);
        return $res;
    }


    public function store(Request $request)
    {
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'date_created'  => now()
        );
        Lesson::create($data);
        $msg = ['status' => 200, 'message' => 'success'];
        return response()->json($msg);

    }

    public function show($id)
    {
        return  Lesson::find($id);
    }

    public function update(Request $request, $id)
    {
        $data = array(
            'title' => $request->title,
            'description' => $request->description,
            'date_created'  => now()
        );
        Lesson::where('id',$id)->update($data);
        $msg = ['status' => 200, 'message' => 'success'];
        return response()->json($msg);
    }

    public function destroy($id)
    {
        Lesson::where('id',$id)->delete();
        $msg = ['status' => 200, 'message' => 'success'];
        return response()->json($msg);
    }
}
