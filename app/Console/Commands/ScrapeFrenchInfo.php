<?php

namespace App\Console\Commands;

use DOMDocument;
use Illuminate\Console\Command;
use Goutte\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpClient\HttpClient;




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
        $letters_array = [];
        $crawler->filter('.output')->each(function ($node) use ($letters_array){
            $content =  $node->text();
            $word = $content[0];
            array_push($letters_array,$word);
            foreach ($letters_array as $letter)
            {
                print $letter . "\n";
            }
        });
        $html = file_get_contents('https://www.rocketlanguages.com/french/lessons/french-alphabet');

        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $tags = $doc->getElementsByTagName('audio');

        foreach ($tags as $tag) {
            $url = $tag->getAttribute('src');
            echo $tag->getAttribute('src')."\n";
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            Storage::put('file.txt', $data);
            curl_close($ch);
            return ;
        }
    }
}
