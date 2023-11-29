<div class="row justify-content-center">
    @for ($i = 3; $i >= 0; $i--)
        @if($works->where('priority', $i))
        <div class="col-sm-3">
            <div class="row">
                @foreach ($works->where('priority', $i) as $work)
                    @switch($i)
                        @case(1)
                            <div class="col-12 mb-3 bg-success-subtle shadow">
                            @break

                        @case(2)
                            <div class="col-12 mb-3 bg-primary-subtle shadow">
                            @break

                        @case(3)
                            <div class="col-12 mb-3 bg-danger-subtle shadow">
                            @break
                    
                        @default
                        <div class="col-12 mb-3 bg-dark shadow">
                    @endswitch
                    <div class="row">
                        <div class="col-12">
                            <div class="row justify-content-center text-center bg-black bg-opacity-50">
                                <div class="col">
                                    <a href="{{ route('work.print', $work) }}" class="@if($work->printed) text-secondary @else text-primary-emphasis @endif">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="{{ route('work.edit', $work) }}" class="text-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="delete({{$work->id}})" class="text-secondary">
                                        <i class="bi bi-recycle"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="increasePriority({{$work->id}})" class="text-secondary">
                                        <i class="bi bi-caret-left"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="decreasePriority({{$work->id}})" class="text-secondary">
                                        <i class="bi bi-caret-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-center text-center text-body text-opacity-25 bg-black bg-opacity-25">
                                <div class="col">
                                    <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" class="col @if($work->outsourced) text-success text-opacity-75 @else text-danger text-opacity-50 @endif">
                                        <i class="bi bi-fast-forward"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="changeStatus({{$work->id}}, 'design')" class="col @if($work->design) text-success text-opacity-75 @else text-danger text-opacity-50 @endif">
                                        <i class="bi bi-layers-half"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="changeStatus({{$work->id}}, 'ready')" class="col @if($work->ready) text-success text-opacity-75 @else text-danger text-opacity-50 @endif">
                                        <i class="bi bi-check2-all"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="changeStatus({{$work->id}}, 'delivered')" class="col @if($work->delivered) text-success text-opacity-75 @else text-danger text-opacity-50 @endif">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <a wire:click.prevent="changeStatus({{$work->id}}, 'paid')" class="col @if($work->paid) text-success text-opacity-75 @else text-danger text-opacity-50 @endif">
                                        <i class="bi bi-currency-euro"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-9 p-1">
                            <span class="h3">{{ $work->client }}</span>
                            <p class="text-secondary text-opacity-50" style="font-size:8pt;">[#{{ $work->id }}] {{ $work->created_at }}</p>
                        </div>
                        <div class="col-3 p-1 text-center">
                            <span class="badge text-bg-dark">{{ $work->payment_method }}</span>
                            <span class="badge bg-success-subtle">{{ $work->price }} €</span>
                        </div>
                        <div class="col-12">
                            <p class="fw-bold">{{ $work->description }}</p>
                            @if($work->note) <p class="fst-italic text-secondary text-opacity-75">{{ $work->note }}</p>@endif
                        </div>
                        @if($work->partner)
                        <div class="col-12" style="font-size:9pt;">
                            <div class="row bg-warning text-dark justify-content-between">
                                <div class="col-auto">Outsourced to <strong>{{ $work->partner->name }}</strong></div>
                                <div class="col-auto @if($work->outsourced) text-decoration-line-through text-dark @endif">Price: {{ $work->outsourced_price }} €</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endfor
</div>
