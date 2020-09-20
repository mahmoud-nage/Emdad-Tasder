<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Link::all();
        return view("links.index", compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Link::all()->count() <= 4) {
            return view('links.create');
        } else {
            flash('You can not add more than 5 links')->error();
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'link' => 'required',
        ]);

        $link = new Link;
        $link->name_en = $request->name_en;
        $link->name_ar = $request->name_ar;
        $link->url = $request->link;
        if ($link->save()) {
            flash('Link has been inserted successfully')->success();
            return redirect()->route('links.index');
        }
        flash('Something went wrong')->error();
        return back();
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
        $link = Link::findOrFail(decrypt($id));
        return view('links.edit', compact('link'));
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
            'name_en' => 'required',
            'name_ar' => 'required',
            'link' => 'required',
        ]);

        $link = Link::findOrFail($id);
        $link->name_en = $request->name_en;
        $link->name_ar = $request->name_ar;
        $link->url = $request->link;
        if ($link->save()) {
            flash('Link has been updated successfully')->success();
            return redirect()->route('links.index');
        }
        flash('Something went wrong')->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = Link::findOrFail($id);
        if (Link::destroy($id)) {
            flash('Link has been deleted successfully')->success();
            return redirect()->route('links.index');
        }

        flash('Something went wrong')->error();
        return back();
    }
}
