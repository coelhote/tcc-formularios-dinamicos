<?php

namespace App\Http\Controllers;

use App\Http\Services\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    private $questionService;

    public function __construct() {
        $this->questionService = new QuestionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->questionService->getAll();
        return ['data' => $response->toArray()];
    }

    public function getAllList()
    {
        $response = $this->questionService->getAll();
        return view('list-question', ['data' => $response->toArray()]);
    }

    public function getAll() {
        $response = $this->questionService->getAllWithAnswers();

        return view('welcome', ['data' => $response->toArray()]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Response $response) {
        $body = $request->all();

        return response()->json($this->questionService->saveOrUpdate($body));
    }

    public function formQuestion() {
        return view('form-question');
    }

    public function editQuestion($id) {
        $question = $this->questionService->findOne($id);

        return view('form-question', [
            'question' => $question,
            'answers' => $question->answers
        ]);
    }

    public function destroy($id) {
        $question = $this->questionService->findOne($id);
        $question->answers()->delete();
        $question->delete();

        return redirect()->route('questions.list');
    }
}
