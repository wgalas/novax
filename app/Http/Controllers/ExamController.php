<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getExams()
    {
        if (auth()->user()->type === User::TYPE_STUDENT) {
            return Exam::where([
                'strand' => auth()->user()->strand,
                'level' => auth()->user()->level,
            ])->latest()->get();
        }

        return Exam::whereTeacherId(auth()->id())->latest()->get();
    }
    public function index()
    {
        $exams = $this->getExams();
        return view('exam.index', compact('exams'));
    }

    public function destroy(Request $request, Exam $exam)
    {
        if ($exam->name !== $request->get('key')) {
            return back()->withAlert('Wrong Input!');
        }

        $exam->delete();
        return back()->withSuccess('Success!');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:exams,name',
            'code' => '',
            'time_limit' => 'required',
            'opened_at' => 'required',
            'closed_at' => 'required|after:opened_at',
            'is_manual_checking' => 'required',
            'level' => 'required',
            'strand' => 'required',
        ]);
        $data['teacher_id'] = auth()->id();
        Exam::create($data);
        return back()->withSuccess('Success!');
    }

    public function show(Exam $exam)
    {
        return view('exam.show', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            'name' => 'required',
            'code' => '',
            'time_limit' => 'required',
            'opened_at' => 'required|after:yesterday',
            'closed_at' => 'required|after:opened_at',
            'level' => 'required',
            'strand' => 'required',
        ]);
        $exam->update($data);
        return back()->withSuccess('Success');
    }
}
