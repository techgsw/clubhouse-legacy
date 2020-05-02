<div class="training-video-find-book-modal modal modal-large modal-fixed-footer">
    <div class="modal-content">
        <h4>Training Video Books and Chapters</h4>
        <p>Click the name of a chapter to have it added to this product as an option. You can add more than one.</p>
        <div class="row">
            @foreach($training_video_book_chapter_map as $book => $chapters)
                <div class="col s12 m6">
                    <h5>{{$book}}</h5>
                    <ul>
                        @foreach($chapters as $chapter)
                            <li style="margin-bottom:10px;"><button class="flat-button small add-training-video-chapter" data-book-name="{{$book}}" data-chapter-name="{{$chapter}}">{{$chapter}}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn sbs-red">Close</a>
    </div>
</div>
