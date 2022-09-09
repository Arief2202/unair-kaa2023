<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerFileRequest;
use App\Http\Requests\UpdateAnswerFileRequest;
use App\Models\AnswerFile;

class AnswerFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnswerFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswerFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnswerFile  $answerFile
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerFile $answerFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnswerFile  $answerFile
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerFile $answerFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnswerFileRequest  $request
     * @param  \App\Models\AnswerFile  $answerFile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswerFileRequest $request, AnswerFile $answerFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnswerFile  $answerFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerFile $answerFile)
    {
        //
    }
}
