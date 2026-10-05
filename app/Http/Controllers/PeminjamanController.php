<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['buku', 'anggota'])->latest()->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $buku = Buku::where('stok', '>', 0)->get();
        $anggota = Anggota::all();

        return view('peminjaman.create', compact('buku', 'anggota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        DB::transaction(function () use ($request) {
            $buku = Buku::lockForUpdate()->findOrFail($request->buku_id);

            if ($buku->stok <= 0) {
                abort(422, 'Stok buku habis, tidak bisa dipinjam.');
            }

            Peminjaman::create([
                'buku_id' => $request->buku_id,
                'anggota_id' => $request->anggota_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok');
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil');
    }

    public function show(Peminjaman $peminjaman)
    {
        return redirect()->route('peminjaman.index');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $peminjaman->load(['buku', 'anggota']);

        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'status' => 'required|in:dipinjam,kembali',
            'tanggal_kembali' => 'nullable|date|after_or_equal:' . $peminjaman->tanggal_pinjam,
        ]);

        DB::transaction(function () use ($request, $peminjaman) {
            $peminjaman->refresh();
            $statusLama = $peminjaman->status;

            $tanggalKembali = $request->tanggal_kembali ?? $peminjaman->tanggal_kembali;
            if ($request->status === 'kembali' && empty($tanggalKembali)) {
                $tanggalKembali = now()->toDateString();
            }

            $peminjaman->update([
                'status' => $request->status,
                'tanggal_kembali' => $tanggalKembali,
            ]);

            if ($statusLama === 'dipinjam' && $request->status === 'kembali') {
                $peminjaman->buku?->increment('stok');
            }

            if ($statusLama === 'kembali' && $request->status === 'dipinjam') {
                $buku = Buku::lockForUpdate()->findOrFail($peminjaman->buku_id);
                if ($buku->stok <= 0) {
                    abort(422, 'Stok habis, tidak bisa diubah kembali ke dipinjam.');
                }
                $buku->decrement('stok');
            }
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'kembali') {
            return redirect()->route('peminjaman.index')
                ->with('success', 'Buku sudah dikembalikan sebelumnya');
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status' => 'kembali',
                'tanggal_kembali' => $peminjaman->tanggal_kembali ?? now()->toDateString(),
            ]);

            $peminjaman->buku?->increment('stok');
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->status === 'dipinjam') {
                $peminjaman->buku?->increment('stok');
            }

            $peminjaman->delete();
        });

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus');
    }
}
