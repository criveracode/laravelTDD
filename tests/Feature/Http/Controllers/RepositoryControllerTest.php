<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{

    use RefreshDatabase;
    use RefreshDatabase;
    use WithFaker;

    public function test_guest(): void
    {

        $this->get('repositories')->assertRedirect('login');        //Cuando visites al index() de repos, debe haber una redireccion al login. 
        $this->get('repositories/1')->assertRedirect('login');      //Cuando visites al show() de repos, debe haber una redireccion al login. 
        $this->get('repositories/1/edit')->assertRedirect('login'); //Cuando visites al edit() de repos, debe haber una redireccion al login. 
        $this->put('repositories/1')->assertRedirect('login');      //Cuando visites al update() de repos, debe haber una redireccion al login. 
        $this->delete('repositories/1')->assertRedirect('login');   //Cuando visites al destroy() de repos, debe haber una redireccion al login. 
        $this->get('repositories/create')->assertRedirect('login'); //Cuando visites al create() de repos, debe haber una redireccion al login. 
        $this->post('repositories', [])->assertRedirect('login');   //Cuando visites al store() de repos, debe haber una redireccion al login. 
    }

    public function test_index_empty()
    {
        Repository::factory()->create(); // user_id = 1

        $user = User::factory()->create(); // id = 2

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios creados');
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create(); // id = 1
        $repository = Repository::factory()->create(['user_id' => $user->id]); // user_id = 1

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
    }

    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,                    //Nuestro formulario queremos salvar una url y una descripcion.
        ];

        $user = User::factory()->create();                          //Creamos un usuario que iniciara sesion.

        $this
            ->actingAs($user)                                       //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->post('repositories', $data)                           //Lo enviamos al servidor mediante post, a la ruta que ya configuramos('repositories') a traves del formulario que creamos:($data)
            ->assertRedirect('repositories');                       //Redireccionamos a la vista del repo:('repositoires')

        $this
            ->assertDatabaseHas('repositories', $data);             //Verificamos la informacion en la DB, tabla('repositories') 
    }

    public function test_update()
    {
        $user = User::factory()->create();                                     //Creamos un usuario que iniciara sesion.
        $repository = Repository::factory()->create(['user_id' => $user->id]); //Creamos un elemento repositorio.
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,                               //Nuestro formulario queremos salvar una url y una descripcion.
        ];

        $this
            ->actingAs($user)                                                  //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->put("repositories/$repository->id", $data)                       //Actulizamos mediante put, como recibiremos variables utilizamos "repositories", cuyo id sea el que ingresaremos:($repository->id)
            ->assertRedirect("repositories/$repository->id/edit");             //Redireccionamos a la vista del repo:('repositoires')

        $this
            ->assertDatabaseHas('repositories', $data);                        //Verificamos la informacion en la DB, tabla('repositories') 
    }

    public function test_distroy()
    {
       $user = User::factory()->create();                                     //Creamos un usuario que iniciara sesion.
       $repository = Repository::factory()->create(['user_id' => $user->id]); //Creamos un elemento repositorio.
       

       $this
           ->actingAs($user)                                                  //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
           ->delete("repositories/$repository->id")                           //Cuando eliminemos un dato.
           ->assertRedirect('repositories');                                  //Quiero que se redireccione al index de repos.

           $this->assertDatabaseMissing('repositories',                       //Revisa en la base de datos, que no exista esta informacion, la que acabamos de eliminar.
           $repository->toArray()); 
       
    }

    /*
     * Validaciones
     */

    public function test_validate_store()
    {
        
        $user = User::factory()->create();                          //Creamos un usuario que iniciara sesion.

        $this
            ->actingAs($user)                                       //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->post('repositories', [])                              //Lo enviamos al servidor mediante post, a la ruta que ya configuramos('repositories') pero validamos que no este vacio el formulario.
            ->assertStatus(302)                                     // validamos que no este vacio el formulario, en caso contrario muestre el error 302.
            ->assertSessionHasErrors(['url','description']);        //Luego vemos los mensajes de error en la vista
    }


    public function test_validate_update()
    {
        $repository = Repository::factory()->create();              //Creamos un elemento repositorio.
        $user = User::factory()->create();                          //Creamos un usuario que iniciara sesion.

        $this
            ->actingAs($user)                                       //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->put("repositories/$repository->id", [])               //Actulizamos mediante put, validamos que no esta vacio.
            ->assertStatus(302)                                     // validamos que no este vacio el formulario, en caso contrario muestre el error 302.
            ->assertSessionHasErrors(['url','description']);        //Luego vemos los mensajes de error en la vista
   
     }


     /*
      * Politicas de acceso 
      */

      public function test_update_policy()
    {
        $user = User::factory()->create();                          //Creamos un usuario que iniciara sesion.
        $repository = Repository::factory()->create();              //Creamos un elemento repositorio.
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,                    //Nuestro formulario queremos salvar una url y una descripcion.
        ];

        $this
            ->actingAs($user)                                      //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->put("repositories/$repository->id", $data)           //Actulizamos mediante put, como recibiremos variables utilizamos "repositories", cuyo id sea el que ingresaremos:($repository->id)
            ->assertStatus(403);                                   //Cuando queremos actulizar algo que no pertenece al usuario el servidor responde este error.
    }

    public function test_distroy_policy()
     {
        $user = User::factory()->create();                          //Creamos un usuario que iniciara sesion.
        $repository = Repository::factory()->create();              //Creamos un elemento repositorio.
        


        $this
            ->actingAs($user)                                       //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->delete("repositories/$repository->id")                //Cuando eliminemos un dato.
            ->assertStatus(403);                                    //Cuando queremos eliminar algo que no pertenece al usuario el servidor responde este error.
     }

}




