<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Aquí le decimos a Laravel qué columnas de la tabla se pueden llenar
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'group_id', // <-- Súper importante para que guarde en qué grupo se envió
        'message', 
        'file'
    ];

    // Esta es la función chiquita que me preguntaste
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    // (Opcional pero recomendada) Función para saber a qué grupo pertenece el mensaje
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}