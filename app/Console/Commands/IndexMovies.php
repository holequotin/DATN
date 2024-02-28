<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Movie;
use Elasticsearch;

class IndexMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:movies';

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
     * @return int
     */
    public function handle()
    {
        $movies = Movie::all()->load('categories','cinemas','rating','images');
        foreach ($movies as $movie) {
            $cinemas = [];
            foreach ($movie->cinemas as $cinema){
                array_push($cinemas,$cinema->name);
            }
            $cinemas = join(',',$cinemas);

            $categories = [];
            foreach ($movie->categories as $category){
                array_push($categories,$category->name);
            }
            $categories = join(',',$categories);

            try {
                Elasticsearch::index([
                    'id' => $movie->id,
                    'index' => 'movies',
                    'body' => [
                        'name' => $movie->name,
                        'director' => $movie->director,
                        'actor' => $movie->actor,
                        'language' => $movie->language,
                        'length' => $movie->length,
                        'release' => $movie->release,
                        'trailer' => $movie->trailer,
                        'desciption' => $movie->desciption,
                        'rating' => $movie->rating->name,
                        'cinemas' => $cinemas,
                        'categories' => $categories,
                        'image' => $movie->images[0]->path
                    ]
                ]);
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $this->info("Movies were successfully indexed");
    }
}
