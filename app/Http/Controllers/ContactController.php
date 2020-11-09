<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    //
    public function index(){
        $contacts = Contact::all();
        return response()->json($contacts, 200);
    }

    public function store(Request $request){
        $contact = Contact::create($request->all());
        return response()->json($contacts, 200);
    }
}
