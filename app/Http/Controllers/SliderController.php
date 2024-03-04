<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'desc')
        ->with([
            'user'
        ])
        ->where([
            'type' => request('type')
        ])
        ->get();

        $trashed = Slider::onlyTrashed()
        ->get();
        //dd($categories->toArray());

        return view('slider.index')->with([
            'trashed' => $trashed,
            'valeurs' => $sliders,
            'infosPage' => array(
                'title' => 'Slider : '.request('type'),
                'icon' => 'icofont-picture',
                'add' => 1,
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.create')->with([
            'infosPage' => array(
                'title' => 'Ajout de Slider',
                'icon' => 'icofont-picture',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'titre' => 'required|max:255',
            'image' => 'required',
        ]);

        $slider = Slider::create([
            'titre' => request('titre'),
            'sous_titre' => request('sous_titre'),
            'description' => request('description'),
            'type' => request('type'),
            'user_id' => auth()->user()->id,
        ]);

        if($request->hasFile('image'))
        {
            $slider->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }
        flash()->overlay('Ajout effectué avec succès', 'Message')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $slider = Slider::findOrFail($slider->id);
        //dd($categories->toArray());
        return view('slider.create')->with([
            'valeur' => $slider,
            'infosPage' => array(
                'title' => 'Modifier slider : '.$slider->titre,
                'icon' => 'icofont-picture',
                'add' => 0,
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request,[
            'titre' => 'required|max:255',
            'image' => 'required',
        ]);
        $slider = Slider::findOrFail($slider->id);
        //dd($categorie->toArray());
        $slider->titre = request('titre');
        $slider->sous_titre = request('sous_titre');
        $slider->description = request('description');
        $slider->type = request('type');
        $slider->save();

        if($request->hasFile('image'))
        {
            $media = $slider->getMedia('image');
            //dd($media->toArray());
            if (count($media)) {
                $media[0]->delete();
            }
            $slider->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }
        flash()->overlay('Modification effectuée avec succès', 'Message')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
