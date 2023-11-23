<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\quiz;
use App\Models\Test;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function index() {
        $quizs = quiz::all();
        return view("page.quizzes.allquizzes", compact("quizs"));
    }

    public function testRecord($qid) {
        $quiz = quiz::find($qid);
        $testes = Test::where('quiz', $qid)->orderBy('id', 'desc')->get();
        return view("page.quizzes.test_record", compact("qid", "testes", "quiz"));
    }

    public function addQuestion($id) {
        $quiz = quiz::find($id);
        return view("page.quizzes.add_question", compact("id", "quiz"));
    }

    public function editQuestion($qid, $id) {
        $quest = Question::find($id);
        return view("page.quizzes.quest_edit", compact("id","quest"));
    }

    public function quizDetail($id) {
        $questions = question::where("quiz", $id)->get();
        $quiz = quiz::find($id);
        return view("page.quizzes.quiz_detail", compact("id", "questions", 'quiz'));
    }

    public function store(Request $request) {
        $request->validate([
            'quizname' => ['required', 'string', 'max:1000'],
            'timelimit' => ['required', 'max:10'],
            'passScore' => ['required', 'max:10'],
        ]);
        try {
            $quiz = quiz::create([
                'title'=> $request->quizname,
                'time_limit'=> $request->timelimit,
                'pass_score'=> $request->passScore,
                'shuffle_quest'=> $request->shuffq ?? false,
                'create_by'=> $request->user()->id,
                'showAns' => $request->showAns ?? false,
            ]);
            return redirect()->back()->with('success','Quiz has been saved.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'quizname' => ['required', 'string', 'max:1000'],
            'timelimit' => ['required', 'max:10'],
            'passScore' => ['required', 'max:10'],
        ]);
        try {
            $quiz = quiz::find($id);
            $quiz->update([
                'title'=> $request->quizname,
                'time_limit'=> $request->timelimit,
                'pass_score'=> $request->passScore,
                'shuffle_quest'=> $request->shuffq ?? false,
                'create_by'=> $request->user()->id,
                'showAns' => $request->showAns ?? false,
            ]);
            return redirect()->back()->with('success','Quiz has been updated.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function destroy($id) {
        try {
            $quiz = quiz::find($id)->delete();
            return response()->json(['success' => 'Question has been deleted.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function storeQuestion(Request $request, $id) {
        try {
            $question = new question;
            $question->quiz = $id;
            $question->title = $request->title;
            $question->score = $request->score;
            $question->shuffle_ch = $request->shuffle ?? false;

            $choices = [];

            if ($request->ansType) // type 1 = choice , type 0 = text
            {
                $choicesNum = $request->choices ?? 0;
                for ($i=1; $i <= $choicesNum; $i++) {
                    $choices[] = [
                        'id'=> $i,
                        'type'=> 'choice',
                        'text'=> $request->input('choice'.$i),
                        'answer'=> $request->input('answer'.$i, 0),
                    ];
                }
            } else {
                $choices[] = [
                    'id'=> 't',
                    'type'=> 'text',
                    'text'=> '',
                    'answer'=> $request->writing,
                ];
            }

            $question->answer = json_encode( $choices );
            $question->type = $request->ansType;  // type 1 = choice , type 0 = text
            $question->save();

            return redirect()->route('quiz.detail', ['id' => $id])->with('success','Question has been saved.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function updateQuestion(Request $request, $id) {
        try {
            $question = Question::find($id);
            $question->title = $request->title;
            $question->score = $request->score;
            $question->shuffle_ch = $request->shuffle ?? false;

            $choices = [];

            if ($request->ansType) // type 1 = choice , type 0 = text
            {
                $choicesNum = $request->choices ?? 0;
                for ($i=1; $i <= $choicesNum; $i++) {
                    $choices[] = [
                        'id'=> $i,
                        'type'=> 'choice',
                        'text'=> $request->input('choice'.$i),
                        'answer'=> $request->input('answer'.$i, 0),
                    ];
                }
            } else {
                $choices[] = [
                    'id'=> 't',
                    'type'=> 'text',
                    'text'=> '',
                    'answer'=> $request->writing,
                ];
            }

            $question->answer = json_encode( $choices );
            $question->type = $request->ansType;  // type 1 = choice , type 0 = text
            $question->save();

            return redirect()->route('quiz.detail', ['id' => $question->quiz])->with('success','Question has been updated.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error',$th->getMessage());
        }
    }

    public function delQuestion($id) {
        try {
            question::find($id)->delete();
            return response()->json(['success' => 'Question has been deleted.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
