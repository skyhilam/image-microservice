<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
    public function index() 
    {
        return view('index');        
    }

    public function show(Request $request, $folder, $filename) 
    {
        try {

            $query = isset($_SERVER['QUERY_STRING'])? $_SERVER['QUERY_STRING']: '';
            $key = "image:{$request->path()}:{$query}";

            $image = app('rediscache')->remember($key, 24 * 60, function() use ($request, $folder, $filename) {
                return app('image')
                    ->load(file_get_contents(app('cloudfile')->folder($folder)->url($filename)))
                    ->withFilters($request->all())
                    ->stream();
            });


        }  catch (\Exception $e) {
            \Log::alert($e);
            abort(404);
        }


        return response($image)
            ->header('Content-Type', 'image/png');
    }

    public function store(Request $request) 
    {
        $this->validate($request, [
            'file' => 'required|image|max:2000',
        ]);

        return app('cloudfile')->folder($request->input('folder', ''))->put($request->file);
    }

    public function destroy(Request $request) 
    {
        $this->validate($request, [
            'filename' => 'required',
        ]);

        return app('cloudfile')->folder($request->input('folder', ''))->delete($request->filename);
    }
}
