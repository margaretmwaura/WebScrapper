<?php

namespace App\Console\Commands;

use App\Vowel;
use DOMDocument;
use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;


class ScrapeFrenchInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape_french_info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new Client();
        $crawler = $client->request('GET', 'https://www.rocketlanguages.com/french/lessons/french-alphabet');
        $html = file_get_contents('https://www.rocketlanguages.com/french/lessons/french-alphabet');
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $tags = $doc->getElementsByTagName('audio');
        $description_array = [];
        $letters_array = $crawler->filter('.output')->each(function ($node) {
            return $letters[] = $node->text();
        });
        dd($letters_array);
        $crawler->filter('.output')->each(function ($node) use ($letters_array,$description_array){
            $content = $node->text();
            $word = explode(" " , $content);
            echo $word[0]."\n";
            echo $word[1]."\n";
            array_push($letters_array,$word[0]);
            print_r($letters_array);
            array_push($description_array,$word[1]);
            print_r($description_array);
            $letters_array[] = $word[0];
            $description_array[] = $word[1];
        });
        $filenames = [];
        foreach ($tags as $tag) {
            $url = $tag->getAttribute('src');
            echo $tag->getAttribute('src')."\n";
            $urlParts = explode("/", $url);
            print $urlParts[6]."\n";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            Storage::disk('local')->put($urlParts[6], $data);
            curl_close($ch);
            array_push($filenames,$urlParts[6]);
        }
        for ($i = 0 ; $i < count($filenames) ; $i++)
        {
            $vowel = new Vowel();
            dd($letters_array);
            $vowel->name = $letters_array[$i];
            $vowel->description = $description_array[$i];
            $vowel->filename = $filenames[$i];
            $vowel->save();

        }
    }
}
