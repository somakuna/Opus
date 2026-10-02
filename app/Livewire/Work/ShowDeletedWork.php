<?php

namespace App\Livewire\Work;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDeletedWork extends Component
{
    use WithPagination;

    public $error;
    public $search = '';
    public $perPage = 25;

    public function render()
    {
        if (! Auth::user())
            abort(403);

        return view('livewire.work.show-deleted-work', [
            'works' => $this->paginateArchive(),
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function paginateArchive(): LengthAwarePaginator
    {
        if ($this->search === '') {
            $query = Work::onlyTrashed()->with('partner')->latest()->orderByDesc('id');

            return $query->paginate($this->perPage, ['*'], 'page', $this->pageInRange($query->count()));
        }

        $matches = $this->searchMatches();
        $total = $matches->count();
        $page = $this->pageInRange($total);

        return new LengthAwarePaginator(
            $matches->forPage($page, $this->perPage)->values(),
            $total,
            $this->perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * client and description are encrypted, so a search can't go through SQL:
     * every row has to be decrypted here and the page sliced out by hand.
     */
    private function searchMatches()
    {
        $search = mb_strtolower($this->search);

        return Work::onlyTrashed()->with('partner')->latest()->orderByDesc('id')->get()
            ->filter(function ($work) use ($search) {
                return str_contains(mb_strtolower($work->client), $search)
                    || str_contains(mb_strtolower($work->description ?? ''), $search);
            })
            ->values();
    }

    /** Keeps the page valid after rows are restored or purged off the last page. */
    private function pageInRange(int $total): int
    {
        $lastPage = max(1, (int) ceil($total / $this->perPage));

        return min(max(1, (int) $this->getPage()), $lastPage);
    }

    public function restore($id)
    {
        if (! Auth::user())
            abort(403);
        Work::where('id', $id)->restore();
    }

    public function forceDelete($id)
    {
        if (! Auth::user())
            abort(403);
        Work::where('id', $id)->forceDelete();
    }
}
