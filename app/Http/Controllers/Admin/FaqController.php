<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    /**
     * FAQ LIST (INDEX PAGE)
     */
    public function index(Request $request)
    {
        $faqs = Faq::orderBy('sort_order')->get();

        $pages = Faq::select('page_type')
            ->distinct()
            ->orderBy('page_type')
            ->pluck('page_type');

        return view('admin.faq.index', compact('faqs', 'pages'));
    }

    /**
     * STORE FAQS (MULTIPLE QUESTIONS – CREATE MODE)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_type'   => 'required|string|max:100',
            'page_slug'   => 'nullable|string|max:150',

            'questions'   => 'required|array|min:1',
            'questions.*'=> 'required|string|max:255',

            'answers'     => 'required|array|min:1',
            'answers.*'   => 'required|string',

            'sort_order'  => 'nullable|integer',
            'status'      => 'required|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['questions'] as $index => $question) {
                Faq::create([
                    'page_type'  => $validated['page_type'],
                    'page_slug'  => $validated['page_slug'] ?? null,
                    'question'   => $question,
                    'answer'     => $validated['answers'][$index],
                    'sort_order' => $validated['sort_order'] ?? 0,
                    'status'     => $validated['status'],
                ]);
            }
        });

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQs Added Successfully!');
    }

    /**
     * UPDATE FAQ (SINGLE QUESTION – EDIT MODE, SAME PAGE)
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'page_type'  => 'required|string|max:100',
            'page_slug'  => 'nullable|string|max:150',

            'question'   => 'required|string|max:255',
            'answer'     => 'required|string',

            'sort_order' => 'nullable|integer',
            'status'     => 'required|boolean',
        ]);

        $faq->update([
            'page_type'  => $validated['page_type'],
            'page_slug'  => $validated['page_slug'] ?? null,
            'question'   => $validated['question'],
            'answer'     => $validated['answer'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'status'     => $validated['status'],
        ]);

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ Updated Successfully!');
    }

    /**
     * DELETE FAQ
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faq.index')
            ->with('success', 'FAQ Deleted Successfully!');
    }
}
