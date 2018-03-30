<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles with limit
        $articles = Article::orderBy('created_at', 'desc')->paginate($this->limit);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id = null, Request $request)
    {
        // Create new or update existing article
        $article = $request->isMethod('put') ? Article::findOrFail($id) : new Article();

        if ($request->input('title')) {
            $article->title = $request->input('title');
        }
        if ($request->input('body')) {
            $article->body = $request->input('body');
        }

        if ($article->save()) {
            return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get single article or throw 404 error
        $article = Article::findOrFail($id);

        // Get single article as a resource
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get single article or throw 404 error
        $article = Article::findOrFail($id);

        // Delete and return deleted resource
        if ($article->delete()) {
            return new ArticleResource($article);
        }
    }
}
