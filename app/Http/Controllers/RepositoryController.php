<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index(Request $request)
    {
        return view('repositories.index', [
            'repositories' => $request->user()->repositories
        ]);
    }

    public function show(Request $request,Repository $repository)   //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        if ($request->user()->id != $repository->user_id )          //El usuario que esta intentando eliminar es dueño del repositorio?.
        {
            abort(403);                                             //Si no es dueño arroja un error 403.
        }                                  

        return view('repositories.show', compact('repository'));    //Retornamos a una vista.
    }

    
    public function store(Request $request)                        //Vamos a recibir todo lo que enviamos a traves del form mediante un request.
    {
        $request->validate([
            'url' => 'required',
            'description' => 'required'
        ]);
        $request->user()->repositories()->create($request->all()); //Estamos diciendo que cree un elemento con el metodo de las relaciones usando el id del usuario logueadode manera masiva.

        return redirect()->route('repositories.index');            //Retornamos a una ruta definida y la vista index una ves creado.
    }

    public function update(Request $request,Repository $repository) //Vamos a recibir todo lo que enviamos a traves del form mediante un request y el ropositorio.
    {
        $request->validate([
            'url' => 'required',
            'description' => 'required'
        ]);

        if ($request->user()->id != $repository->user_id )          //El usuario que esta intentando actulizar es dueño del repositorio?.
        {
            abort(403);                                             //Si no es dueño arroja un error 403.
        }

        $repository->update($request->all());                       //Actualizamos el repositorio seleccionado de manera masiva

        return redirect()->route('repositories.edit',$repository);  //Retornamos a una ruta definida y la vista respository una ves creado y nos muestre la actualizacion.
    }

    public function destroy(Request $request,Repository $repository)                 //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        if ($request->user()->id != $repository->user_id )          //El usuario que esta intentando eliminar es dueño del repositorio?.
        {
            abort(403);                                             //Si no es dueño arroja un error 403.
        }

        $repository->delete();                                       //Eliminamos el registro

        return redirect()->route('repositories.index');  //Retornamos a una ruta definida y la vista respository una ves creado y nos muestre la actualizacion.
    }


}
