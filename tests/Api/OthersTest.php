<?php

namespace Tests\Api;

use Tests\TestCase;


// Permite colocar agrupaciones a las pruebas de forma que se puedan llamar, desde la consola
// Bien sea para ejecutar una agrupacion o excluirla

/*
 * // Ejecutando solo una agrupacion de pruebas
 * .\vendor\bin\phpunit --group <<pruebasColecciones>>
 *
 * // Ejecutando las pruebas excluuendo una agrupacion de pruebas
 * .\vendor\bin\phpunit --exclude-group <<pruebasColecciones>>
 * */

/**
 * @group pruebasColecciones
 * @group TICKET-123
 * */

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
