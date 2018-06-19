<div class="contact-note-container" style="display: flex; flex-flow: column; height: 100%; max-height: 100%;">
    <div class="contact-note-header" style="flex: 0 0 auto;">
        <h4 class="contact-name">{{ $contact->getName() }}</h4>
    </div>
    <div class="contact-note-content" style="flex: 1 1 auto; overflow-y: scroll; margin-bottom: 20px; padding:0px;">
        <div class="contact-notes-container">
            @include('contact.notes.show')
        </div>
    </div>
    <div class="contact-note-controls" style="flex: 0 0 auto; height: auto;">
        <div id="note-actions">
            <form id="create-contact-note" method="post">
                {{ csrf_field() }}
                <input id="contact-id" type="hidden" name="contact_id" value="{{ $contact->id }}" />
                @if (!is_null($contact->user) && count($contact->user->inquiries) > 0)
                    <select name="inquiry_id" style="display: block; margin-bottom: 8px;">
                        <option value="">Select a job (optional)</option>
                        @foreach ($contact->user->inquiries as $inquiry)
                            <option value="{{ $inquiry->id }}">{{ $inquiry->job->organization_name }} - {{ $inquiry->job->title }}</option>
                        @endforeach
                    </select>
                @endif
                <textarea id="note" name="note" placeholder="What's the latest?" style="background-color: rgba(255, 255, 255, 0.9);"></textarea>
                <div class="follow-up-controls" style="margin-top: 10px;">
                    <input class="datepicker inline-block" id="follow-up-date" type="text" name="follow_up_date" value="{{ ($contact->follow_up_date) ? $contact->follow_up_date->format('d F, Y') : '' }}" style="text-align: center; width: 160px;"/>
                    @if ($contact->follow_up_date)
                        <button type="button" id="reschedule-follow-up" class="btn blue">Reschedule</button>
                        <button type="button" id="close-follow-up" class="btn green">Close</button>
                    @else
                        <button type="button" id="schedule-follow-up" class="btn blue">Schedule</button>
                    @endif
                    <button type="button" id="submit-contact-note" name="save" class="btn sbs-red right">Save</button>
                </div>
            </form>
        </div>
        <div id="note-progress" class="row hidden" style="height: 149.5px; margin: 0; padding: 40px;">
            <div class="input-field col s12">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>
    </div>
</div>
