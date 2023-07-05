<?php

namespace App\Http\Controllers;

use App\Exports\TreesExport;
use App\Imports\TreesImport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Tree;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EcoFarmController extends Controller
{
    public function welcome(){
        return redirect()->route('tree.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trees = Tree::paginate(10);

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
        Tree::create($request->all());
        return redirect()->route('tree.index');
    }

    public function generate($id)
    {
        $pdf = Pdf::loadView('qrcode', ["id" => $id])->setOption(['defaultFont' => 'sans-serif']);
        return $pdf->download('qrcode.pdf');
    }

    public function generateAll(Request $request)
    {
        $trees = Tree::all();
        $pdf = Pdf::loadView('allqrcode', ["trees" => $trees])->setOption(['defaultFont' => 'sans-serif']);
        return $pdf->download('qrcode.pdf');
    }

    public function export()
    {
        return Excel::download(new TreesExport, 'trees.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new TreesImport, $request->file);
        return redirect()->route('tree.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Tree $tree
     * @return \Illuminate\Http\Response
     */
    public function show(Tree $tree)
    {
        // $tree = Tree::findOrFail($id);
        return view('detail', compact('tree'));
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
     * @param  Tree $tree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tree $tree)
    {
        $tree->update(
            [
                "name" => $request->name,
                "description" => $request->description,
                "date" => $request->date
            ],
        );

        return redirect()->route("tree.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tree $tree
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tree $tree)
    {
        $tree->delete();
        return redirect()->route("tree.index");
    }
}
