<?php

use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$values = [1, 2, 3, 4, 5, 6];

Route::get('/arrays-with-php', function () use ($values) {

// Filtrado manual de numeros pares
    $valuesFiltered = array_filter($values, function ($value) {
        return $value % 2 == 0;
    });

// Realizando una operacion para cada valor del array
    $valuesMap = array_map(function ($value) {
        return $value * 2;
    }, $valuesFiltered);

// Extrayendo los valores sin los indices
    $onlyValues = array_values($valuesMap);

    return $onlyValues;

});


Route::get('/arrays-with-collection', function () use ($values) {

    // 1. Forma de crear
    // $collection = new Collection($values);

    // 2. Usando el metodo collect, que usa un metodo global de laravel y permite retorne la instancia y poder encadenar operaciones
    // $collection = new collect($values);

    // 3. Usando el metodo estadico make, para que retorne la instancia y poder encadenar operaciones
    $collection = Collection::make($values)
        ->filter(function ($value) {
            return $value % 2 == 0;
        })
        ->map(function ($value) {
            return $value * 2;
        })
        ->values();

    return $collection;
    // Permite retornar solo los valores del arreglo y ya no una collection
    // ->all();

});


Route::get('/function-collections', function () {


    $data = [
        ['product' => 'Producto A', 'price' => 10, 'stock' => true],
        ['product' => 'Producto B', 'price' => 20, 'stock' => true],
        ['product' => 'Producto C', 'price' => 10, 'stock' => false],
    ];


    $products = collect($data);

// price => especifica la llave por la cual debe hacer la operacion
    $sumPriceProducts = $products->sum('price');

// where => permite filtrar por condiciones un array
// price(llave) y el segundo parametro  las condiciones
    $productWithStock = $products->where('stock', true)
        ->where('price', '>', '10');


    return $productWithStock;

});


Route::get('/function-collections-2', function () use ($values) {

    $numbers = collect($values);
    // Divide el array en las porciones especifcadas por parametro
    $numbersSplit = $numbers->split(3);

    // Divide el array armando tantas diviciones para cumplir con el valor del parametro
    $numbersChunck = $numbers->chunk(3);

});


Route::get('/trasnform-from-api-with-collections', function () {
    $apiUrl = url('api/external-videos'); // http://localhost/laravel/laravel-collection/public/api/external-videos


    $response = Http::get($apiUrl);

    // parseando a json lo obtenido y obteniendo la llave data
    $data = $response->json()['data'];


    return collect($data)
        // para cada registro
        ->map(function ($row) {
            return [
                'title' => $row['title'],
                'description' => $row['description'],
                'length' => $row['length'],
                'score' => $row['likes'] + $row['views'],
                'channel' => $row['channel']['name'],
                'author' => $row['channel']['author']['name'],
                // separa el estrin por comas, y cada palabra como mayus
                'tags' => collect(explode(',', $row['tags']))
                    ->map(function ($tag) {
                        return ucfirst($tag);
                    })
                    ->all(),
                'playlist' => $row['playlist'],
            ];
        })
        // Los resultados los agrupa por la llave pasada por parametro
        ->groupBy('playlist')
        ->map(function ($videos, $playlistName) {
            return [
                'name' => Str::title($playlistName),
                'length' => $videos->sum('length'),
                'videos' => $videos
            ];
        });
});


/*
 * Modificando en la ruta el ID por el cual se puede buscar en la BD el parametro
 *
 * // Para el modelo post usara la columna slug para hacer la consulta
 * post:slug
 * */
Route::get('posts/{post:slug}', function (Post $post) {
    return $post;
});
