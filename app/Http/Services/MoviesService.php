<?php


namespace App\Http\Services;


use App\Movie;

class MoviesService
{
    public static function searchMovieTitle($movieData)
    {
        return Movie::where('title', 'LIKE', '%'.$movieData->title.'%')->get();
    }

    public static function paginate($movieData)
    {
        return Movie::skip($movieData->skip)->take($movieData->take)->get();
    }

    public static function searchAndPaginate($movieData)
    {
        $filteredMovies =  Movie::where('title', 'LIKE', '%'.$movieData->title.'%')->skip($movieData->skip)->take($movieData->take)->get();
        if (count($filteredMovies) > 0)
        {
            return $filteredMovies;
        }
        else {
            return Movie::all();
        }
    }
}