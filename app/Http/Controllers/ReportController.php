<?php

namespace App\Http\Controllers;

Use App\Models\ReportLaporan;
Use App\Models\ReportMember;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use RealRashid\SweetAlert\Facades\Alert;

class ReportController extends Controller
{
    public function report_laporan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_post' => 'required|exists:posts,id',
            'report_cat' => 'required|exists:report_categories,id',
            'report_detail' => 'nullable|string|max:255',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ReportLaporan::create([
            'post_id' => $request->report_post,
            'cat_id' => $request->report_cat,
            'detail' => $request->report_detail,
        ]);

        Alert::toast('Laporan berhasil dilaporkan!', 'success');
        return redirect()->back();
    }

    public function report_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_user' => 'required|exists:users,id',
            'report_cat' => 'required|exists:report_categories,id',
            'report_detail' => 'nullable|string|max:255',
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ReportMember::create([
            'user_id' => $request->report_user,
            'cat_id' => $request->report_cat,
            'detail' => $request->report_detail,
        ]);

        Alert::toast('Member berhasil dilaporkan!', 'success');
        return redirect()->back();
    }
}
