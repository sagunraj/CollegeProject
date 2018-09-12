<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\ImageModel;
use App\WordIndex;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
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
        $images = ImageModel::paginate(9);
        return view('display', [
            'images' => $images
        ]);
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
                'headers' => ['apikey' => '9b0a4be67688957'],
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
            if($response->ParsedResults[0]->ParsedText!="") {
                $imageModel->text = $response->ParsedResults[0]->ParsedText;
                $textdata = $response->ParsedResults[0]->ParsedText;
                $newtextdata = preg_split("/[\s,]+/", $textdata);
                $imageModel->save();

                for ($i = 0; $i <= sizeof($newtextdata) - 1; $i++) {
                    if ($newtextdata[$i] != "") {
                        $wordindex = new WordIndex();
                        $wordindex->image_model_id = $imageModel->id;
                        $wordindex->word = strtolower($newtextdata[$i]);
                        $wordindex->imagename = $filename;
                        $wordindex->save();
                    }
                }

                Session::flash("uploaded", "Your image has been uploaded and stored.");
            }
            else {
                Session::flash("uploaded", "Your image wasn't uploaded and stored because we couldn't detect any text.");
            }
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
        $image = ImageModel::findorfail($id);
        $path = public_path("/images/".$image->image);

        $word_indices=WordIndex::where("image_model_id",$id)->get();

        foreach ($word_indices as $word_index)
            $word_index->delete();

        if(File::exists($path)){
            File::delete($path);
        }
        $image->delete();
        Session::flash('delete', "Image has been deleted.");
        return redirect()->route('admin.index');
    }


}
