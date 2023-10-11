<?php

namespace Tests\Unit\Models;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;//Agregamos este metodo.

class RepositoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_belongs_to_user(): void
    {
        $repository = Repository::factory()->create();//Creamos un registro falso.

        $this->assertInstanceOf(User::class,$repository->user);//Realizamos la consulta si:($repository->user) es una instancia del usuario:(User::class).
    }
}
