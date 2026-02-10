<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\QuestionBank;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionBankController extends Controller
{
    /**
     * قائمة بنوك أسئلة المدرب
     */
    public function index()
    {
        $instructor = Auth::user();
        $banks = QuestionBank::where('created_by', $instructor->id)
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('instructor.question-banks.index', compact('banks'));
    }

    /**
     * نموذج إنشاء بنك أسئلة
     */
    public function create()
    {
        return view('instructor.question-banks.create');
    }

    /**
     * حفظ بنك أسئلة جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'اسم البنك مطلوب',
        ]);

        QuestionBank::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('instructor.question-banks.index')
            ->with('success', 'تم إنشاء بنك الأسئلة بنجاح');
    }

    /**
     * عرض بنك أسئلة مع قائمة الأسئلة
     */
    public function show(QuestionBank $questionBank)
    {
        if ($questionBank->created_by !== Auth::id()) {
            abort(403, 'غير مسموح لك بالوصول لهذا البنك');
        }

        $questionBank->load('questions');
        return view('instructor.question-banks.show', compact('questionBank'));
    }

    /**
     * نموذج إضافة سؤال للبنك
     */
    public function createQuestion(QuestionBank $questionBank)
    {
        if ($questionBank->created_by !== Auth::id()) {
            abort(403, 'غير مسموح لك بالوصول لهذا البنك');
        }

        $questionTypes = Question::getQuestionTypes();
        $difficultyLevels = Question::getDifficultyLevels();
        $categories = QuestionCategory::active()->orderBy('name')->get();

        return view('instructor.question-banks.create-question', compact('questionBank', 'questionTypes', 'difficultyLevels', 'categories'));
    }

    /**
     * حفظ سؤال جديد في البنك
     */
    public function storeQuestion(Request $request, QuestionBank $questionBank)
    {
        if ($questionBank->created_by !== Auth::id()) {
            abort(403, 'غير مسموح لك بالوصول لهذا البنك');
        }

        $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:multiple_choice,true_false,fill_blank,short_answer,essay',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'points' => 'required|numeric|min:0.5|max:100',
            'category_id' => 'nullable|exists:question_categories,id',
            'explanation' => 'nullable|string',
            'option_1' => 'required_if:type,multiple_choice|nullable|string',
            'option_2' => 'required_if:type,multiple_choice|nullable|string',
            'correct_option' => 'required_if:type,multiple_choice|nullable|string',
            'true_false_answer' => 'required_if:type,true_false|nullable|in:صح,خطأ',
        ], [
            'question.required' => 'نص السؤال مطلوب',
            'type.required' => 'نوع السؤال مطلوب',
        ]);

        $data = [
            'question_bank_id' => $questionBank->id,
            'category_id' => $request->category_id,
            'question' => $request->question,
            'type' => $request->type,
            'difficulty_level' => $request->difficulty_level,
            'points' => $request->points,
            'explanation' => $request->explanation,
            'is_active' => true,
        ];

        if ($request->type === 'multiple_choice') {
            $data['options'] = array_filter([
                $request->option_1,
                $request->option_2,
                $request->option_3,
                $request->option_4,
            ]);
            $data['correct_answer'] = [$request->correct_option];
        } elseif ($request->type === 'true_false') {
            $data['options'] = ['صح', 'خطأ'];
            $data['correct_answer'] = [$request->true_false_answer];
        } else {
            $data['options'] = null;
            // لا نترك correct_answer أبداً null — استخدم مصفوفة بإجابة واحدة أو مصفوفة فارغة
            $data['correct_answer'] = $request->filled('model_answer')
                ? [trim($request->model_answer)]
                : [];
        }

        Question::create($data);

        return redirect()->route('instructor.question-banks.show', $questionBank)
            ->with('success', 'تم إضافة السؤال بنجاح');
    }
}
