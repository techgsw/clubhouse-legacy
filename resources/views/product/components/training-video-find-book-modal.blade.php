<div class="training-video-find-book-modal modal modal-large modal-fixed-footer">
    <div class="modal-content">
        <h4>Training Video Books</h4>
        <p>Click the name of a book to have it added to this product as an option. You can add more than one.</p>
        <div class="row">
            @foreach($training_video_book_chapter_map as $book => $chapters)
                <button class="flat-button btn-large add-training-video-chapter" data-book-name="{{$book}}">{{$book}}</button>
                <br>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn sbs-red">Close</a>
    </div>
</div>
