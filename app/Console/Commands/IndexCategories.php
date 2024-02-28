<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Movie;
use Elasticsearch;

class IndexCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:categories';

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
        $categories = Category::all();

        foreach ($categories as $category) {
            try {
                Elasticsearch::index([
                    'id' => $category->id,
                    'index' => 'categories',
                    'body' => [
                        'name' => $category->name,
                        'detail' => $category->detail
                    ]
                ]);
            } catch (Exception $e) {
                $this->info($e->getMessage());
            }
        }

        $this->info("Categories were successfully indexed");
    }
}
