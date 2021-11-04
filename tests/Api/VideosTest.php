<?php

namespace Tests\Api;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VideosTest extends TestCase
{
    /** @test */
    function gets_videos_grouped_by_playlist()
    {
        $this->markTestSkipped();

        // Falseamos que se llama a una url, y le indicamos que valores deberia retornar
        Http::fake([
            url('api/external-videos') => Http::response($this->getJsonData('external-videos'), 200, [])
        ]);

        $this->get('trasnform-from-api-with-collections')
            ->assertJson($this->getJsonData('videos'));
    }

    private function getJsonData($filename)
    {
        return json_decode(file_get_contents(__DIR__."/DataFake/{$filename}.json"), JSON_OBJECT_AS_ARRAY);
    }


}
