<div class="row">
    <div class="col s12">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title grey-text">Career Services</span>
                    <p><strong>TAGS</strong> <span class="flat-button grey small">Career Service</span> <strong>AND</strong> <span class="flat-button grey small">Career Coaching</span>, <span class="flat-button grey small">Sales Training</span>, <span class="flat-button grey small">Leadership Development</span> <strong>OR</strong> <span class="flat-button grey small">Other</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col m4">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title grey-text">Webinars</span>
                    <p><strong>TAGS</strong> <span class="flat-button grey small">Webinar</span> <strong>AND/OR</strong>  <span class="flat-button grey small">#SameHere</span></p>
                    <p>to display on either page</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title grey-text">Training Videos<button class="flat-button large training-video-find-book-button">Find a book and chpater</button></span>
                    <p><strong>TAG</strong> <span class="flat-button grey small">Training Video</span></p>
                    <p>Use <strong>TAG</strong> <span class="flat-button grey small">Author:[Author Name]</span> to include an author. Ex <span class="flat-button grey small">Author:John Doe</span></p>
                    <p>Use <strong>Option Name</strong> to include the video in a book, and <strong>Option Description</strong> to include the video in a chapter. Price of 0 and quantity of 1 must be included. Click "Find a book and chapter" above to automatically set the options.</p>
                    <p>Include the video code with sbs-embed-code=[video code] at the end of the <strong>Product Description</strong>, ex sbs-embed-code=123456789</p>
                </div>
            </div>
        </div>
    </div>
    @include('product.components.training-video-find-book-modal', ['training_video_book_chapter_map' => $training_video_book_chapter_map])
</div>