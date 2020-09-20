<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SeoSetting;
use Illuminate\Http\Request;

class SEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seosetting = SeoSetting::first();
        return view('seo_settings.index', compact("seosetting"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'keyword' => 'required',
            'author' => 'required',
            'revisit' => 'required',
            'sitemap_link' => 'required',
            'description' => 'required',
        ]);

        $seosetting = SeoSetting::first();
        $seosetting->keyword = implode('|', $request->tags);
        $seosetting->author = $request->author;
        $seosetting->revisit = $request->revisit;
        $seosetting->sitemap_link = $request->sitemap;
        $seosetting->description = $request->description;
        if ($seosetting->save()) {
            flash(__('SEO Setting has been updated successfully'))->success();
            return redirect()->route('seosetting.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
