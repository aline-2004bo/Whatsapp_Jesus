<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // ¡ESTA ES LA LÍNEA NUEVA QUE ARREGLA EL ERROR!
    const UPDATED_AT = null;

    protected $fillable = ['name', 'created_by'];

    // Un grupo tiene muchos usuarios
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    // Un grupo tiene muchos mensajes
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}