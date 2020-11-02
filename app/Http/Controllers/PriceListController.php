<?php

namespace App\Http\Controllers;
use App\PriceList;
use App\detailPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    //
    public function index(){
        $result = detailPrice::with('price_list')->get();
        return response()->json();
    }
    
    public function store(Request $request){
        $priceList = PriceList::create($request->all());
        return response()->json($priceList, 201);
    }

    public function update(Request $request, PriceList $priceList){
        $priceList->update($request->all());
        return response()->json($priceList, 200);
    }

    public function destroy(PriceList $priceList){
        $priceList->delete();
        return response()->json(null, 204);
    }
}
