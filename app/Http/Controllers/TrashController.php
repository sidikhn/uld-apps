<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AsesmenUjian;
use App\Models\Mahasiswa;
use App\Models\Tendik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class TrashController extends Controller
{
    private const MODELS = [
        'mahasiswa' => Mahasiswa::class,
        'alumni' => Alumni::class,
        'ujian' => AsesmenUjian::class,
        'tendik' => Tendik::class,
    ];

    public function index(): View
    {
        $this->deleteExpired();
        $items = collect();

        foreach (self::MODELS as $type => $model) {
            $items = $items->merge(
                $model::onlyTrashed()->latest('deleted_at')->get()->map(function ($item) use ($type) {
                    $item->trash_type = $type;
                    return $item;
                })
            );
        }

        return view('trash.index', ['items' => $items->sortByDesc('deleted_at')]);
    }

    public function restore(string $type, int $id): RedirectResponse
    {
        abort_unless(isset(self::MODELS[$type]), 404);

        self::MODELS[$type]::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('trash.index')->with('success', 'Data berhasil dipulihkan.');
    }

    public function deleteExpired(): void
    {
        $expiredAt = Carbon::now()->subDays(30);

        foreach (self::MODELS as $model) {
            $model::onlyTrashed()->where('deleted_at', '<=', $expiredAt)->forceDelete();
        }
    }
}