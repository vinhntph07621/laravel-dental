<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\detailPrice;

class DetailPriceController extends Controller
{
    public function index(){
        $detailPrice = DB::table('price_list')
        ->get();
        return response()->json($detailPrice, 200);
    }
    
    public function store(Request $request){
        $detailPrice = detailPrice::create($request->all());
        return response()->json($detailPrice, 201);
    }

    public function update(Request $request, detailPrice $detailPrice){
        $detailPrice->update($request->all());
        return response()->json($detailPrice, 200);
    }

    public function delete(detailPrice $detailPrice){
        $detailPrice->delete();
        return response()->json(null, 204);
    }
}
