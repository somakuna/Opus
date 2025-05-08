<div class="row justify-content-center">
    @if($works->where('priority', 3))
    <div class="col-sm-3">
        <div class="row">
            @foreach ($works->where('priority', 3) as $work)
            <div class="col-12 mb-3 bg-danger-subtle shadow">
                <div class="row">
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('work.edit', $work) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="delete({{$work->id}})">
                                    <i class="bi bi-recycle"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="decreasePriority({{$work->id}})">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </div>
                            {{-- <div class="col">
                                <a wire:click.prevent="increasePriority({{$work->id}})">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            
                            @if ($work->partner)
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" class="col @if($work->outsourced) text-success @else text-danger @endif">
                                    <i class="bi bi-fast-forward"></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'design')" class="col @if($work->design) text-success @else text-danger @endif">
                                    <i class="bi bi-layers-half"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'ready')" class="col @if($work->ready) text-success @else text-danger @endif">
                                    <i class="bi bi-check2-all"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'delivered')" class="col @if($work->delivered) text-success @else text-danger @endif">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'paid')" class="col @if($work->paid) text-success @else text-danger @endif">
                                    <i class="bi bi-currency-euro"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 p-2">
                        <span class="h3">{{ $work->client }}</span>
                        <p class="text-secondary" style="font-size:8pt;">[#{{ $work->id }}] {{ $work->created_at }}</p>
                    </div>
                    <div class="col-3 p-2 text-center">
                        @switch($work->source)
                            @case('Walk in')
                                <span class="badge text-bg-secondary">{{ $work->source }}</span>
                                @break
                            @case('E-mail')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                            @case('WhatsApp')
                                <span class="badge text-bg-success">{{ $work->source }}</span>
                                @break
                            @case('Signal')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                        @endswitch
                        <br>
                        <span class="badge text-bg-dark">{{ $work->payment_method }} {{ $work->price }} €</span>
                    </div>
                    <div class="col-12">
                        <p class="">{!! nl2br($work->description) !!}</p>
                        @if($work->note) <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>@endif
                    </div>
                    @if($work->partner)
                    <div class="col-12" style="font-size:9pt;">
                        <div class="row bg-warning text-dark justify-content-between">
                            <div class="col-auto">Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €</div>
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
    @if($works->where('priority', 2))
    <div class="col-sm-3">
        <div class="row">
            @foreach ($works->where('priority', 2) as $work)
            <div class="col-12 mb-3 bg-warning-subtle shadow">
                <div class="row">
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('work.edit', $work) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="delete({{$work->id}})">
                                    <i class="bi bi-recycle"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="increasePriority({{$work->id}})">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="decreasePriority({{$work->id}})">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            
                            @if ($work->partner)
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" class="col @if($work->outsourced) text-success @else text-danger @endif">
                                    <i class="bi bi-fast-forward"></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'design')" class="col @if($work->design) text-success @else text-danger @endif">
                                    <i class="bi bi-layers-half"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'ready')" class="col @if($work->ready) text-success @else text-danger @endif">
                                    <i class="bi bi-check2-all"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'delivered')" class="col @if($work->delivered) text-success @else text-danger @endif">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'paid')" class="col @if($work->paid) text-success @else text-danger @endif">
                                    <i class="bi bi-currency-euro"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 p-2">
                        <span class="h3">{{ $work->client }}</span>
                        <p class="text-secondary" style="font-size:8pt;">[#{{ $work->id }}] {{ $work->created_at }}</p>
                    </div>
                    <div class="col-3 p-2 text-center">
                        @switch($work->source)
                            @case('Walk in')
                                <span class="badge text-bg-secondary">{{ $work->source }}</span>
                                @break
                            @case('E-mail')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                            @case('WhatsApp')
                                <span class="badge text-bg-success">{{ $work->source }}</span>
                                @break
                            @case('Signal')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                        @endswitch
                        <br>
                        <span class="badge text-bg-dark">{{ $work->payment_method }} {{ $work->price }} €</span>
                    </div>
                    <div class="col-12">
                        <p class="">{!! nl2br($work->description) !!}</p>
                        @if($work->note) <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>@endif
                    </div>
                    @if($work->partner)
                    <div class="col-12" style="font-size:9pt;">
                        <div class="row bg-warning text-dark justify-content-between">
                            <div class="col-auto">Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €</div>
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
    @if($works->where('priority', 1))
    <div class="col-sm-3">
        <div class="row">
            @foreach ($works->where('priority', 1) as $work)
            <div class="col-12 mb-3 bg-primary-subtle shadow">
                <div class="row">
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('work.edit', $work) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="delete({{$work->id}})">
                                    <i class="bi bi-recycle"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="increasePriority({{$work->id}})">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="decreasePriority({{$work->id}})">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            
                            @if ($work->partner)
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" class="col @if($work->outsourced) text-success @else text-danger @endif ">
                                    <i class="bi bi-fast-forward"></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'design')" class="col @if($work->design) text-success @else text-danger @endif">
                                    <i class="bi bi-layers-half"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'ready')" class="col @if($work->ready) text-success @else text-danger @endif">
                                    <i class="bi bi-check2-all"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'delivered')" class="col @if($work->delivered) text-success @else text-danger @endif">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'paid')" class="col @if($work->paid) text-success @else text-danger @endif">
                                    <i class="bi bi-currency-euro"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 p-2">
                        <span class="h3">{{ $work->client }}</span>
                        <p class="text-secondary" style="font-size:8pt;">[#{{ $work->id }}] {{ $work->created_at }}</p>
                    </div>
                    <div class="col-3 p-2 text-center">
                        @switch($work->source)
                            @case('Walk in')
                                <span class="badge text-bg-secondary">{{ $work->source }}</span>
                                @break
                            @case('E-mail')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                            @case('WhatsApp')
                                <span class="badge text-bg-success">{{ $work->source }}</span>
                                @break
                            @case('Signal')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                        @endswitch
                        <br>
                        <span class="badge text-bg-dark">{{ $work->payment_method }} {{ $work->price }} €</span>
                    </div>
                    <div class="col-12">
                        <p class="">{!! nl2br($work->description) !!}</p>
                        @if($work->note) <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>@endif
                    </div>
                    @if($work->partner)
                    <div class="col-12" style="font-size:9pt;">
                        <div class="row bg-warning text-dark justify-content-between">
                            <div class="col-auto">Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €</div>
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
    @if($works->where('priority', 0))
    <div class="col-sm-3">
        <div class="row">
            @foreach ($works->where('priority', 0) as $work)
            <div class="col-12 mb-3 bg-success-subtle shadow">
                <div class="row">
                    <div class="col-6">
                        <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, false]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click="print({{$work->id}})" href="{{ route('work.print', [$work, true]) }}" target="_blank" class="@if($work->printed) text-body-emphasis @endif">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('work.edit', $work) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="delete({{$work->id}})">
                                    <i class="bi bi-recycle"></i>
                                </a>
                            </div>
                            {{-- <div class="col-auto">
                                <a wire:click.prevent="decreasePriority({{$work->id}})">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </div> --}}
                            <div class="col-auto">
                                <a wire:click.prevent="increasePriority({{$work->id}})">
                                    <i class="bi bi-caret-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                        <div class="col-6">
                            <div class="row justify-content-center text-center text-secondary bg-light bg-opacity-25">
                            
                            @if ($work->partner)
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'outsourced')" class="col @if($work->outsourced) text-success @else text-danger @endif">
                                    <i class="bi bi-fast-forward"></i>
                                </a>
                            </div>
                            @endif
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'design')" class="col @if($work->design) text-success @else text-danger @endif">
                                    <i class="bi bi-layers-half"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'ready')" class="col @if($work->ready) text-success @else text-danger @endif">
                                    <i class="bi bi-check2-all"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'delivered')" class="col @if($work->delivered) text-success @else text-danger @endif">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a wire:click.prevent="changeStatus({{$work->id}}, 'paid')" class="col @if($work->paid) text-success @else text-danger @endif">
                                    <i class="bi bi-currency-euro"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-9 p-2">
                        <span class="h3">{{ $work->client }}</span>
                        <p class="text-secondary" style="font-size:8pt;">[#{{ $work->id }}] {{ $work->created_at }}</p>
                    </div>
                    <div class="col-3 p-2 text-center">
                        @switch($work->source)
                            @case('Walk in')
                                <span class="badge text-bg-secondary">{{ $work->source }}</span>
                                @break
                            @case('E-mail')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                            @case('WhatsApp')
                                <span class="badge text-bg-success">{{ $work->source }}</span>
                                @break
                            @case('Signal')
                                <span class="badge text-bg-primary">{{ $work->source }}</span>
                                @break
                        @endswitch
                        <br>
                        <span class="badge text-bg-dark">{{ $work->payment_method }} {{ $work->price }} €</span>
                    </div>
                    <div class="col-12">
                        <p class="">{!! nl2br($work->description) !!}</p>
                        @if($work->note) <p class="fst-italic text-secondary">{!! nl2br($work->note) !!}</p>@endif
                    </div>
                    @if($work->partner)
                    <div class="col-12" style="font-size:9pt;">
                        <div class="row bg-warning text-dark justify-content-between">
                            <div class="col-auto">Outsourced to <strong>{{ $work->partner->name }}</strong> for {{ $work->outsourced_price }} €</div>
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
</div>
