<?php

namespace Tests\Api;

use Tests\TestCase;

class OthersTest extends TestCase
{


    protected $collection1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collection1 = [1 => [
            "product" => "Producto B",
            "price" => 20,
            "stock" => true,
        ]];

    }


    /** @test * */
    function get_collection_test()
    {
        // peticion a url
        $this->get('function-collections')
            // verificara si es exactamente el mismo json obtenido
            ->assertExactJson($this->collection1)

            // Debe contener al menos lo pasado por parametro, no importa si retorna mas
            // ->assertJson($this->collection1)
            // Verifica el codigo de status
            ->assertStatus(200);
    }
}
