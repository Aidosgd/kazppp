@extends('frontend.app')

@section('content')
    @component('frontend.parts.breadcrumb'){{ $page->title }}@endcomponent
    <h1>{{ $page->title }}</h1>

    <div class="desc-content">
        {!! $page->content !!}
    </div>
@endsection