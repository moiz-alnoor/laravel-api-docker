<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dialog;

class DialogController extends Controller
{
    public function create(Request $request){
        $dialog = new Dialog();
        $dialog->booked_class_id = $request->booked_class_id;
        $dialog->message = $request->message;
        $dialog->date =  date("M j");
        $dialog->save();
        if($dialog)
        return response()->json($dialog, 201);
    }
    public function reade(){

    }
}
