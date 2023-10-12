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

    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,        //Nuestro formulario queremos salvar una url y una descripcion.
        ];

        $user = User::factory()->create();              //Creamos un usuario que iniciara sesion.

        $this
            ->actingAs($user)                           //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->post('repositories', $data)               //Lo enviamos al servidor mediante post, a la ruta que ya configuramos('repositories') a traves del formulario que creamos:($data)
            ->assertRedirect('repositories');           //Redireccionamos a la vista del repo:('repositoires')

        $this
            ->assertDatabaseHas('repositories', $data); //Verificamos la informacion en la DB, tabla('repositories') 
    }

    public function test_update()
    {
        $repository = Repository::factory()->create();  //Creamos un elemento repositorio.
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,        //Nuestro formulario queremos salvar una url y una descripcion.
        ];

        $user = User::factory()->create();              //Creamos un usuario que iniciara sesion.

        $this
            ->actingAs($user)                                      //Iniciaremos sesion y le diremos actua como el usuario que acabamos de crear.
            ->put("repositories/$repository->id", $data)           //Actulizamos mediante put, como recibiremos variables utilizamos "repositories", cuyo id sea el que ingresaremos:($repository->id)
            ->assertRedirect("repositories/$repository->id/edit"); //Redireccionamos a la vista del repo:('repositoires')

        $this
            ->assertDatabaseHas('repositories', $data);            //Verificamos la informacion en la DB, tabla('repositories') 
    }

}
