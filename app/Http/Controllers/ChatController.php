<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{

    // LISTA DE CONTACTOS
    public function index()
    {
        $users = User::where('id','!=', Auth::id())->get();
        return view('chat', compact('users'));
    }


    // OBTENER MENSAJES
    public function messages($id)
    {

        $messages = Message::where(function($q) use ($id){

            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $id);

        })
        ->orWhere(function($q) use ($id){

            $q->where('sender_id', $id)
              ->where('receiver_id', Auth::id());

        })
        ->orderBy('created_at','asc')
        ->get();

        return response()->json($messages);

    }



    // ENVIAR MENSAJE
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

        // GUARDAR MENSAJE DEL USUARIO
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'file' => $fileName
        ]);


        // SI ES MENSAJE PARA LA IA
        if($request->receiver_id == 999 && $request->message){

            $aiReply = $this->askAI($request->message);

            Message::create([
                'sender_id' => 999,
                'receiver_id' => Auth::id(),
                'message' => $aiReply
            ]);

        }

        return response()->json([
            'status' => 'ok'
        ]);

    }



    // CONSULTAR IA (GEMINI)
    private function askAI($message)
    {

        $apiKey = env('GROQ_API_KEY');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey;

        $response = Http::post($url, [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $message]
                    ]
                ]
            ]
        ]);


        if($response->failed()){
            return "Error al conectar con la IA.";
        }

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text'] 
               ?? "La IA no pudo generar respuesta.";

    }

}