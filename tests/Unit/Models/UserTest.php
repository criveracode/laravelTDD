<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_has_many_repositories(): void
    {
        $user = new User;//Creamos un usuario.

        $this->assertInstanceOf(Collection::class,$user->repositories);//Realizamos la consulta si:($user->repositories) es una instancia de las colecciones:(Collection::class), un usuario tiene muchos respos.
    }
}
