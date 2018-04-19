<div class="control-content" style="max-height: 450px; overflow-y: scroll; margin-bottom: 20px; padding:0px;">
    <h4 class="contact-name" style="position: static;">{{ $contact->getName() }}</h4>
    <div class="contact-notes-container">
        @if (count($notes) == 0)
            <div class="row">
                <div class="col s12">
                    <p style="font-style: italic;">No notes</p>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col s12">
                    @foreach ($notes as $note)
                        @include('components.note')
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
<div class="control-footer" style="height: auto;">
    <div id="note-actions" class="row">
        <div class="input-field col s12">
            <form id="create-contact-note" method="post">
                {{ csrf_field() }}
                <input id="contact-id" type="hidden" name="contact_id" value="{{ $contact->id }}" />
                @if (!is_null($contact->user) && count($contact->user->inquiries) > 0)
                    <select name="inquiry_id" style="display:block">
                        <option value="">User</option>
                        @foreach ($contact->user->inquiries as $inquiry)
                            <option value="{{ $inquiry->id }}">{{ $inquiry->job->organization }} - {{ $inquiry->job->title }}</option>
                        @endforeach
                    </select>
                @endif
                <textarea id="note" name="note" placeholder="What's the latest?"></textarea>
                <div class="follow-up-controls">
                    <div class="col s4">
                        <input class="datepicker inline-block" id="follow-up-date" type="text" name="follow_up_date" value="{{ ($contact->follow_up_date) ? $contact->follow_up_date->format('Y-m-d') : '' }}" style="margin-bottom: 0; text-align: center;" />
                    </div>
                    @if ($contact->follow_up_date)
                        <button type="button" id="close-follow-up" class="btn green">Close</button>
                        <button type="button" id="reschedule-follow-up" class="btn blue">Reschedule</button>
                    @else
                        <button type="button" id="schedule-follow-up" class="btn blue">Schedule</button>
                    @endif
                    <button type="button" id="submit-contact-note" name="save" class="btn sbs-red">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div id="note-progress" class="row hidden" style="height: 149.5px; margin: 0; padding: 40px;">
        <div class="input-field col s12">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>
</div>
