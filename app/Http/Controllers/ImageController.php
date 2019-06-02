<?php

namespace App\Http\Controllers;

use App\Video\S3VideoStream;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    protected $cache_time = 24 * 60;

    public function show(Request $request, $folder, $filename)
    {

        $query = isset($_SERVER['QUERY_STRING'])? $_SERVER['QUERY_STRING']: '';
        $key = "image:{$request->path()}:{$query}";

        $cloudfile = app('cloudfile')->folder($folder)->filename($filename);

        try {

            if (!$cloudfile->exists()) return $this->pageNotFound();

            $headers = [
                "Content-type" => $mime = $cloudfile->mimetype(),
                'Cache-Control', 'public, max_age='. $this->cache_time * 60 * 7 * 1000
            ];

            if ($mime == 'video/mp4') {
                $stream = new S3VideoStream($cloudfile->path());

                return new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($stream) {
                    return $stream->start();
                }, 200, $headers);
            }


            $image = app('rediscache')->remember($key, $this->cache_time, function() use ($request, $cloudfile) {
                return app('image')
                    ->load($cloudfile->get())
                    ->withFilters($request->all())
                    ->stream();
            });

            return response($image, 200, $headers);


        }  catch (\Exception $e) {
            \Log::alert($e);
            return $this->pageNotFound();
        }
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:mp4,jpg,jpeg,png,gif|max:100000',
            'folder' => 'required|max:255',
        ]);

        return app('cloudfile')->folder($request->folder)->put($request->file);
    }

    public function copy(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required|max:255',
            'folder' => 'required|max:255',
        ]);
        $fs = app('cloudfile')->folder($request->folder);

        if (!$fs->exists($filename = $request->filename)) return $this->pageNotFound();

        return $fs->copy($filename);
    }

    public function exists(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required|max:255',
            'folder' => 'required|max:255',
        ]);


        $key = 'exists.'.$request->folder. '.'. $request->filename;

        return app('rediscache')->remember($key, $this->cache_time, function() use ($request) {
            return app('cloudfile')->folder($request->folder)->exists($request->filename)? 'true': 'false';
        });

    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required|max:255',
            'folder' => 'required|max:255',
        ]);

        return app('cloudfile')->folder($request->folder)->delete($request->filename);
    }

    protected function pageNotFound()
    {
        return response()->json([
            'message' => 'page not found'
        ], 404);
    }
}
