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
                function ($vowel) {
                    return [
                        'name' => $vowel->name,
                        'description' => $vowel->description,
                        'filename' => $vowel->filename,
                    ];
                }
            );
            return response()->json($vowels, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problem with servers' . $e->getMessage()], 500);
        }
    }

    public function getAudio()
    {
        try {

//            TODO check on why we needed this which is commented out
//            $vowel->filename = Storage::disk('s3')->getAdapter()->getPathPrefix() . $vowel->filename;
//
//            $response = new BinaryFileResponse($vowel->filename);
//
//            BinaryFileResponse::trustXSendfileTypeHeader();
//            return $response;
            $fileName = request('filename');

            if (\App::environment('local')) {
                $assetPath = Storage::disk('local')->get($fileName);
            } else {
                $assetPath = Storage::disk('s3')->get($fileName);
            }

            return response(base64_encode($assetPath), 200)
                ->header('Content-Type', 'audio/mpeg')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"')
                ->header('Cache-Control', 'public');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Problem with servers' . $e->getMessage()], 500);
        }

    }

    public function getData()
    {
        \Artisan::call('scrape_french_info');
    }
}
