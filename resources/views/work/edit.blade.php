@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        @livewire('work.edit-work', ['work' => $work])
    </div>
</div>
@endsection
