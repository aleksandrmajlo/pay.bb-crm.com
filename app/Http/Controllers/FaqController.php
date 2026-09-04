<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Lang;
use App\Models\Tag;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fags = Faq::orderBy('sort', 'desc')->get();
        $langs = Lang::all();


        return view('faqs.index', compact('fags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $langs = Lang::all();
        $lang_tags = [];
        foreach ($langs as $lang) {
            $tags = Tag::where('lang_id', $lang->id)->pluck('name')->toArray();
            $lang_tags[$lang->slug] = $tags;
        }
        return view('faqs.create', compact('langs', 'lang_tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $langs = Lang::all();
        $maxValue = Faq::max('sort');
        if ($maxValue) {
            $maxValue++;
        } else {
            $maxValue = 1;
        }
        $faq = new Faq();
        if (filled($request->sort)) {
            $faq->sort = $request->sort;
        } else {
            $faq->sort = $maxValue;
        }

        $faq->search = $request->search;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        foreach ($langs as $lang) {
            if ($lang->slug == 'en') continue;
            $question = 'question_' . $lang->slug;
            $answer = 'answer_' . $lang->slug;
            $faq->{$question} = $request->{$question};
            $faq->{$answer} = $request->{$answer};
        }
        $faq->save();

        // tags start
        $arrs = [];
        foreach ($langs as $lang) {
            $tag_req = 'tagify_' . $lang->slug;
            if ($request->has($tag_req)) {
                $tagifyJson = $request->input($tag_req);
                $tagifyArray = json_decode($tagifyJson, true);
                if (filled($tagifyArray)) {
                    foreach ($tagifyArray as $item) {
                        $tag_value = $item['value'];
                        $tag = Tag::where('name', $tag_value)->where('lang_id', $lang->id)->first();
                        if ($tag) {

                        } else {
                            $tag = new Tag();
                            $tag->name = $tag_value;
                            $tag->lang_id = $lang->id;
                            $tag->save();
                        }
                        $arrs[$tag->id] = ['lang_id' => $lang->id];
                    }
                }
            }

        }
        if (filled($arrs)) {
            $faq->tags()->sync($arrs);
        }
        // tags end
        return redirect()->route('faqs.index')->with('success', 'Faq Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $langs = Lang::all();
        $faq = Faq::findOrFail($id);
        $lang_tags = [];
        foreach ($langs as $lang) {
            $tags = Tag::where('lang_id', $lang->id)->pluck('name')->toArray();
            $lang_tags[$lang->slug] = $tags;
        }
        return view('faqs.show', compact('faq', 'langs', 'lang_tags'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $langs = Lang::all();
        $faq = Faq::findOrFail($id);
        $lang_tags = [];
        foreach ($langs as $lang) {
            $tags = Tag::where('lang_id', $lang->id)->pluck('name')->toArray();
            $lang_tags[$lang->slug] = $tags;
        }
        return view('faqs.edit', compact('faq', 'langs', 'lang_tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $maxValue = Faq::max('sort');
        if ($maxValue) {
            $maxValue++;
        } else {
            $maxValue = 1;
        }
        $langs = Lang::all();
        $faq = Faq::findOrFail($id);
        if (filled($request->sort)) {
            $faq->sort = $request->sort;
        } else {
            $faq->sort = $maxValue;
        }

        $faq->search = $request->search;

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        foreach ($langs as $lang) {
            if ($lang->slug == 'en') continue;
            $question = 'question_' . $lang->slug;
            $answer = 'answer_' . $lang->slug;
            $faq->{$question} = $request->{$question};
            $faq->{$answer} = $request->{$answer};
        }
        $faq->save();

        // tags start
        $arrs = [];
        foreach ($langs as $lang) {
            $tag_req = 'tagify_' . $lang->slug;
            if ($request->has($tag_req)) {
                $tagifyJson = $request->input($tag_req);
                $tagifyArray = json_decode($tagifyJson, true);
                if (filled($tagifyArray)) {
                    foreach ($tagifyArray as $item) {
                        $tag_value = $item['value'];
                        $tag = Tag::where('name', $tag_value)->where('lang_id', $lang->id)->first();
                        if ($tag) {

                        } else {
                            $tag = new Tag();
                            $tag->name = $tag_value;
                            $tag->lang_id = $lang->id;
                            $tag->save();
                        }
                        $arrs[$tag->id] = ['lang_id' => $lang->id];
                    }
                }
            }

        }
        $faq->tags()->sync($arrs);
        // tags end
        return back()->with('success', 'Faq Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('faqs.index')->with('success', 'Faq Deleted Successfully');
    }
}
