<?php

namespace App\Http\Services;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionService
{

    public function getAll() {
        return Question::select('id', 'description', 'type', 'created_at', 'updated_at')->get();
    }

    public function getAllWithAnswers() {
        return Question::with('answers')->get();
    }

    public function findOne($id) {
        return Question::with('answers')->find($id);
    }


    public function saveOrUpdate($body, $id = null) {

        try {
            DB::beginTransaction();
            if ($id) {
                $question = Question::find($body['id']);
            } else {
                $question = new Question();
            }

            $question->description = $body['description'];
            $question->type = $body['type'];
            $question->save();

            $questionId = $question->id;

            if (isset($body['options'])) {
                $question->answers()->delete();
                foreach ($body['options'] as $option) {
                    $answerModel = new Answer();
                    $answerModel->question_id = $questionId;
                    $answerModel->description = $option['description'];
                    $answerModel->value = $option['value'];
                    $answerModel->save();
                }
            }
    
            DB::commit();
            return $question;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    
    }
}
