<?php

namespace App\Http\Controllers;

use App\Vowel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FrenchWordsController extends Controller
{
    public function index()
    {
//        return response()->download($vowels[0]['filename'], 200);
        try {
           $vowels = Vowel::all()->map(
                function ($vowel)
                {
                    return[
                        'name' => $vowel->name,
                        'description' => $vowel->description,
                        'filename' => $vowel->filename
                    ];
                }
            );
            return response()->json($vowels, 200);
        }
        catch (\Exception $e)
        {
            return response()->json(['error'=>'Problem with servers' . $e->getMessage()], 500);
        }
    }

    public function getAudio()
    {
//        'filename' => Storage::disk('local')->getAdapter()->getPathPrefix().$vowel->filename
         Log::info("This is what I got ".request('filename'));
        $vowel = Vowel::where('filename', request('filename'))->first();
        try {

            $vowel->filename = Storage::disk('local')->getAdapter()->getPathPrefix() . $vowel->filename;

            $response = new BinaryFileResponse($vowel->filename);

            BinaryFileResponse::trustXSendfileTypeHeader();
            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problem with servers' . $e->getMessage()], 500);
        }

    }
}
