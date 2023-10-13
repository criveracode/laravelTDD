<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_home(): void
    {
        $repository = Repository::factory()->create(); //Creamos un nuevo repositorio.

        $this
        ->get('/')
        ->assertStatus(200)
        ->assertSee($repository->url)
        ;

    }
}
