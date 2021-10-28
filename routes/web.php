<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;


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


Route::get('arrays-with-collection', function () use ($values) {

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


Route::get('function-collections', function () {


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
