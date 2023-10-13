<?php

namespace App\Http\Controllers;

use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;

class RepositoryController extends Controller
{
    public function index()
    {
        return view('repositories.index', [
            'repositories' => auth()->user()->repositories
        ]);
    }

    public function show(Repository $repository)   //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        $this->authorize('pass',$repository);                                

        return view('repositories.show', compact('repository'));    //Retornamos a una vista.
    }

    public function edit(Repository $repository)   //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        $this->authorize('pass',$repository);                                 

        return view('repositories.edit', compact('repository'));    //Retornamos a una vista.
    }

    public function create()                                        //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        return view('repositories.create');                         //Retornamos a una vista.
                                

   }

    
    public function store(RepositoryRequest $request)                        //Vamos a recibir todo lo que enviamos a traves del form mediante un request.
    {

        $request->user()->repositories()->create($request->all()); //Estamos diciendo que cree un elemento con el metodo de las relaciones usando el id del usuario logueadode manera masiva.

        return redirect()->route('repositories.index');            //Retornamos a una ruta definida y la vista index una ves creado.
    }

    public function update(RepositoryRequest $request,Repository $repository) //Vamos a recibir todo lo que enviamos a traves del form mediante un request y el ropositorio.
    {

        $this->authorize('pass',$repository);

        $repository->update($request->all());                       //Actualizamos el repositorio seleccionado de manera masiva

        return redirect()->route('repositories.edit',$repository);  //Retornamos a una ruta definida y la vista respository una ves creado y nos muestre la actualizacion.
    }

    public function destroy(Repository $repository)                 //Vamos a recibir todo lo que enviamos a traves del el ropositorio.
    {

        $this->authorize('pass',$repository);

        $repository->delete();                                       //Eliminamos el registro

        return redirect()->route('repositories.index');  //Retornamos a una ruta definida y la vista respository una ves creado y nos muestre la actualizacion.
    }




}

/**
 *   if ($request->user()->id != $repository->user_id )          //El usuario que esta intentando eliminar es dueño del repositorio?.
*      {
*           abort(403);                                             //Si no es dueño arroja un error 403.
 * }
 */