<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

Use App\Models\ReportLaporan;
Use App\Models\ReportMember;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use RealRashid\SweetAlert\Facades\Alert;

class StaffController extends Controller
{
    public function index()
    {
        return view('staff.index', [
            'pagetitle' => 'Staff Panel',
            'pagedesc' => '',
            'pageid' => 'staff-panel',
            'posts' => Post::select('id','cat_id','case_code','verify')->orderBy('created_at', 'desc')->limit(5)->get(),
            'users' => User::select('id','username','name','email','email_verified_at')->orderBy('created_at', 'desc')->limit(5)->get(),
            'reports_laporan' =>  ReportLaporan::select('cat_id','post_id','detail')->orderBy('created_at', 'desc')->limit(5)->get(),
            'reports_member' => ReportMember::select('cat_id','user_id','detail')->orderBy('created_at', 'desc')->limit(5)->get(),
            'post_count' => Post::count(),
            'user_count' => User::count(),
            'report_count' => ReportLaporan::count() + ReportMember::count(),
        ]);
    }

    public function laporan_validasi_page()
    {
        return view('staff.validation.laporan', [
            'pagetitle' => 'Validasi Laporan',
            'pagedesc' => '',
            'pageid' => 'staff-validasi-laporan',
            'posts' => Post::select('id', 'cat_id', 'case_code', 'created_at')
                                    ->where('verify', 'Unapproved')
                                    ->whereIn('status', ['Hilang', 'Tidak Diketahui'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15),
        ]);
    }

    public function laporan_validasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'case_code' => 'required|exists:posts,case_code',
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Post::where('id', $request->post_id)
                ->where('case_code', $request->case_code)
                ->where('verify', 'Unapproved')
                ->whereIn('status', ['Hilang', 'Tidak Diketahui'])
                ->update([
                    'verify' => 'Approved',
                ]);

        Alert::toast('Laporan berhasil divalidasi!', 'success');
        return redirect()->route('staff.laporan.validasi.page');
    }

    public function laporan_hapus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'case_code' => 'required|exists:posts,case_code',
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Post::where('id', $request->post_id)
                ->where('case_code', $request->case_code)
                ->where('verify', 'Unapproved')
                ->whereIn('status', ['Hilang', 'Tidak Diketahui'])
                ->delete();

        Alert::toast('Laporan berhasil dihapus!', 'success');
        return redirect()->route('staff.laporan.validasi.page');
    }

    public function member_validasi_page()
    {
        return view('staff.validation.member', [
            'pagetitle' => 'Aktivasi Member',
            'pagedesc' => '',
            'pageid' => 'staff-aktivasi-member',
            'users' => User::select('id','username','name','email')
                            ->where('email_verified_at', null)
                            ->orderBy('created_at', 'desc')
                            ->paginate(15),
        ]);
    }

    public function member_validasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'username' => 'required|exists:users,username',
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::where('username', $request->user_id)
                ->where('username', $request->username)
                ->where('email_verified_at', null)
                ->update([
                    'email_verified_at' => date('Y-m-d h:i:s', time()),
                ]);

        Alert::toast('Member berhasil diaktivasi!', 'success');
        return redirect()->route('staff.member.validasi.page');
    }

    public function member_hapus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'username' => 'required|exist:users,username',
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::where('username', $request->user_id)
                ->where('username', $request->username)
                ->where('email_verified_at', null)
                ->delete();

        Alert::toast('Member berhasil dihapus!', 'success');
        return redirect()->route('staff.member.validasi.page');
    }

    public function report_laporan()
    {
        // $posts = ReportLaporan::all();
        //
        // foreach ($posts as $post) {
        //     $data[] = [
        //         'post_id' => $post->post_id,
        //         'case_code' => $post->laporan->case_code,
        //         'cat_id' => $post->cat_id,
        //         'cat_name' => $post->report_cat->cat_name,
        //         'detail' => $post->detail,
        //     ];
        // }
        //
        // dd($data);

        return view('staff.reports.laporan', [
            'pagetitle' => 'Report Laporan',
            'pagedesc' => '',
            'pageid' => 'staff-reports-laporan',
            'reports' => ReportLaporan::paginate(15),
        ]);
    }

    public function report_laporan_approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'case_code' => 'required|exists:posts,case_code'
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Post::where('case_code', $request->case_code)
                ->where('verify', 'Approved')
                ->delete();

        Alert::toast('Report disetejui, laporan berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function report_laporan_decline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:report_laporans,id'
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ReportLaporan::find($request->id)->delete();

        Alert::toast('Report ditolak, report berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function report_member()
    {
        return view('staff.reports.member', [
            'pagetitle' => 'Report Member',
            'pagedesc' => '',
            'pageid' => 'staff-reports-member',
            'reports' => ReportMember::paginate(15),
        ]);
    }

    public function report_member_approve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'username' => 'required|exists:users,username',
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::where('id', $request->user_id)->where('username', $request->username)->delete();

        Alert::toast('Report disetejui, laporan berhasil dihapus!', 'success');
        return redirect()->back();
    }

    public function report_member_decline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:report_members,id'
        ]);

        if ($validator->fails()) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ReportMember::find($request->id)->delete();

        Alert::toast('Report ditolak, report berhasil dihapus!', 'success');
        return redirect()->back();
    }
}
