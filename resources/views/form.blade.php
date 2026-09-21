@extends('layouts.app')

@section('title', 'เขียนบทความใหม่')

@section('content')
    <!-- jQuery & Summernote CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <h2 class="text text-center py-2">เขียนบทความใหม่</h2>
    <form method="POST" action="/insert">
        @csrf
        <div class="mb-3">
            <label for="title">ชื่อบทความ</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content">เนื้อหา</label>
            <textarea name="content" id="content" class="form-control" cols="30" rows="5">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <input type="submit" value="บันทึก" class="btn btn-primary my-3">
        <a href="/blogs" class="btn btn-success my-3">บทความทั้งหมด</a>
    </form>

    <script>
        $(document).ready(function() {
            // ฟังก์ชันแยก ID ของ YouTube จาก URL ทุกแบบ
            function extractYouTubeId(url) {
                var match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|shorts\/|watch\?.+&v=))([\w-]{11})/);
                return match ? match[1] : null;
            }

            // ปุ่ม Custom สำหรับใส่ YouTube วิดีโอโดยเฉพาะ
            var YouTubeButton = function (context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-video"/>',
                    tooltip: 'แทรกวิดีโอ YouTube',
                    click: function () {
                        var url = prompt("กรุณาวางลิงก์ YouTube ที่ต้องการ:");
                        if (url) {
                            var videoId = extractYouTubeId(url);
                            if (videoId) {
                                var iframeHtml = '<p><div class="ratio ratio-16x9 my-3" style="max-width: 640px;"><iframe width="640" height="360" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div></p><p><br></p>';
                                $('#content').summernote('pasteHTML', iframeHtml);
                            } else {
                                alert("ไม่พบรหัสวิดีโอ YouTube จากลิงก์นี้ กรุณาตรวจสอบลิงก์อีกครั้ง");
                            }
                        }
                    }
                });
                return button.render();
            }

            $('#content').summernote({
                placeholder: 'เขียนเนื้อหาบทความ...',
                tabsize: 2,
                height: 320,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'myYoutube']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                buttons: {
                    myYoutube: YouTubeButton
                }
            });
        });
    </script>
@endsection
