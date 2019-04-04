<?php

namespace App\Http\Services;


use App\Movie;

class ValidationService
{
    public static function validateMovie($movieData)
    {
        return new Movie($movieData->validate([
            'title' => 'required|unique:movies,title',
            'genre' => 'string',
            'director' => 'required',
            'duration' => 'required|min:1|max:200',
            'releaseDate' => 'required|unique:movies,releaseDate',
            'imageUrl' => 'url'
        ]));
    }
}