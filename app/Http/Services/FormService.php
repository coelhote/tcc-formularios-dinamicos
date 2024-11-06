<?php

namespace App\Http\Services;

use App\Models\Form;
use App\Models\FormQuestion;
use App\Models\Formula;
use App\Models\FormulaResponse;
use App\Models\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormService {
    public function getAll() {
        return Form::select('id', 'name', 'updated_at')->get();
    }

    public function findOne($id) {
        $form = Form::find($id);
        $formQuestions = FormQuestion::with('question')->where('form_id', $id)->get();
        $formula = Formula::with('responses')->where('form_id', $id)->get();

        return ['form' => $form, 'questions' => $formQuestions, 'formula' => $formula];
    }

    public function findOneWithAnswers($id) {
        $form = Form::find($id);
    
        if (!$form) {
            // Retornar um erro ou um redirecionamento caso o formulário não exista
            abort(404);
        }
    
        // Obter as etapas distintas
        $steps = FormQuestion::select('step')->distinct()->where('form_id', $id)->get();
    
        $return = ['steps' => []]; // Inicializando o array de retorno
    
        foreach ($steps as $step) {
            $formQuestions = FormQuestion::with('question.answers')
                ->where('form_id', $id)
                ->where('step', $step->step)
                ->get();
    
            $formula = Formula::with('responses')
                ->where('form_id', $id)
                ->where('form_step', $step->step)
                ->first();
    
            $return['steps'][] = [
                'formQuestions' => $formQuestions->toArray(),
                'formula' => $formula->toArray(),
                'step' => $step->step,
            ];
        }
    
        return ['form' => $form, 'steps' => $return['steps']];
    }
    

    public function saveOrUpdate($body) {

        try{
            DB::beginTransaction();
            if (isset($body['id'])) {
                $form = Form::find($body['id']);
            } else {
                $form = new Form();
            }

            $form->name = $body['name'];
            $form->save();

            $formId = $form->id;
            $keyFormQuestion = 1;
            if (isset($body['steps'])) {
                DB::statement('DELETE FROM form_question WHERE form_id = ?', [$formId]);
            }
            foreach ($body['steps'] as $steps) {
                foreach ($steps['questions'] as $questionId) {
                    $formQuestion = new FormQuestion();
                    $formQuestion->form_id = $formId;
                    $formQuestion->question_id = $questionId;
                    $formQuestion->order = $keyFormQuestion;
                    $formQuestion->step = $steps['number'];
                    $formQuestion->save();

                    $keyFormQuestion++;
                }

                $formulaStep = Formula::where('form_id', $formId)->where('form_step', $steps['number'])->first();

                if (!$formulaStep) {
                    $formulaStep = new Formula();
                }

                $formulaStep->form_id = $formId;
                $formulaStep->form_step = $steps['number'];
                $formulaStep->description = $steps['formula'];
                $formulaStep->save();

                $formulaResponse = FormulaResponse::where('formula_id', $formulaStep->id)->get();

                if (count($formulaResponse)) {
                    DB::statement('DELETE FROM formula_response WHERE formula_id = ?', [$formulaStep->id]);
                }

                if (isset($steps['formula_response'])) {
                    $conditions = $steps['formula_response']['conditions'];
                    $responses = $steps['formula_response']['responses'];
                    $responseTypes = $steps['formula_response']['response_types'];
    
                    foreach ($conditions as $key => $condition) {
                        $formulaResponse = new FormulaResponse();
                        $formulaResponse->formula_id = $formulaStep->id;
                        $formulaResponse->condition = $condition;
                        $formulaResponse->response = $responses[$key];
                        $formulaResponse->response_type = $responseTypes[$key];
                        $formulaResponse->save();
                    }
                }
            }

            DB::commit();
            return $form;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $e;
        }
    }

    public function protocol($protocol) {
        $responseData = Response::select('protocol', 'form_id', 'responseType', 'responseText')->with('form')->where('uuid', $protocol)->first();

        return $responseData;
    }
}