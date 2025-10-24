{{-- resources/views/components/work-column.blade.php --}}
@props(['works', 'priority', 'color'])

@if($works->where('priority', $priority)->count())
<div class="col-sm-3">
    <div class="row">
        @foreach ($works->where('priority', $priority) as $work)
            <div class="col-12 mb-3 bg-{{ $color }}-subtle shadow">
                <div class="row">
                    {{-- Gornja sekcija - kontrole --}}
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            @include('components.work-controls', ['work' => $work, 'priority' => $priority])
                        </div>
                    </div>

                    {{-- Statusi --}}
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            @include('components.work-status', ['work' => $work])
                        </div>
                    </div>

                    {{-- Klijent i datum --}}
                    <div class="col-9 p-2">
                        <span class="h3">{{ $work->client }}</span>
                        <p class="text-secondary small">[#{{ $work->id }}] {{ $work->created_at }}</p>
                    </div>

                    {{-- Izvor i cijena --}}
                    <div class="col-3 p-2 text-center">
                        @include('components.work-source', ['work' => $work])
                    </div>

                    {{-- Opis i bilješka --}}
                    <div class="col-12">
                        <p>{!! nl2br($work->description) !!}</p>
                        @if($work->note)
                            <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>
                        @endif
                    </div>

                    {{-- Partner info --}}
                    @if($work->partner)
                        <div class="col-12 small">
                            <div class="row bg-warning text-dark justify-content-between">
                                <div class="col-auto">
                                    Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €
                                </div>
                                <div class="col-auto">
                                    @if($work->outsourced) <i class="bi bi-send-check"></i> @endif 
                                    @if($work->loan) <i class="bi bi-currency-exchange"></i> @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
