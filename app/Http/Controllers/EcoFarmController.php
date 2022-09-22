<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EcoFarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trees = Tree::all();

        return view('tree')->with([
            "trees" => $trees
        ]);
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
        Tree::create(["name" => $request->name, "description" => $request->description, "date" => $request->date]);
    }

    public function generate($id)
    {
        $tree = Tree::findOrFail($id);
        $qrcode = QrCode::size(400)->generate($tree->name . $tree->id);
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<img src="' . $qrcode . '" alt="qrcode">');
        return $pdf->stream();
        // return view('qrcode', compact('qrcode'));
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
        $tree = Tree::findOrFail($id);
        $tree->update(
            ["name" => $request->name, "description" => $request->description, "date" => $request->date],
        );

        return redirect()->route("tree.index");
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
