<?php

namespace App\Http\Controllers;

use App\Http\Services\MoviesService;
use App\Http\Services\ValidationService;
use App\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->get('title')))
        {
            if (!empty($request->get('take') && !empty($request->get('skip'))))
            {
                return MoviesService::searchAndPaginate($request);
            }
            return MoviesService::searchMovieTitle($request);
        }
        if (!empty($request->get('take') && !empty($request->get('skip'))))
        {
            return MoviesService::paginate($request);
        }
        return Movie::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = ValidationService::validateMovie($request);
        if (!is_string($validator))
        {
            $newMovie = new Movie($request->all());
            $newMovie->save();
        } else {
            return $validator;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return $movie;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validator = ValidationService::validateMovie($request);
        if (!is_string($validator))
        {
            $movie->update($request->all());
            return "Movie successfully updated";
        } else {
            return $validator;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if ($movie->delete())
        {
            return 'Movie with id: '.$movie->id.' has been deleted.';
        };
        return null;
    }
}
