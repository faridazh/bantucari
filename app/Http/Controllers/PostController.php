<?php

namespace App\Http\Controllers;

use QrCode;

use App\Models\BarangHilang;
use App\Models\KendaraanHilang;
use App\Models\OrangHilang;

use App\Models\Pelapor;
use App\Models\Post;

use App\Models\ReportCategory;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PostController extends Controller
{
    protected function generate_qrcode($case_code, $slug)
    {
        return QrCode::size(150)->generate(route('post.lengkap', [$case_code, $slug]));
    }

    public function index(Request $request)
    {
        $posts = Post::select('id','cat_id','case_code','verify','created_at');

        if ($request->has('cari')) {
            $cari = Str::lower($request->cari);

            $posts = $posts->where('case_code', 'LIKE','%'.$cari.'%')
                            ->orWhere('slug', 'LIKE','%'.$cari.'%');
        }

        if ($request->has('order')) {
            if ($request->order == 'asc') {
                $orderby = 'asc';
            }
            elseif ($request->order == 'desc') {
                $orderby = 'desc';
            }
            else {
                $orderby = 'desc';
            }
        }
        else {
            $orderby = 'desc';
        }

        if ($request->has('sort')) {
            if ($request->sort == 'kasus') {
                $sortby = 'case_code';
            }
            elseif ($request->sort == 'tanggal') {
                $sortby = 'created_at';
            }
            else {
                $sortby = 'created_at';
            }
        }
        else {
            $sortby = 'created_at';
        }

        if ($request->has('tags')) {
            if ($request->tags == 'barang') {
                $posts = $posts->where('cat_id', 1);
            }
            elseif ($request->tags == 'kendaraan') {
                $posts = $posts->where('cat_id', 2);
            }
            elseif ($request->tags == 'orang') {
                $posts = $posts->where('cat_id', 3);
            }
            else {
                $posts = $posts->whereIn('cat_id', [1,2,3]);
            }
        }
        else {
            $posts = $posts->whereIn('cat_id', [1,2,3]);
        }

        if ($request->has('status')) {
            if ($request->status == 'temu') {
                $posts = $posts->where('status', 'Ditemukan');
                $status = 'Ditemukan';
            }
            elseif ($request->status == 'hilang') {
                $posts = $posts->where('status', 'Hilang');
                $status = 'Kehilangan';
            }
            elseif ($request->status == 'semua') {
                $posts = $posts->whereIn('status', ['Ditemukan', 'Hilang']);
                $status = 'Kehilangan & Ditemukan';
            }
            else {
                $posts = $posts->where('status', 'Hilang');
                $status = 'Kehilangan';
            }
        }
        else {
            $posts = $posts->where('status', 'Hilang');
            $status = 'Kehilangan';
        }

        return view('posts.index', [
            'pagetitle' => 'Laporan '.$status,
            'pageid' => 'laporan',
            'posts' => $posts->where('verify', 'Approved')->orderBy($sortby, $orderby)->paginate(16),
        ]);
    }

    public function category()
    {
        return view('posts.category', [
            'pagetitle' => 'Kategori Laporan',
            'pagedesc' => 'Pilih kategori untuk membuat atau melihat laporan',
            'pageid' => 'category-laporan',
        ]);
    }

    public function laporan_slugorcode($slugorcode)
    {
        $post = Post::where('case_code', $slugorcode)->orWhere('slug', $slugorcode);

        if ($post->exists()) {
            $post = $post->first();
            return redirect()->route('post.lengkap', [$post->case_code, $post->slug]);
        }

        return abort('404');
    }

    public function laporan_lengkap($case_code, $slug)
    {
        $post = Post::where('case_code', $case_code)->orWhere('slug', $slug)->first();

        if (empty($post)) {
            return abort(404);
        }

        if ($post->verify == 'Unapproved' && !Auth::check()) {
            Alert::toast('Laporan sedang dalam proses validasi!', 'warning');
            return redirect()->route('post.index');
        }

        // Menentukan Kode Kasus
        $nmrKasus = substr($case_code, 8, -3);

        if ($nmrKasus == 'BH') {
            $legendtitle = 'Data Barang Hilang';
            $data = BarangHilang::join('posts', 'barang_hilangs.case_code', '=', 'posts.case_code')
                                ->join('pelapors', 'pelapors.case_code', '=', 'posts.case_code')
                                ->where('posts.case_code', $case_code);
        }
        elseif ($nmrKasus == 'KH') {
            $legendtitle = 'Data Kendaraan Hilang';
            $data = KendaraanHilang::join('posts', 'kendaraan_hilangs.case_code', '=', 'posts.case_code')
                                ->join('pelapors', 'pelapors.case_code', '=', 'posts.case_code')
                                ->where('posts.case_code', $case_code);
        }
        elseif ($nmrKasus == 'OH') {
            $legendtitle = 'Data Orang Hilang';
            $data = OrangHilang::join('posts', 'orang_hilangs.case_code', '=', 'posts.case_code')
                                ->join('pelapors', 'pelapors.case_code', '=', 'posts.case_code')
                                ->where('posts.case_code', $case_code);
        }

        return view('posts.lengkap', [
            'pagetitle' => 'Laporan Lengkap',
            'pagedesc' => 'No. Kasus: '.$case_code,
            'pageid' => 'laporan-lengkap',
            'legendtitle' => $legendtitle,
            'data' => $data->first(),
            'qrcode' => $this->generate_qrcode($case_code, $slug),
            'report_cats' => ReportCategory::whereIn('cat_for', ['Laporan', 'Both'])->get(),
        ]);
    }

    private function GenCaseCode($data)
    {
        if($data == 'BarangHilang')
        {
            $prefix = date('Ymd').'BH';
        }
        elseif($data == 'KendaraanHilang')
        {
            $prefix = date('Ymd').'KH';
        }
        elseif($data == 'OrangHilang')
        {
            $prefix = date('Ymd').'OH';
        }

        $config = [
            'table' => 'posts',
            'field' => 'case_code',
            'length' => 13,
            'prefix' => $prefix,
            'reset_on_prefix_change' => TRUE,
        ];

        return IdGenerator::generate($config);
    }

    private function createSlug($name)
    {
        $slug = Str::slug($name);

        if (Post::where('slug', $slug)->exists()) {
            $count = Post::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $slug = $slug.'-'.$count;
        }

        return $slug;
    }

    public function create_barang()
    {
        return view('posts.create.barang', [
            'pagetitle' => 'Buat Laporan',
            'pagedesc' => 'Membuat laporan kehilangan barang',
            'pageid' => 'add-barang-hilang',
            'max_size' => 'Maksimal: 1024 KB',
        ]);
    }

    public function store_barang(Request $request)
    {
        $photo_maxSize = 1024;

        $request->validate([
            'category' => 'required|in:BarangHilang',

            'photo' => 'required',
            'photo.*' => 'image|mimes:jpg,jpeg,png,bmp,gif,webp|max:' . $photo_maxSize,
            'fullname' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'jenis' => 'required|in:Barang Pribadi,Dokumen,Smartphone,Lainnya',
            'tempatakhir' => 'nullable|string|max:500',
            'ciri' => 'nullable|string|max:500',
            'kronologi' => 'nullable|string|max:500',
        ]);

        if ($request->isiAddress == 'on') {
            $request->validate([
                'nama_pelapor' => 'required|string|max:255',
                'hubungi_pelapor' => 'required|numeric|digits_between:8,15',
                'email_pelapor' => 'nullable|email|max:255',
                'alamat_pelapor' => 'nullable|string|max:500',
            ]);
        }

        $case_code = $this->GenCaseCode($request->category);

        DB::transaction(function() use($request, $case_code) {
            if ($request->hasfile('photo')) {
                $i = 0;
                $data = [];
                foreach ($request->file('photo') as $image) {
                    $name = 'photo_' . $i . '.' . $image->extension();
                    $image->move(storage_path('app/public/uploads/posts/').$case_code, $name);
                    $data[] = $name;
                    $i++;
                }
            }
            else {
                $data[] = null;
            }

            Post::create([
                'user_id' => Auth::user()->id,
                'cat_id' => 1,
                'case_code' => $case_code,
                'slug' => $this->createSlug($request->fullname),
            ]);

            if ($request->isiAddress == 'on') {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => $request->nama_pelapor,
                    'hubungi_pelapor' => $request->hubungi_pelapor * 1,
                    'email_pelapor' => $request->email_pelapor,
                    'alamat_pelapor' => Crypt::encryptString($request->alamat_pelapor),
                ]);
            }
            else {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => Auth::user()->name,
                    'hubungi_pelapor' => Auth::user()->phone,
                    'email_pelapor' => Auth::user()->email,
                    'alamat_pelapor' => Crypt::encryptString(Crypt::decryptString(Auth::user()->address).', '.Auth::user()->states.', '.Auth::user()->zipcode),
                ]);
            }

            BarangHilang::create([
                'case_code' => $case_code,
                'photo' => $data,
                'fullname' => $request->fullname,
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'tempatakhir' => $request->tempatakhir,
                'ciri' => $request->ciri,
                'kronologi' => $request->kronologi,
            ]);
        });

        DB::transaction(function() use($case_code) {
            $postID = Post::select('id')->where('case_code', $case_code)->first();

            Pelapor::where('case_code', $case_code)->update(['post_id' => $postID->id]);
            BarangHilang::where('case_code', $case_code)->update(['post_id' => $postID->id]);
        });

        Alert::toast('Laporan berhasil dibuat, laporan sedang divalidasi oleh staff', 'success');
        return redirect()->route('post.index.barang');
    }

    public function create_kendaraan()
    {
        return view('posts.create.kendaraan', [
            'pagetitle' => 'Buat Laporan',
            'pagedesc' => 'Membuat laporan kehilangan kendaraan',
            'pageid' => 'add-kendaraan-hilang',
            'max_size' => 'Maksimal: 1024 KB',
        ]);
    }

    public function store_kendaraan(Request $request)
    {
        $photo_maxSize = 1024;

        $request->validate([
            'category' => 'required|in:KendaraanHilang',

            'photo' => 'required',
            'photo.*' => 'image|mimes:jpg,jpeg,png,bmp,gif,webp|max:' . $photo_maxSize,
            'fullname' => 'required|string|max:255',
            'platnomor' => 'nullable|string|max:11',
            'tanggal' => 'nullable|date',
            'jenis' => 'required|in:Mobil,Motor,Sepeda,Lainnya',
            'tempatakhir' => 'nullable|string|max:500',
            'ciri' => 'nullable|string|max:500',
            'kronologi' => 'nullable|string|max:500',
        ]);

        if ($request->isiAddress == 'on') {
            $request->validate([
                'nama_pelapor' => 'required|string|max:255',
                'hubungi_pelapor' => 'required|numeric|digits_between:8,15',
                'email_pelapor' => 'nullable|email|max:255',
                'alamat_pelapor' => 'nullable|string|max:500',
            ]);
        }

        $case_code = $this->GenCaseCode($request->category);

        DB::transaction(function() use($request, $case_code) {
            if ($request->hasfile('photo')) {
                $i = 0;
                $data = [];
                foreach ($request->file('photo') as $image) {
                    $name = 'photo_' . $i . '.' . $image->extension();
                    $image->move(storage_path('app/public/uploads/posts/').$case_code, $name);
                    $data[] = $name;
                    $i++;
                }
            }
            else {
                $data[] = null;
            }

            Post::create([
                'user_id' => Auth::user()->id,
                'cat_id' => 2,
                'case_code' => $case_code,
                'slug' => $this->createSlug($request->fullname),
            ]);

            if ($request->isiAddress == 'on') {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => $request->nama_pelapor,
                    'hubungi_pelapor' => $request->hubungi_pelapor * 1,
                    'email_pelapor' => $request->email_pelapor,
                    'alamat_pelapor' => Crypt::encryptString($request->alamat_pelapor),
                ]);
            }
            else {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => Auth::user()->name,
                    'hubungi_pelapor' => Auth::user()->phone,
                    'email_pelapor' => Auth::user()->email,
                    'alamat_pelapor' => Crypt::encryptString(Crypt::decryptString(Auth::user()->address).', '.Auth::user()->states.', '.Auth::user()->zipcode),
                ]);
            }

            KendaraanHilang::create([
                'case_code' => $case_code,
                'photo' => $data,
                'fullname' => $request->fullname,
                'platnomor' => $request->platnomor,
                'tanggal' => $request->tanggal,
                'jenis' => $request->jenis,
                'tempatakhir' => $request->tempatakhir,
                'ciri' => $request->ciri,
                'kronologi' => $request->kronologi,
            ]);
        });

        DB::transaction(function() use($case_code) {
            $postID = Post::select('id')->where('case_code', $case_code)->first();

            Pelapor::where('case_code', $case_code)->update(['post_id' => $postID->id]);
            KendaraanHilang::where('case_code', $case_code)->update(['post_id' => $postID->id]);
        });

        Alert::toast('Laporan berhasil dibuat, laporan sedang divalidasi oleh staff', 'success');
        return redirect()->route('post.index.kendaraan');
    }

    public function create_orang()
    {
        return view('posts.create.orang', [
            'pagetitle' => 'Buat Laporan',
            'pagedesc' => 'Membuat laporan orang hilang',
            'pageid' => 'add-orang-hilang',
            'max_size' => 'Maksimal: 1024 KB',
        ]);
    }

    public function store_orang(Request $request)
    {
        $photo_maxSize = 1024;

        $request->validate([
            'category' => 'required|in:OrangHilang',

            'photo' => 'required',
            'photo.*' => 'image|mimes:jpg,jpeg,png,bmp,gif,webp|max:' . $photo_maxSize,
            'fullname' => 'required|string|max:255',
            'umur' => 'nullable|numeric|digits_between:1,3',
            'tanggal' => 'nullable|date',
            'hubungan' => 'required|in:Anak,Ayah,Cucu,Ibu,Istri,Kakek,Nenek,Saudara,Suami,Teman,Lainnya',
            'tempatakhir' => 'nullable|string|max:500',
            'ciri' => 'nullable|string|max:500',
            'kronologi' => 'nullable|string|max:500',
        ]);

        if ($request->isiAddress == 'on') {
            $request->validate([
                'nama_pelapor' => 'required|string|max:255',
                'hubungi_pelapor' => 'required|numeric|digits_between:8,15',
                'email_pelapor' => 'nullable|email|max:255',
                'alamat_pelapor' => 'nullable|string|max:500',
            ]);
        }

        $case_code = $this->GenCaseCode($request->category);

        DB::transaction(function() use($request, $case_code) {
            if ($request->hasfile('photo')) {
                $i = 0;
                $data = [];
                foreach ($request->file('photo') as $image) {
                    $name = 'photo_' . $i . '.' . $image->extension();
                    $image->move(storage_path('app/public/uploads/posts/').$case_code, $name);
                    $data[] = $name;
                    $i++;
                }
            }
            else {
                $data[] = null;
            }

            Post::create([
                'user_id' => Auth::user()->id,
                'cat_id' => 3,
                'case_code' => $case_code,
                'slug' => $this->createSlug($request->fullname),
            ]);

            if ($request->isiAddress == 'on') {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => $request->nama_pelapor,
                    'hubungi_pelapor' => $request->hubungi_pelapor * 1,
                    'email_pelapor' => $request->email_pelapor,
                    'alamat_pelapor' => Crypt::encryptString($request->alamat_pelapor),
                ]);
            }
            else {
                Pelapor::create([
                    'case_code' => $case_code,
                    'nama_pelapor' => Auth::user()->name,
                    'hubungi_pelapor' => Auth::user()->phone,
                    'email_pelapor' => Auth::user()->email,
                    'alamat_pelapor' => Crypt::encryptString(Crypt::decryptString(Auth::user()->address).', '.Auth::user()->states.', '.Auth::user()->zipcode),
                ]);
            }

            OrangHilang::create([
                'case_code' => $case_code,
                'photo' => $data,
                'fullname' => $request->fullname,
                'umur' => $request->umur,
                'tanggal' => $request->tanggal,
                'hubungan' => $request->hubungan,
                'tempatakhir' => $request->tempatakhir,
                'ciri' => $request->ciri,
                'kronologi' => $request->kronologi,
            ]);
        });

        DB::transaction(function() use($case_code) {
            $postID = Post::select('id')->where('case_code', $case_code)->first();

            Pelapor::where('case_code', $case_code)->update(['post_id' => $postID->id]);
            OrangHilang::where('case_code', $case_code)->update(['post_id' => $postID->id]);
        });

        Alert::toast('Laporan berhasil dibuat, laporan sedang divalidasi oleh staff', 'success');
        return redirect()->route('post.index.orang');
    }

    public function laporan_ditemukan(Request $request, $case_code)
    {
        if ($request->idSaya != Auth::user()->id || $request->kasus != $case_code) {
            Alert::toast('Error, silakan cek kembali!', 'error');
            return redirect()->back();
        }

        $request->validate([
            'idSaya' => 'required|exists:users,id',
            'kasus' => 'required|exists:posts,case_code'
        ]);

        Post::where('case_code', $request->kasus)
                ->update([
                    'status' => 'Ditemukan',
                ]);

        Alert::toast('Status laporan sudah diperbarui!', 'success');
        return redirect()->back();
    }
}
