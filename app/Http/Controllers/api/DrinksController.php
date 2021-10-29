<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Drinks as DrinksResource;
use App\Models\Drinks;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\StoreDrinks;

class DrinksController extends Controller
{
    public function index(){
        return response()->api(DrinksResource::collection(Drinks::all()));
    }

    public function trash(){
        return response()->api(DrinksResource::collection(onlyTrashed()->get()));
    }

    public function store(StoreDrinks $request){
        if(Auth::user()->id == 2){
            return response()->err("This is demo account, can't create drinks");
        }
        $validated = $request->validated();
        $drink = Drinks::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'caffeine' => $validated['caffeine'],
            'unit' => $validated['unit'],
            'user_id' => Auth::user()->id,
        ]);
        return response()->api(new DrinksResource($drink));
    }

    public function update(StoreDrinks $request, $id){
        try {
            $drink = Drinks::where('id', $id)->firstOrFail();
            if(Auth::user()->id != $drink->user_id){
                return response()->err("You only can delete you update drinks");
            }
            $drink->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'caffeine' => $validated['caffeine'],
                'unit' => $validated['unit'],
            ]);
            return response()->api(true);
        } catch (ModelNotFoundException $e)
        {
            return response()->err('not found drink');
        }
    }

    public function destroy($id){
        try {
            $drink = Drinks::where('id', $id)->firstOrFail();
            if(Auth::user()->id != $drink->user_id){
                return response()->err("You only can delete you create drinks");
            }
            $drink->delete();
            return response()->api(true);
        } catch (ModelNotFoundException $e)
        {
            return response()->err('not found drink');
        }
    }

    public function restore($id){
        try {
            $drink = Drinks::where('id', $id)->withTrashed()->firstOrFail();
            if(Auth::user()->id != $drink->user_id){
                return response()->err("You only can restore you create drinks");
            }
            $drink->restore();
            return response()->api(true);
        } catch (ModelNotFoundException $e)
        {
            return response()->err('not found drink');
        }
    }
}
