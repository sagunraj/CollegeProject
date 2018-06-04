<?php

namespace App\Http\Controllers;

use App\ImageModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        //
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
    public function store(Request $request)
    {
        $client = new Client();

        $imageModel = new ImageModel();
        $file = $request->file('image');
        $filename = time().'.'.$file->getClientOriginalExtension();
        $textfilename = time().'.txt';
        $location = public_path('images/'.$filename);
        Image::make($file)->save($location);
        $fileData = fopen($location, 'r');
        $imageModel->image = $filename;
        $imageModel->textfile = $textfilename;
        $imageModel->save();

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

        $response= json_decode($request->getBody(), true);

        dd($response);

        return redirect()->route('admin.upload');
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
