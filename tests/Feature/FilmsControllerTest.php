<?php

namespace Tests\Feature;

use App\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Util\Getopt;
use Tests\TestCase;

/**
 * Class FilmsControllerTest
 * @package Tests\Feature
 * @covers
 */
class FilmsControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function shows_no_film_at_init_state()
    {
        // 1 PREPARE SKIP

        // 2 EXECUTE
        $this->withoutExceptionHandling();
        $response = $this->json('GET', '/api/v1/films');

        // 3
        $response->assertSuccessful();
        //$response-> HTTP RESPONSE MESSAGE HTTP PAQUET
        $filmsJSON = $response->getContent();
        $films = json_decode($filmsJSON);

//        dump($filmsJSON);
//        dump($films);

        $response->assertExactJson([]);
        $response->assertJsonCount(0);
        $this->assertEquals($filmsJSON, "[]");
        $this->assertCount(0, $films);

    }

    /** @test */
    public function shows_films_ok()
    {
        // 1 PREAPRE -> SEED DATABASE WITH

        // MODELS
        Film::create([
            'name' => 'Star Wars'
        ]);

        Film::create([
            'name' => 'Avengers'
        ]);

        Film::create([
            'name' => 'Lord Of The Rings'
        ]);

        // 2 EXECUTE
        $response = $this->json('GET', '/api/v1/films');

        $response->assertSuccessful();
        //$response-> HTTP RESPONSE MESSAGE HTTP PAQUET
        $filmsJSON = $response->getContent();
        $films = json_decode($filmsJSON);

        $response->assertJsonCount(3);
        $this->assertCount(3, $films);
        $this->assertEquals($films[0]->name, 'Star Wars');
        $this->assertEquals($films[1]->name, 'Avengers');
        $this->assertEquals($films[2]->name, 'Lord Of The Rings');


    }
}
