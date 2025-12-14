    {{-- resources/views/components/work-column.blade.php --}}
    @props(['works', 'priority', 'color'])

    @if($works->where('priority', $priority)->count())
    <div class="col-sm-3">
        <div class="row p-1">
            @foreach ($works->where('priority', $priority) as $work)
                <div class="col-12 mb-2 bg-{{ $color }}-subtle shadow">
                    <div class="row py-1 align-items-center">

                        <div class="col-8">
                            <h3 class="fw-bold mb-0">{{ $work->client }}</h3>
                            <span class="text-secondary small d-block">[#{{ $work->id }}] {{ $work->created_at }}</span>
                        </div>

                        <div class="col-4 text-center">
                            @include('components.work-source', ['work' => $work])
                        </div>

                        {{-- Opis i bilješka --}}
                        <div class="col-12">
                            @markdown($work->description)
                            @if($work->note)
                                <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>
                            @endif
                        </div>

                        {{-- Partner info --}}
                        @if($work->partner)
                            <div class="col-12">
                                <div class="row bg-{{ $color }} bg-opacity-25 text-dark justify-content-between">
                                    <div class="col-auto small">
                                        Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €
                                    </div>
                                    <div class="col-auto">
                                        @if($work->outsourced) <i class="bi bi-send-check"></i> @endif 
                                        @if($work->loan) <i class="bi bi-currency-exchange"></i> @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary ">
                                @include('components.work-controls', ['work' => $work, 'priority' => $priority])
                            </div>
                        </div>

                        {{-- Statusi --}}
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary ">
                                @include('components.work-status', ['work' => $work])
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
