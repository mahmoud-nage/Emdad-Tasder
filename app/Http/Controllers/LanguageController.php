<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $this->validate(request(), [
            'locale' => 'required',
        ]);

        $request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
        flash(__('messages.change_lang') . $language->name)->success();
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $languages = Language::all();
        return view('business_settings.languages.index', compact('languages'));
    }

    public function create(Request $request)
    {
        return view('business_settings.languages.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required|exists:languages',
            'code' => 'required',
        ]);

        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        if ($language->save()) {
            saveJSONFile($language->code, openJSONFile('en'));
            flash(__('Language has been inserted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function show($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('business_settings.languages.language_view', compact('language'));
    }

    public function edit($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('business_settings.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'id' => 'required|exists:languages',
            'code' => 'required',
        ]);

        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->code = $request->code;
        if ($language->save()) {
            flash(__('Language has been updated successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required|exists:languages',
            'code' => 'required',
        ]);

        $language = Language::findOrFail($request->id);
        $data = openJSONFile($language->code);
        foreach ($request->key as $key => $key) {
            $data[$key] = $request->key[$key];
        }
        saveJSONFile($language->code, $data);
        flash(__('Key-Value updated  for ') . $language->name)->success();
        return back();
    }

    public function update_rtl_status(Request $request)
    {
        $this->validate(request(), [
            'id' => 'required|exists:languages',
            'status' => 'required',
        ]);
        $language = Language::findOrFail($request->id);
        $language->rtl = $request->status;
        if ($language->save()) {
            flash(__('RTL status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function destroy($id)
    {
        if (Language::destroy($id)) {
            flash(__('Language has been deleted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
