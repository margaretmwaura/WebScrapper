<?php

namespace App\Http\Controllers;

use App\Vowel;
use Illuminate\Http\Request;

class FrenchWordsController extends Controller
{
    public function index()
    {
        try {
            $vowels = Vowel::all();
            return response()->json($vowels, 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error'=>'Problem with servers'], 500);
        }
    }
}
