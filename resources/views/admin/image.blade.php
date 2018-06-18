<!-- /resources/views/admin/image.blade.php -->
@extends('layouts.admin')
@section('title', 'Images')
@section('content')
<div class="row">
    <div class="col s12" style="display: flex; flex-flow: row; margin-top: 10px;">
        <p style="text-transform: uppercase; flex: 1 0 auto; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF; line-height: 36px; padding: 0 2rem;"><b>{{ $count }}</b> images<br/><span style="font-size: 80%">({{ $local }} queued for upload)</style></p>
    </div>
</div>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        @if (count($images) > 0)
            <div class="row">
                @foreach ($images as $image)
                    <div class="col s4 m3 center-align" style="padding: 10px;">
                        <a href="/image/{{ $image->id }}" class="no-underline">
                            <img src="{{ $image->getURL('small') }}" alt="" style="max-height: 100px; box-shadow: 2px 2px #F2F2F2;">
                        </a>
                        <div style="color: #000; border: solid 2px #000; width: 26px; height: 26px; border-radius: 50%; margin-top: -20px; margin-left: 40px; position: absolute; background: #FFF;">
                            @if ($image->cdn)
                                <i class="fa fa-cloud-upload"></i>
                            @else
                                <i class="fa fa-hdd-o"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $images->appends(request()->all())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@component('components.pdf-view-modal')@endcomponent
@endsection
