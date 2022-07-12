<?php

namespace App\Http\Controllers;

use App\Models\Population;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PopulationController extends Controller
{
    /**
    * @OA\Get(
    * path="/api/v1/population",
    * operationId="getPopulation",
    * tags={"Population"},
    * summary="Get population information.",
    * description="Return data.",
    * @OA\Response(
    *     response=200,
    *     description="Successful operation",
    *     @OA\JsonContent(
    *         type="array",
    *         @OA\Items(
    *             @OA\Property(property="id", type="integer"),
    *             @OA\Property(property="id_nation", type="string"),
    *             @OA\Property(property="nation", type="integer"),
    *             @OA\Property(property="id_year", type="string"),
    *             @OA\Property(property="year", type="string"),
    *             @OA\Property(property="population", type="integer"),
    *             @OA\Property(property="slug_nation", type="string"),
    *             @OA\Property(property="created_at", type="string", format="date-time"),
    *             @OA\Property(property="updated_at", type="string", format="date-time"),
    *         )
    *     )
    *  ),
    * @OA\Response(
    *     response=400,
    *     description="Bad Request"
    * ),
    * @OA\Response(
    *     response=401,
    *     description="Unauthenticated",
    * ),
    * @OA\Response(
    *     response=403,
    *     description="Forbidden"
    * )
    * )
    */
    public function index(Request $request)
    {
        $firstYear = $request->get('first_year') ?? 2013;
        $lastYear = $request->get('last_year') ?? 2018;

        /* $response = Http::get('https://datausa.io/api/data?drilldowns=Nation&measures=Population');
        foreach($response->json('data') as $data){
            $population = Population::query()->updateOrCreate([
                'id_nation'     => $data['ID Nation'],
                'nation'        => $data['Nation'],
                'id_year'       => $data['ID Year'],
                'year'          => $data['Year'],
                'population'    => $data['Population'],
                'slug_nation'   => $data['Slug Nation'],
            ]);
            $population->save();
        } */

        if(Cache::has('population')){
            $population = Cache::get('population');
        }else{
            $population = Population::whereBetween('year', [$firstYear, $lastYear])->orderBy('year', 'ASC')->get();
            Cache::put('population', $population);
        }
        return response()->json($population, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
