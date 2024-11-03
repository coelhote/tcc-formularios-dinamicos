<?php

namespace App\Http\Controllers;

use App\Http\Services\FormService;
use App\Http\Services\QuestionService;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    private $formService;

    public function __construct() {
        $this->formService = new FormService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->formService->getAll();
        return view('list-form', ['data' => $response->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $body = $request->all();
        return response()->json($this->formService->saveOrUpdate($body));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = Form::find($id);
        DB::statement('DELETE FROM form_question WHERE form_id = ?', [$id]);
        DB::statement('DELETE FROM formula_response WHERE formula_id IN (SELECT id FROM formula WHERE form_id = ?)', [$id]);
        DB::statement('DELETE FROM formula WHERE form_id = ?', [$id]);
        DB::statement('DELETE FROM response WHERE form_id = ?', [$id]);
        $form->delete();

        return redirect()->route('forms.list');
    }

    public function formForm() {
        $response = (new QuestionService)->getAll();
        return view('form-form', ['data' => $response->toArray()]);
    }

    public function editForm($id) {
        $response = $this->formService->findOne($id);

        return view('form-form', [
            'form' => $response['form'],
            'questions' => $response['questions'],
            'formulas' => $response['formula']
        ]);
    }

    public function homePage() {
        $response = $this->formService->getAll();
        return view('home-page', ['data' => $response->toArray()]);
    }

    public function response($id, $protocol) {
        $response = $this->formService->findOneWithAnswers($id);

        return view('form-response', [
            'form' => $response['form'],
            'steps' => $response['steps'],
        ]);
    }

    public function protocol($protocol) {
        $response = $this->formService->protocol($protocol);

        return response()->json($response);
    }
}
