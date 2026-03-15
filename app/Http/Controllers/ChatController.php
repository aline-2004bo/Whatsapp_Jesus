<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Group; // <-- Aquí agregamos el modelo de grupo
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{

    // LISTA DE CONTACTOS Y GRUPOS
    public function index()
    {
        $users = User::where('id','!=', Auth::id())->get();
        $groups = Auth::user()->groups; // <-- Obtenemos los grupos del usuario
        
        return view('chat', compact('users', 'groups'));
    }


    // OBTENER MENSAJES (Actualizado para distinguir entre grupos y chats privados)
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


    // ENVIAR MENSAJE
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


        // SI ES MENSAJE PARA LA IA (TU CÓDIGO INTACTO)
        if(!$isGroup && $request->receiver_id == 999 && $request->message){

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


    // CREAR UN NUEVO GRUPO (Ahora recibe usuarios específicos)
    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'required|array' // Verificamos que sí envíen la lista de integrantes
        ]);

        // Creamos el grupo en la base de datos
        $group = Group::create([
            'name' => $request->name,
            'created_by' => Auth::id()
        ]);

        // Tomamos los usuarios que elegiste en las casillas
        $usuariosParaAgregar = $request->users;
        
        // Te agregamos a ti (el creador) a esa lista automáticamente para que no te quedes fuera
        $usuariosParaAgregar[] = Auth::id();

        // Guardamos las relaciones exactas en la tabla group_user
        $group->users()->attach($usuariosParaAgregar);

        return response()->json(['status' => 'ok']);
    }


    // CONSULTAR IA (GEMINI) - (TU CÓDIGO INTACTO)
    private function askAI($message)
    {
        $apiKey = "AIzaSyCnfVqhUIlh7zBBJsgOo_GJqj2ohvFCUZI";

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