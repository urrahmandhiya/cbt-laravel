<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuestionPackage;

class QuestionController extends Controller
{
    public function index($questionPackageId)
    {
        Session::put('question_package_id', $questionPackageId);

        // Fetch the corresponding QuestionPackage
        $questionPackage = QuestionPackage::find($questionPackageId);

        // Fetch questions related to the QuestionPackage
        $questions = Question::with('answers')->where('package_id', $questionPackageId)->get();

        return view('exam.question', compact('questionPackage', 'questions'));
    }

    public function create($questionPackageId)
    {
        // Uncomment the following line to check the cache before clearing
        // dd(Cache::get('example-cache'));

        // Clear the cache after displaying the value
        Cache::forget('example-cache');

        // Fetch the corresponding QuestionPackage
        $questionPackage = QuestionPackage::find($questionPackageId);

        // Initialize an empty array for questions (if needed)
        $questions = [];

        // Pass the variables to the view
        return view('exam.createquestion', compact('questionPackage', 'questions'));
    }

    public function store(Request $request)
    {
        // Retrieve the package_id from the session
        $questionPackageId = Session::has('question_package_id') ? Session::get('question_package_id') : null;

        $request->validate([
            'number' => 'required|integer',
            'text' => 'required|string',
            'answers' => 'required|array|min:4',
            'correct_answer' => 'required|string|in:A,B,C,D', // Adjusted validation rule
        ]);

        // Create the question
        $question = new Question([
            'package_id' => $questionPackageId,
            'number' => $request->input('number'),
            'text' => $request->input('text'),
        ]);

        $question->save();

        // Create the associated answers
        foreach ($request->input('answers') as $letter => $answerText) {
            $isCorrect = $request->input('correct_answer') == $letter;

            $question->answers()->create([
                'text' => $answerText,
                'is_correct' => $isCorrect,
                'score' => $isCorrect ? 10 : 0,
            ]);
        }
        
        $questionPackage = QuestionPackage::find($questionPackageId);
        return redirect()->route('question.index', ['questionPackage' => $questionPackage])->with('success', 'Question created successfully!');
    }

    public function edit(Question $question)
    {
        // Eager load the answers for the question
        $question = Question::with('answers')->find($question->id);

        // Assuming you need the corresponding QuestionPackage for editing
        $questionPackage = QuestionPackage::find($question->package_id);

        // Fetch the answers related to the question
        $answers = $question->answers->pluck('text', 'number')->toArray();

        return view('exam.editquestion', compact('question', 'questionPackage', 'answers'));
    }

    public function destroy(Question $question)
    {
        // Delete associated answers
        $question->answers()->delete();

        // Delete the question
        $question->delete();

        $questionPackage = QuestionPackage::find($question->package_id);
        return redirect()->route('question.index', ['questionPackage' => $questionPackage])->with('success', 'Question created successfully!');
    }
}
