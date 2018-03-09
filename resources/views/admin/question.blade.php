<!-- /resources/views/admin/question.blade.php -->
@extends('layouts.admin')
@section('title', 'Question & Answer')
@section('content')
<div class="row">
    <div class="col s12">
        <h4>Unapproved Questions</h4>
        @if (count($unapproved) > 0)
            @foreach ($unapproved as $question)
                <div class="row">
                    <div class="col s12">
                        <a href="/question/{{ $question->id }}"><h5>Q: {{ $question->title }}</h5></a>
                        <p class="light">by {{ $question->user->getName() }} on {{ $question->created_at->format('F j, Y g:ia') }}</p>
                        <p class="small">
                            @can ('approve-question', $question)
                                @if (is_null($question->approved) || $question->approved == false)
                                    <a href="/question/{{ $question->id }}/approve" class="green-text spaced"><i class="fa fa-check"></i> Approve</a>
                                @endif
                                @if (is_null($question->approved) || $question->approved == true)
                                    <a href="/question/{{ $question->id }}/disapprove" class="red-text spaced"><i class="fa fa-ban"></i> Disapprove</a>
                                @endif
                            @endcan
                            @can ('edit-question', $question)
                                <a href="/question/{{ $question->id }}/edit" class="blue-text spaced"><i class="fa fa-pencil"></i> Edit</a>
                            @endcan
                        </p>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $unapproved->appends(request()->all())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
