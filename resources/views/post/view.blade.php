<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>Blog | Post Details Page</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/') }}/assets/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/') }}/assets/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/') }}/assets/vendors/images/favicon-16x16.png" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/assets/vendors/styles/style.css" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
        crossorigin="anonymous"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", "GTM-NXZMQSS");
    </script>
    <!-- End Google Tag Manager -->

    <!-- Toaster Message -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    @include('common.header')

    @include('common.sidebar')

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Post Detail</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Post Detail
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="blog-wrap">
                    <div class="container pd-0">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="blog-detail card-box overflow-hidden mb-30">
                                    <div class="blog-img">
                                        <img src="{{ url('/') }}/blog/post/{{ $blogs->image }}" alt="" />
                                    </div>
                                    <div class="blog-caption">
                                        <h4 class="mb-10">
                                            {{ $blogs->title }}
                                        </h4>
                                        <p>
                                            {{ $blogs->content }}
                                        </p>

                                    </div>
                                    <div class="bg-white border-radius-4 box-shadow mb-30">
                                        <div class="row no-gutters">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="chat-detail">
                                                    <div class="chat-profile-header clearfix">
                                                        <div class="left">
                                                            <div class="chat-profile-name">
                                                                <h3>{{ $blogs->user?->name }}</h3>
                                                                <span>{{\Carbon\Carbon::parse($blogs->created_at)}}</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="chat-box">
                                                        <div class="chat-desc customscroll">
                                                            <ul>
                                                                @foreach ($parrentPostComments as $value )
                                                                <li class="clearfix">
                                                                    <div class="chat-body clearfix">
                                                                        <p>
                                                                            {{ $value->post_comment }}
                                                                        </p>
                                                                        <div class="chat_time">
                                                                            {{\Carbon\Carbon::parse($value->created_at)}}
                                                                        </div>
                                                                    </div>

                                                                    @php
                                                                        $replyComments = DB::table('post_child_comments as t1')
                                                                                             ->select('t1.post_reply_comment', 't1.created_at')
                                                                                             ->where('t1.post_parent_comment_id', $value->id)
                                                                                             ->where('t1.blog_id', $value->blog_id)
                                                                                             ->where('t1.user_id', Auth::user()->id)
                                                                                             ->whereNull('t1.deleted_at')
                                                                                             ->orderBy('t1.id', 'desc')
                                                                                             ->get();
                                                                    @endphp
                                                                    <div class="chat-footer border mt-5">
                                                                        @foreach ($replyComments as $replyComment )
                                                                        <ul>
                                                                            <li class="clearfix admin_chat">
                                                                                <div class="chat-body clearfix">
                                                                                    <p>{{ $replyComment->post_reply_comment }}</p>
                                                                                    <div class="chat_time">
                                                                                        {{\Carbon\Carbon::parse($replyComment->created_at)}}
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                        @endforeach

                                                                        <form method="POST" action="{{ route('post.child.comment.add', $value->id) }}" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="hidden" id="blog_id"  name="blog_id" value="{{$blogs->id}}" >
                                                                            <input type="hidden" id="comment_id"  name="comment_id" value="{{$value->id}}" >

                                                                            <div class="chat_text_area">
                                                                                <textarea required class="form-control" type="text" id="post_reply_comment" name="post_reply_comment" value="{{ old('post_reply_comment') }}" placeholder="Type your message…">{{ old('post_reply_comment') }}</textarea>
                                                                            </div>
                                                                            <div class="chat_send">
                                                                                <button class="btn btn-link" type="submit">
                                                                                    <i class="icon-copy ion-paper-airplane"></i>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="chat-footer">
                                                            <form method="POST" action="{{ route('post.parrent.comment.add', $blogs->id) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" id="blog_id"  name="blog_id" value="{{$blogs->id}}" >

                                                                <div class="chat_text_area">
                                                                    <textarea required class="form-control" type="text" id="post_comment" name="post_comment" value="{{ old('post_comment') }}" placeholder="Type your message…">{{ old('post_comment') }}</textarea>
                                                                </div>
                                                                <div class="chat_send">
                                                                    <button class="btn btn-link" type="submit">
                                                                        <i class="icon-copy ion-paper-airplane"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @include('common.footer')
        </div>
    </div>

    <!-- js -->
    <script src="{{ url('/') }}/assets/vendors/scripts/core.js"></script>
    <script src="{{ url('/') }}/assets/vendors/scripts/script.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/scripts/process.js"></script>
    <script src="{{ url('/') }}/assets/vendors/scripts/layout-settings.js"></script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXZMQSS" height="0" width="0"
            style="display: none; visibility: hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
</body>

</html>
