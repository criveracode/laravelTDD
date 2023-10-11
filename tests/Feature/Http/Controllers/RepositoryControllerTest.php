<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
  
    use RefreshDatabase;
    public function test_guest(): void
    {
        $this->get('repositories')->assertRedirect('login');       //Cuando visites al index() de repos, debe haber una redireccion al login. 
        $this->get('repositories/1')->assertRedirect('login');     //Cuando visites al show() de repos, debe haber una redireccion al login. 
        $this->get('repositories/1/edit')->assertRedirect('login');//Cuando visites al edit() de repos, debe haber una redireccion al login. 
        $this->put('repositories/1')->assertRedirect('login');     //Cuando visites al update() de repos, debe haber una redireccion al login. 
        $this->delete('repositories/1')->assertRedirect('login');  //Cuando visites al destroy() de repos, debe haber una redireccion al login. 
        $this->get('repositories/create')->assertRedirect('login');//Cuando visites al create() de repos, debe haber una redireccion al login. 
        $this->post('repositories',[])->assertRedirect('login');   //Cuando visites al store() de repos, debe haber una redireccion al login. 
    }
}
