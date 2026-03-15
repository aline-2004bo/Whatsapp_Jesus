<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // =========================================================================
    // 1. GESTIÓN PRINCIPAL DE CHAT Y MENSAJES
    // =========================================================================

    public function index()
    {
        $users = User::where('id','!=', Auth::id())->get();
        $groups = Auth::user()->groups; 
        
        return view('chat', compact('users', 'groups'));
    }

    public function messages($id, Request $request)
    {
        $isGroup = $request->query('is_group') === 'true';

        if ($isGroup) {
            $messages = Message::with('sender')
                ->where('group_id', $id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            $messages = Message::where(function($q) use ($id){
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $id)
                  ->whereNull('group_id');
            })
            ->orWhere(function($q) use ($id){
                $q->where('sender_id', $id)
                  ->where('receiver_id', Auth::id())
                  ->whereNull('group_id');
            })
            ->orderBy('created_at','asc')
            ->get();
        }

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240'
        ]);

        if(!$request->message && !$request->hasFile('file')){
            return response()->json(['error'=>'Mensaje vacío'],422);
        }

        $isGroup = $request->is_group === 'true';
        $fileName = null;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('files'), $fileName);
        }
        
        // GUARDAR MENSAJE (Soporta grupo o chat directo)
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $isGroup ? null : $request->receiver_id,
            'group_id' => $isGroup ? $request->receiver_id : null,
            'message' => $request->message,
            'file' => $fileName
        ]);

        if(!$isGroup && $request->receiver_id == 999 && $request->message){
            
            $aiReply = $this->askAI($request->message);

            Message::create([
                'sender_id' => 999,
                'receiver_id' => Auth::id(),
                'message' => $aiReply
            ]);
        }
        // ---------------------------------------------

        return response()->json([
            'status' => 'ok'
        ]);
    }


    // =========================================================================
    // 2. MÓDULO DE INTELIGENCIA ARTIFICIAL (IA)
    // =========================================================================
    private function askAI($message)
    {
        $apiKey = env('GROQ_API_KEY');

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey;

        $response = Http::withoutVerifying()->post($url, [
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

    // =========================================================================
    // 3. GESTIÓN DE GRUPOS 
    // =========================================================================

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array'
        ]);

        $group = Group::create([
            'name' => $request->name,
            'created_by' => Auth::id()
        ]);

        $usuariosParaAgregar = $request->users;
        $usuariosParaAgregar[] = Auth::id();

        $group->users()->attach($usuariosParaAgregar);

        return response()->json(['status' => 'ok']);
    }

    public function deleteGroup($id)
    {
        $group = Group::find($id);

        if ($group && $group->created_by == Auth::id()) {
            $group->delete();
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error'], 403);
    }

}