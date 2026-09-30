@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <livewire:circular.edit-circular :circular="$circular" />
    </div>
</div>
@endsection
