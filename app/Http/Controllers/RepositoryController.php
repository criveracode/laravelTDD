<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function store(Request $request)                        //Vamos a recibir todo lo que enviamos a traves del form mediante un request.
    {
        $request->user()->repositories()->create($request->all()); //Estamos diciendo que cree un elemento con el metodo de las relaciones usando el id del usuario logueadode manera masiva.

        return redirect()->route('repositories.index');            //Retornamos a una ruta definida y la vista index una ves creado.
    }

    public function update(Request $request,Repository $repository) //Vamos a recibir todo lo que enviamos a traves del form mediante un request y el ropositorio.
    {
        $repository->update($request->all());                       //Actualizamos el repositorio seleccionado de manera masiva

        return redirect()->route('repositories.edit',$repository);    //Retornamos a una ruta definida y la vista respository una ves creado y nos muestre la actualizacion.
    }
}
