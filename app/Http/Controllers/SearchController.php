<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\WordIndex;
use Illuminate\Http\Request;


class SearchController extends Controller
{   public $nx = [];
    public $ny = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search');
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
    public function store(SearchRequest $request)
    {
        $queryString = $request->get('q');
        /*$imageModel = json_decode(ImageModel::where('text', 'LIKE', '%'.$queryString.'%')->get());


        if(count($imageModel) > 0){
            return view('results', [
                'imageModel' => $imageModel,
                'queryString' => $queryString
            ]);
        }
        else{
            return view('noresults');
        }*/


        /*$words = json_decode(WordIndex::all());
        $wordo = "";
        for($i=0; $i<=sizeof($words)-1;$i++){
            $lev = levenshtein($words[$i]->word, $queryString);
            if($lev==0||$lev==1){
               $wordo= $wordo.$words[$i]->word;
            }
        }
        dd($wordo);*/
        $output = shell_exec("wn ".$queryString. " -synsn -synsv -synsa");

        $patterns       = array(
            '/.* senses of .*\n/',          # remove the '... senses of ...' line
            '/^Sense.*\n/m',                # remove the 'Sense ...' lines
            '/^ *\n/m',                     # remove empty lines
            '/^Synonyms.*\n/m',
            '/.* sense of .*\n/'

        );

        $synsn   = preg_replace( $patterns, "", $output);
        $synsn = str_replace("=>", " ", $synsn);

        $keywords = preg_split("/[\s,]+/", $synsn);
        $newkeywords[0] = $queryString;
        $j=1;

        for($i=1;$i<=sizeof($keywords)-1;$i++){
            if($keywords[$i]!=$queryString) {
                    $newkeywords[$j] = $keywords[$i];
                    $j++;
            }
        }

        $diceResults = array();

        $indices = json_decode(WordIndex::all());

        for($l=0; $l <= sizeof($newkeywords)-1; $l++) {
            for ($m = 0; $m <= sizeof($indices) - 1; $m++) {
                $dv = $this->diceCoefficient($newkeywords[$l], $indices[$m]->word);
                echo $dv;
                if ($dv >= 0.6) {
                    array_push($diceResults, $newkeywords[$l]);
                }
            }

        }

    }


    public function diceCoefficient($s1, $s2){
        for($i=0; $i<strlen($s1)-1;$i++){
            $x1 = $s1[$i];
            $x2 = $s1[$i+1];
            $tmp = "".$x1.$x2;
            array_push($this->nx, $tmp);
        }

        for($j=0; $j<strlen($s2)-1;$j++){
            $y1 = $s2[$j];
            $y2 = $s2[$j+1];
            $tmp = "".$y1.$y2;
            array_push($this->ny, $tmp);
        }

        $result = sizeof(array_intersect($this->nx, $this->ny));
        return (2*$result)/(sizeof($this->nx)+sizeof($this->ny));
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
