<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{
    public function index(Request $request)
    {
        $query = Merek::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_merek', 'like', '%' . $request->search . '%');
        }

        $merek = $query->get();

        return view('merek.index', compact('merek'));
    }



    public function tambahMerek(Request $request)
    {
        if (Merek::where('nama_merek', $request->merek)->exists()) {

            return redirect()->route('indexMerek')->with('message', 'Data dengan Merek Tersebut Sudah ada!');
        }

        $request->validate(
            [
                'merek' => 'required'
            ],
            [
                'merek.required' => 'Nama Merek harus diisi'
            ]
        );
        Merek::create([
            'nama_merek' => $request->merek
        ]);
        return redirect()->route('indexMerek')->with('success', 'Data Merek Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $merek = Merek::findOrFail($id);
        $merek->update([
            'nama_merek' => $request->merek
        ]);
        return redirect()->route('indexMerek')->with('success', 'Data Merek Berhasil diUbah');
    }

    public function delete($id)
    {
        $merek = Merek::findOrFail($id);
        $merek->delete();
        return redirect()->route('indexMerek')->with('success', 'Data Merek Berhasil DiHapus');
    }
}
