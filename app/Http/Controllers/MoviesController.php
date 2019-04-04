<?php

namespace App\Http\Controllers;

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
            $title = $request->title;
            if (!empty($request->get('take') && !empty($request->get('skip'))))
            {
                return Movie::where('title', 'LIKE', '%'.$title.'%')->skip($request->skip)->take($request->take)->get();
            }
            return Movie::where('title', 'LIKE', '%'.$title.'%')->get();
        }
        if (!empty($request->get('take') && !empty($request->get('skip'))))
        {
            return Movie::skip($request->skip)->take($request->take)->get();
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
        $newMovie = new Movie($request->validate([
            'title' => 'required|unique:movies,title',
            'genre' => 'string',
            'director' => 'required',
            'duration' => 'required|min:1|max:500',
            'releaseDate' => 'required|unique:movies,releaseDate',
            'imageUrl' => 'url'
        ]));
        if ($newMovie->save())
        {
            return $newMovie;
        }
        return null;
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
        $movie->update($request->all());
        return $movie;
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
