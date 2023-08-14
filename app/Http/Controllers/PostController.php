<?php

namespace App\Http\Controllers;

use Response;
use Exception;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // dd($posts);
        return view('home', compact('posts'));
    }
    public function getmodal(Request $request)
    {
        $data = array();
        if (isset($request->id) && $request->id != '') {
            $id = decrypt($request->id);
            $data = Post::where('id', $id)->first();
        }

        return view('getmodal', compact('data'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('image') || !empty($input['name']) || !empty($input['message'])) {
            try {
                if (isset($request->id)) {
                    $id = decrypt($request->id);
                    $msg = 'updated successfully';
                    $data = Post::find($id);
                    if ($request->hasFile('image')) {
                        if (file_exists(public_path('images/' . $data->image)) && $data->image != '') {
                            unlink(public_path('images/' . $data->image));
                        }
                    }
                } else {
                    $msg = 'Added successfully';
                    $data = new Post;
                }
                if ($request->hasFile('image')) {

                    $destinationPath = public_path() . '/images/';
                    $file = $input['image'];
                    $fileName = rand(11111, 99999) . '_' . $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();

                    $file->move($destinationPath, $fileName);
                    //dd($fileName);
                    $data->image = $fileName;
                    $data->file_type = $extension;

                }
                $data->name = $input['name'];
                $data->message = $input['message'];
                $data->save();
                $arr = array("status" => 200, "msg" => $msg);

            } catch (\Illuminate\Database\QueryException $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])):
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, 'line' => $ex->getLine(), "result" => array());
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2])):
                    $msg = $ex->errorInfo[2];
                endif;
                $arr = array("status" => 400, "msg" => $msg, 'line' => $ex->getLine(), "result" => array());
            }
        }
        return redirect()->back();
    }

}
