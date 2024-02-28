<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cinema;
use App\Models\Movie;
use Elasticsearch;

class ElasticsearchController extends Controller
{
    public function search(Request $request)
    { 
        $search_value = $request->get('search_value');
        // $search_type = $request->get('search_type');
        // dd($search_value);
        if ($search_value) {
            $response = Elasticsearch::search([
                'index' => 'movies',
                'body'  => [
                    'query' => [
                        'multi_match' => [
                            'query' => $search_value,
                            'fields' => [
                                'name',
                                'director',
                                'actor',
                                'language',
                                'length',
                                'release',
                                'trailer',
                                'desciption',
                                'rating',
                                'cinemas',
                                'categories' 
                            ]
                        ]
                    ]
                ]
            ]);
            $movies = $response['hits']['hits'];
        }
        else {
            $movies = [];
        }
        return view('search-result', ['movies' => $movies]);
    }
}
