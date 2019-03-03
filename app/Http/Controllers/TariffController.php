<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tariff;

/***TODO: enable update, create, delete ***/
class TariffController extends Controller
{
    public function index()
    {
        return Tariff::all();
    }

    public function show(Tariff $tariff)
    {
        return $tariff;
    }

    public function store(Request $request)
    {
        $tariff = Tariff::create($request->all());

        return response()->json($tariff, 201);
    }

    public function update(Request $request, Tariff $tariff)
    {
        $tariff->update($request->all());

        return response()->json($tariff, 200);
    }

    public function delete(Tariff $tariff)
    {
        $tariff->delete();

        return response()->json(null, 204);
    }
}
