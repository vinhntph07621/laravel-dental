<?php

namespace App\Http\Controllers;
use App\PriceList;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    //
    public function list(){
        $priceList = PriceList::all();
        return response()->json($priceList);
    }
    
    public function create(Request $request){
        $priceList = PriceList::create($request->all());
        return response()->json($priceList, 201);
    }

    public function update(Request $request, PriceList $priceList){
        $priceList->update($request->all());
        return response()->json($priceList, 200);
    }

    public function delete(PriceList $priceList){
        $priceList->delete();
        return response()->json(null, 204);
    }
}
