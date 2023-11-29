@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-md-4 p-4 bg-dark-subtle rounded border border-1">
            @livewire('work.edit-work', ['work' => $work])
        </div>
        
    </div>
</div>
@endsection
