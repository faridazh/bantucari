<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'pagetitle' => 'Admin Panel',
            'pagedesc' => '',
            'pageid' => 'admin-panel',
        ]);
    }

    public function setting_laporan()
    {
        return view('admin.settings.laporan', [
            'pagetitle' => 'Pengaturan Laporan',
            'pagedesc' => '',
            'pageid' => 'admin-setting-laporan',
        ]);
    }

    public function setting_laporan_post(Request $request)
    {
        $request->validate([
            'laporan_photo_count' => 'required|numeric|min:1|max:10',
            'laporan_photo_size' => 'required|numeric|min:1|max:2048',
            'laporan_photo_width' => 'required|numeric|min:1|max:1000',
            'laporan_photo_height' => 'required|numeric|min:1|max:1000',
        ]);

        DB::transaction(function() use($request) {
            if ($request->laporan_photo_count != config('setting.laporan_photo_count')) {
                Setting::where('name', 'laporan_photo_count')->update([
                    'value' => $request->laporan_photo_count,
                ]);
            }

            if ($request->laporan_photo_size != config('setting.laporan_photo_size')) {
                Setting::where('name', 'laporan_photo_size')->update([
                    'value' => $request->laporan_photo_size,
                ]);
            }

            if ($request->laporan_photo_width != config('setting.laporan_photo_width')) {
                Setting::where('name', 'laporan_photo_width')->update([
                    'value' => $request->laporan_photo_width,
                ]);
            }

            if ($request->laporan_photo_height != config('setting.laporan_photo_height')) {
                Setting::where('name', 'laporan_photo_height')->update([
                    'value' => $request->laporan_photo_height,
                ]);
            }
        });

        Alert::toast('Pengaturan berhasil diperbarui!', 'success');
        return redirect()->route('admin.setting.laporan');
    }

    public function setting_user()
    {
        return view('admin.settings.user', [
            'pagetitle' => 'Pengaturan User',
            'pagedesc' => '',
            'pageid' => 'admin-setting-user',
        ]);
    }

    public function setting_user_post(Request $request)
    {
        $request->validate([
            'user_avatar_size' => 'required|numeric|min:1|max:2048',
            'user_avatar_width' => 'required|numeric|min:1|max:1000',
            'user_avatar_height' => 'required|numeric|min:1|max:1000',
        ]);

        DB::transaction(function() use($request) {
            if ($request->user_avatar_size != config('setting.user_avatar_size')) {
                Setting::where('name', 'user_avatar_size')->update([
                    'value' => $request->user_avatar_size,
                ]);
            }

            if ($request->user_avatar_width != config('setting.user_avatar_width')) {
                Setting::where('name', 'user_avatar_width')->update([
                    'value' => $request->user_avatar_width,
                ]);
            }

            if ($request->user_avatar_height != config('setting.user_avatar_height')) {
                Setting::where('name', 'user_avatar_height')->update([
                    'value' => $request->user_avatar_height,
                ]);
            }
        });

        Alert::toast('Pengaturan berhasil diperbarui!', 'success');
        return redirect()->route('admin.setting.user');
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
        //
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
