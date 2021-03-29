<?php

namespace App\Http\Controllers\api\v1;

use App\DailyQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\DailyQuestionRequest;
use App\Http\Resources\DailyQuestionResource;
use Illuminate\Http\Request;

class DailyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question = DailyQuestion::all();
        return $this->success("Question List",DailyQuestionResource::collection($question));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyQuestionRequest $request)
    {
        $question = new DailyQuestion();
        $question['question'] = $request->question;
        $question->save();
        return $this->success('Created', new DailyQuestionResource($question), 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}