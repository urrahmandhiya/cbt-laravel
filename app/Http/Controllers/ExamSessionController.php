<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\QuestionPackage;
use App\Models\Question;
use App\Models\Result;
use App\Models\Answer;

class ExamSessionController extends Controller
{
    public function create()
    {
        $questionPackages = QuestionPackage::all();
        return view('exam.start', compact('questionPackages'));
    }

    public function start(Request $request, $questionPackageId)
    {
        $questionPackage = QuestionPackage::findOrFail($questionPackageId);

        // Store information about the exam session in the session
        Session::put('exam_session', [
            'question_package_id' => $questionPackage->id,
            // Add other relevant information about the exam session
        ]);

        // Redirect to the exam session with the necessary parameter
        return redirect()->route('exam.session', ['questionPackage' => $questionPackage->id]);
    }


    public function show($session)
    {
        // Retrieve the exam session data from the session
        $examSession = Session::get('exam_session');

        // Get the question package ID from the exam session data
        $questionPackageId = $examSession['question_package_id'];

        // Fetch the corresponding QuestionPackage
        $questionPackage = QuestionPackage::findOrFail($questionPackageId);

        // Fetch questions related to the QuestionPackage
        $questions = Question::with('answers')->where('package_id', $questionPackageId)->get();

        // Pass the variables to the view
        return view('exam.session', compact('examSession', 'questionPackage', 'questions'));
    }


    public function submit(Request $request, QuestionPackage $questionPackage)
    {
        // Handle form submission, calculate results, and store them in the database

        $totalScore = 0;

        // Assuming your form fields are structured like answers[question_id] = selected_answer_id
        foreach ($request->input('answers') as $questionId => $selectedAnswerId) {
            $question = Question::find($questionId);
            $selectedAnswer = Answer::find($selectedAnswerId);

            if ($question && $selectedAnswer && $selectedAnswer->is_correct) {
                // Increase the total score for each correct answer
                $totalScore += $selectedAnswer->score;
            }
        }

        // Store the results in the database (create a new Result model instance)
        // Redirect to the result page with the session information
        $result = Result::create([
            'user_id' => auth()->id(),
            'question_package_id' => $questionPackage->id,
            'result' => $totalScore,
        ]);

        return redirect()->route('exam.result', [
            'questionPackage' => $questionPackage->id,
            'user' => auth()->user()->id,
        ]);
    }

    public function result($questionPackageId)
    {
        // Get the corresponding QuestionPackage
        $questionPackage = QuestionPackage::findOrFail($questionPackageId);

        // Get all users who attempted the exam for the specified question package
        $users = User::whereHas('results', function ($query) use ($questionPackageId) {
            $query->where('question_package_id', $questionPackageId);
        })->get();

        return view('exam.result', compact('users', 'questionPackage'));
    }


    public function deleteResult(Result $result)
    {
        // Perform any necessary validation or authorization checks

        $result->delete();

        return redirect()->back()->with('success', 'Result deleted successfully');
    }

    
}

