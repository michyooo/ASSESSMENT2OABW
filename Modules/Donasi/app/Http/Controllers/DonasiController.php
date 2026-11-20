<?php
 
namespace Modules\Donasi\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Donasi\Models\Donasi;
 use Modules\Donasi\Http\Requests\StoreDonasiRequest;
use Modules\Donasi\Http\Requests\UpdateDonasiRequest;
class DonasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
 
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
 
        $lokasi = trim((string) $request->query('lokasi', ''));
 
 
        $query = Donasi::query();
 
 
        if ($search !== '') {
 
            $query->where(function ($q) use ($search) {
 
                $q->where(
                    'kode',
                    'like',
                    '%' . $search . '%'
                )
 
                ->orWhere(
                    'nama',
                    'like',
                    '%' . $search . '%'
                );
 
            });
        }
 
 
        if ($lokasi !== '') {
 
            $query->where(
                'lokasi_pengambilan',
                $lokasi
            );
        }
 
 
 
        $donasis = $query
            ->latest()
            ->get();
 
 
 
        $daftarLokasi = Donasi::query()
            ->select('lokasi_pengambilan')
            ->distinct()
            ->orderBy('lokasi_pengambilan')
            ->pluck('lokasi_pengambilan');
 
 
        return view(
            'donasi::index',
            compact(
                'donasis',
                'daftarLokasi',
                'search',
                'lokasi'
            )
        );
    }
 
 
    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
 
    public function create()
    {
        return view('donasi::create');
    }
 
   public function store(StoreDonasiRequest $request)
{
    $validated = $request->validated();


    Donasi::create($validated);


    return redirect()
        ->route('donasi.index')
        ->with(
            'success',
            'Katalog berhasil disimpan.'
        );
}
 
 
    public function edit($id)
    {
        $donasi = Donasi::findOrFail($id);
 
        return view(
            'donasi::edit',
            compact('donasi')
        );
    }
 
 
    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
 
    public function update(
    UpdateDonasiRequest $request,
    $id
) {
    $donasi = Donasi::findOrFail($id);


    $donasi->update(
        $request->validated()
    );


    return redirect()
        ->route('donasi.index')
        ->with(
            'success',
            'Katalog berhasil diperbarui.'
        );
}

 
 
    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
 
    public function destroy($id)
    {
        $donasi = Donasi::findOrFail($id);
 
        if ($donasi->pengajuans()->exists()) {
 
            return redirect()
                ->route('donasi.index')
                ->with(
                    'error',
                  'Katalog tidak *apat dihapus karena sudah dirujuk *ransaksi.'
                );
       }
 
 
        $donasi->delete();

        return redirect()
          ->route('donasi.index')
           ->with(
                'success',
                'Katalog berh*sil dihapus.'
            );
    }
    }