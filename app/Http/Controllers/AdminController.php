<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\ImageModel;
use App\WordIndex;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Imagick;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public $urls = "https://api.ocr.space/parse/image";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(){
        return view('upload');
    }

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
       /* try {
            $imagick = new \Imagick(realpath($request->file('image')));
        } catch (\ImagickException $e) {
        }
        for($y=0; $y<$imagick->getImageWidth(); $y++) {
            for ($x = 0; $x < $imagick->getImageHeight(); $x++) {
                $pixels = $imagick->exportImagePixels($x, $y, $imagick->getImageWidth(), $imagick->getImageHeight(), "RGB", Imagick::PIXEL_CHAR);
            }
            dd($pixels);
        }*/

        if ($request != null) {
            $client = new Client();

            $imageModel = new ImageModel();
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($file)->save($location);
            $fileData = fopen($location, 'r');
            $imageModel->image = $filename;


            $request = $client->request('POST', "https://api.ocr.space/parse/image", [
                'headers' => ['apikey' => '9cbdb738d088957'],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => $fileData
                    ]
                ]
            ],
                [
                    'file' => $fileData
                ]);

            $response = json_decode($request->getBody());
            $imageModel->text = $response->ParsedResults[0]->ParsedText;
            $textdata = $response->ParsedResults[0]->ParsedText;
            $newtextdata = preg_split("/[\s,]+/", $textdata);

            for($i=0; $i<=sizeof($newtextdata)-1; $i++){
                    $wordindex = new WordIndex();
                    $wordindex->word = $newtextdata[$i];
                    $wordindex->imagename = $filename;
                    $wordindex->save();
            }

            $imageModel->save();
            Session::flash("uploaded", "Your image has been uploaded and stored.");
            return redirect()->route('admin.upload');
            }
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
