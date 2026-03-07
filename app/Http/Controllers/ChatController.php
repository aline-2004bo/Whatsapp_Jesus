<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

public function index()
{
    $users = User::where('id','!=',Auth::id())->get();
    return view('chat', compact('users'));
}


public function messages($id)
{

    $messages = Message::where(function($q) use ($id){

        $q->where('sender_id',Auth::id())
          ->where('receiver_id',$id);

    })
    ->orWhere(function($q) use ($id){

        $q->where('sender_id',$id)
          ->where('receiver_id',Auth::id());

    })
    ->orderBy('created_at','asc')
    ->get();

    return response()->json($messages);

}


public function send(Request $request)
{

    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'nullable|string',
        'file' => 'nullable|file|max:10240'
    ]);

    if(!$request->message && !$request->hasFile('file')){
        return response()->json(['error'=>'Mensaje vacío'],422);
    }

    $fileName = null;

    if($request->hasFile('file')){

        $file = $request->file('file');

        $fileName = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('files'), $fileName);
    }

    Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'file' => $fileName
    ]);

    return response()->json([
        'status' => 'ok'
    ]);

}

}