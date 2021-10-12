<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    public function getAllPizzas() {
        $pizzas = Pizza::get()->toJson(JSON_PRETTY_PRINT);
        return response($pizzas, 200);
    }

    public function getPizza($id) {
        $pizza = Pizza::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($pizza, 200);
    }

    public function createPizza(Request $request) {
        $validation = Validator::make($request->all(), [
            'naam' => 'required|string|max:64',
            'fabrikant' => 'required|string|max:64',
            'prijs' => 'required|numeric',
        ]);

        $errors = $validation->errors();

        if ($validation->fails()) {
            return response()->json([
                "message" => $errors,
                "success" => false
            ], 417);
        }

        $newPizza = Pizza::create($request->all());

        return response()->json([
            "message" => "Pizza is toegevoegd",
            "success" => true
        ], 201);
    }

    public function updatePizza(Request $request) {
        $validation = Validator::make($request->all(), [
            'id'    => 'required|int',
            'naam'  => 'required|string|max:64',
            'fabrikant' => 'required|string|max:64',
            'prijs' => 'required|int',
        ]);

        $errors = $validation->errors();

        if ($validation->fails()) {
            return response()->json([
                "message" => $errors,
                "success" => false
            ], 417);
        }

        if (Pizza::where('id', $request->id)->exists()) {
            $pizza = Pizza::find($request->id);

            $pizza->naam = is_null($request->naam) ? $pizza->naam : $request->naam;
            $pizza->fabrikant = is_null($request->fabrikant) ? $pizza->fabrikant : $request->fabrikant;
            $pizza->prijs = is_null($request->prijs) ? $pizza->prijs : $request->prijs;
            $pizza->save();

            return response()->json([
                "message" => "Pizza is geupdate",
                "success" => true
            ], 200);
        } else {
            return response()->json([
                "message" => "Pizza is niet gevonden",
                "success" => false
            ], 404);
        }
    }

    public function deletePizza($id) {
        if(Pizza::where('id', $id)->exists()) {
            $pizza = Pizza::find($id);
            $pizza->delete();

            return response()->json([
                "message" => "Pizza is verwijderd",
                "success" => true
            ], 202);
        } else {
            return response()->json([
                "message" => "Pizza is niet gevonden",
                "success" => false
            ], 404);
        }
    }
}
