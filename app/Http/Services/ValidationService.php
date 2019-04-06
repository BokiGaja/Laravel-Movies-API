<?php

namespace App\Http\Services;


use App\Movie;
use \Illuminate\Support\Facades\Validator;

class ValidationService
{
    public static function validateMovie($movieData)
    {
        $rules = [
            'title' => 'required|unique:movies,title',
            'genre' => 'string',
            'director' => 'required',
            'duration' => 'required|integer|min:1|max:200',
            'releaseDate' => 'required|unique:movies,releaseDate',
            'imageUrl' => 'url'
        ];
        $validator = Validator::make($movieData->all(), $rules);

        if ($validator->fails())
        {
            return $validator->errors()->first();
        } else {
            return true;
        }
    }

    public static function validateUser($userData)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
        $validator = Validator::make($userData->all(), $rules);

        if ($validator->fails())
        {
            return $validator->errors()->first();
        } else {
            return true;
        }
    }
}