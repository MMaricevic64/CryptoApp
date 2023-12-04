<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoCurrency;

class CryptoController extends Controller
{
    public function index()
    {
        $cryptos = CryptoCurrency::all();
        $topCryptos = CryptoCurrency::orderBy('percent_change_15m', 'desc')->take(10)->get();

        return view('index', compact('cryptos', 'topCryptos'));
    }

    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric',
        ]);

        try {
            $crypto = CryptoCurrency::findOrFail($id);

            $crypto->update([
                'price' => $request->price,
                'update_enabled' => false, #Setting update_enabled to false to prevent future updates from API
            ]);

            return redirect('/crypto')->with('success', 'Price updated successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect('/crypto')->with('error', 'Crypto not found.');
        }
    }
}
