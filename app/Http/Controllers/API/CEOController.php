<?php

namespace App\Http\Controllers\API;
use App\CEO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CEOResource;
use Illuminate\Support\Facades\Validator;

class CEOController extends Controller
{
    public function index()
    {
        $ceos = CEO::all();
        return response([ 'ceos' => CEOResource::collection($ceos), 'message' =>'Retrieved successfully'], 200);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'year' => 'required|max:255',
            'company_name' => 'required|max:255',
            'location' => 'required|max:255',
            'sector' => 'required'
        ]);
        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $ceo = CEO::create($data);
        return response([ 'ceo' => new CEOResource($ceo), 'message' => 'Created successfully'], 200);
    }
    public function show(CEO $ceo)
    {
        return response([ 'ceo' => new CEOResource($ceo), 'message' => 'Retrievedsuccessfully'], 200);
    }
    public function update(Request $request, CEO $ceo)
    {
        $ceo->update($request->all());
        return response([ 'ceo' => new CEOResource($ceo), 'message' => 'Retrievedsuccessfully'], 200);
    }
    public function destroy(CEO $ceo)
    {
        $ceo->delete();
        return response(['message' => 'Deleted']);
    }
}
