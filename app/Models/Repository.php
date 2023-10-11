<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = ['url','description']; //Estamos recibiendo elementos de forma masiva.

    public function user() 
    {
        return $this->belongsTo(User::class);    //Le decimos que este repositorio pertenece a un usuario:($this->belongsTo(User::class)). 
        
    }
}
