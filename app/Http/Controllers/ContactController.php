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
        $contacts = Contact::create($request->all());
        return response()->json($contacts, 200);
    }

    public function update(Request $request, Contact $contact){
        $contact->update([
            'status' => $request->status
        ]);
        return response()->json($contact, 200);
    }

    public function destroy(Contact $contact){
        $contact->delete();
        return response()->json(null, 204);
    }
}
