<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // Lista de usuarios
    public function index()
    {
        $users = User::where('id','!=', Auth::id())->get();
        return view('chat', compact('users'));
    }

    // Obtener mensajes entre usuarios
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
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    // Enviar mensaje y archivo
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

        return response()->json(['status'=>'ok']);
    }

    // Método para preguntar a DeepSeek
    
public function askAI($message)
{
    $apiKey = env('GROQ_API_KEY');
    $url = env('GROQ_API_URL');

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->post($url, [
        'model' => 'groq-gpt-1', // cambia según tu modelo Groq disponible
        'input' => $message
    ]);

    if ($response->failed()) {
        return "Error API Groq: " . $response->status() . " - " . $response->body();
    }

    $data = $response->json();

    // Ajusta según la estructura de respuesta de Groq
    return $data['output_text'] ?? "La IA no generó respuesta.";
}
}