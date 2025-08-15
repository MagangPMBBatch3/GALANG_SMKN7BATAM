<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas\Aktivitas;
use App\Models\Proyek\Proyek;
use App\Models\Keterangan\Keterangan;
use App\Models\Bagian\Bagians;
use App\Models\UserProfile\UserProfile;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aktivitas = Aktivitas::with(['proyek', 'keterangan', 'bagian', 'userProfile'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('aktivitas.index', compact('aktivitas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyeks = Proyek::all();
        $keterangans = Keterangan::all();
        $bagians = Bagians::all();
        $userProfiles = UserProfile::all();

        return view('aktivitas.create', compact('proyeks', 'keterangans', 'bagians', 'userProfiles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'proyek_id' => 'nullable|exists:proyek,id',
            'keterangan_id' => 'nullable|exists:keterangan,id',
            'bagian_id' => 'nullable|exists:bagian,id',
            'user_profile_id' => 'nullable|exists:user_profile,id',
            'no_wbs' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,completed,cancelled',
            'progress' => 'required|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
        ]);

        Aktivitas::create($request->all());

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aktivitas = Aktivitas::with(['proyek', 'keterangan', 'bagian', 'userProfile'])->findOrFail($id);
        
        return view('aktivitas.show', compact('aktivitas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aktivitas = Aktivitas::findOrFail($id);
        $proyeks = Proyek::all();
        $keterangans = Keterangan::all();
        $bagians = Bagians::all();
        $userProfiles = UserProfile::all();

        return view('aktivitas.edit', compact('aktivitas', 'proyeks', 'keterangans', 'bagians', 'userProfiles'));
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
        $request->validate([
            'nama' => 'required|string|max:255',
            'proyek_id' => 'nullable|exists:proyek,id',
            'keterangan_id' => 'nullable|exists:keterangan,id',
            'bagian_id' => 'nullable|exists:bagian,id',
            'user_profile_id' => 'nullable|exists:user_profile,id',
            'no_wbs' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,completed,cancelled',
            'progress' => 'required|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $aktivitas = Aktivitas::findOrFail($id);
        $aktivitas->update($request->all());

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aktivitas = Aktivitas::findOrFail($id);
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')
            ->with('success', 'Aktivitas berhasil dihapus');
    }

    /**
     * Get aktivitas by user profile
     */
    public function getByUser($userProfileId)
    {
        $aktivitas = Aktivitas::with(['proyek', 'keterangan'])
            ->where('user_profile_id', $userProfileId)
            ->get();

        return response()->json($aktivitas);
    }

    /**
     * Get aktivitas by proyek
     */
    public function getByProyek($proyekId)
    {
        $aktivitas = Aktivitas::with(['keterangan', 'userProfile'])
            ->where('proyek_id', $proyekId)
            ->get();

        return response()->json($aktivitas);
    }

    /**
     * Update progress aktivitas
     */
    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $aktivitas = Aktivitas::findOrFail($id);
        $aktivitas->progress = $request->progress;
        
        if ($request->progress == 100) {
            $aktivitas->status = 'completed';
        } elseif ($request->progress > 0) {
            $aktivitas->status = 'in_progress';
        } else {
            $aktivitas->status = 'todo';
        }
        
        $aktivitas->save();

        return response()->json([
            'success' => true,
            'message' => 'Progress berhasil diperbarui'
        ]);
    }
}
