@extends('frontend.layouts.app')
@section('title' , $blogshow['title_en'])

@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $blogshow->description}}">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $blogshow['title_en'] }}">
    <meta itemprop="description" content="{{ substr(app()->isLocale('ar') ? $blog->article_ar : $blog->article,0,100) }}">
    <meta itemprop="image" content="{{ asset($blogshow->image) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="Blog">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $blogshow['title_en'] }}">
    <meta name="twitter:description" content="{{ substr(app()->isLocale('ar') ? $blog->article_ar : $blog->article,0,100) }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($blogshow->image) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $blogshow['title_en'] }}"/>
    <meta property="og:type" content="Blog"/>
    <meta property="og:url" content="{{ route('blogShow', $blogshow->id) }}"/>
    <meta property="og:image" content="{{ asset($blogshow->image) }}"/>
    <meta property="og:description" content="{{ substr(app()->isLocale('ar') ? $blog->article_ar : $blog->article,0,100) }}"/>
    <meta property="og:site_name" content="{{ $blogshow->name }}"/>
@endsection
@section('content')

    <div class="articles-container">
        <div class="container">
            <div class="page-name">
                <img src="../assets/images/magazine.svg" alt="">
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-8 col-lg-9">
                    <!--  Article  -->
                    <div class="article-item article-single">
                        <div class="article-title">
                            {{ app()->isLocale('ar') ? $blogshow->title_ar : $blogshow->title }}
                        </div>
                        <div style="margin: auto" class="article-img">
                            <img src="{{ asset($blogshow->image)}}" alt="">
                        </div>
                        <div class="article-details">
                            <div class="article-category">
                                @php
                                    $department = $blogshow->department;
                                  
                                @endphp
                                @if($department)
                                {{ app()->isLocale('ar') ? $department->name_ar : $department->name_en }}
                                @endif
                                </div>
                            <div>
                                <span class="article-date">{{Carbon\Carbon::parse($blogshow->created_at)->diffForHumans()}}</span>	&nbsp;
                                <span class="article-visits"> {{__('general.visits')}} {{$blogshow->read_number}} </span>
                            </div>
                        </div>
                        <!--  Author  -->
                        <div class="media author-wrapper">
                            <div class="media-left">
                                <img class="media-object" src="{{asset('/assets/web/newface/images/logo.png')}}" alt="...">
                            </div>
                            <div class="media-body media-middle">
                                <div class="author-name">{{$blogshow['author_name_'.app()->getLocale()]}}</div>
                                <div class="author-title">{{$blogshow['author_title_'.app()->getLocale()]}}</div>
                            </div>
                        </div>

                        <div class="article-text">
                            <p>
                                {{ app()->isLocale('ar') ? $blogshow->article_ar : $blogshow->article }}
                            </p>
                        </div>
                    </div>
                              @php 
         if(strlen($blogshow->video) > 11)
         {
           if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $blogshow->video, $match))
             {
                $link=  $match[1].'?author=NewFace&rel=0';
        }
        }
         
@endphp
                       <iframe id="existing-iframe-example"
                               width="640" height="360"
                               src="https://www.youtube.com/embed/{{isset($link)?$link:''}}?enablejsapi=1"
                               frameborder="0"
                               style="border: solid 4px #37474F"
                       ></iframe>
    
                       <script type="text/javascript">
                           var tag = document.createElement('script');
                           tag.id = 'iframe-demo';
                           tag.src = 'https://www.youtube.com/iframe_api';
                           var firstScriptTag = document.getElementsByTagName('script')[0];
                           firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    
                           var player;
                           function onYouTubeIframeAPIReady() {
                               player = new YT.Player('existing-iframe-example', {
                                   events: {
                                       'onReady': onPlayerReady,
                                       'onStateChange': onPlayerStateChange
                                   }
                               });
                           }
                           function onPlayerReady(event) {
                               document.getElementById('existing-iframe-example').style.borderColor = '#FF6D00';
                           }
                           function changeBorderColor(playerStatus) {
                               var color;
                               if (playerStatus == -1) {
                                   color = "#37474F"; // unstarted = gray
                               } else if (playerStatus == 0) {
                                   color = "#FFFF00"; // ended = yellow
                               } else if (playerStatus == 1) {
                                   color = "#33691E"; // playing = green
                               } else if (playerStatus == 2) {
                                   color = "#DD2C00"; // paused = red
                               } else if (playerStatus == 3) {
                                   color = "#AA00FF"; // buffering = purple
                               } else if (playerStatus == 5) {
                                   color = "#FF6DOO"; // video cued = orange
                               }
                               if (color) {
                                   document.getElementById('existing-iframe-example').style.borderColor = color;
                               }
                           }
                           function onPlayerStateChange(event) {
                               changeBorderColor(event.data);
                           }
                       </script>
                       <ul class="tags-list">
                           <li><a href="#">التأهيل النفسي</a></li>
                       </ul>
                </div>

                <div class="hidden-xs hidden-sm col-md-4 col-lg-3">
                    <!--  Section title  -->
                    <div class="articles-section-title articles-side">
                <span>
                    {{__('general.most_read')}}
                </span>
                    </div>
                    <!--  Articles  -->
                    <div class="row">
                        @foreach($moreReads as $blog)
                            <div class="col-xs-12">
                                <a href="{{route('blogShow',['id'=>$blog->id])}}" class="article-side">
                                    <div class="article-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-text">
                                        {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!--  Section title  -->
                    <div class="articles-section-title articles-side">
                <span>
                    {{__('general.other_blog')}}
                </span>
                    </div>
                    <!--  Articles  -->
                    <div class="row">
                        @foreach($otherBlogs as $blog)
                            <div class="col-xs-12">
                                <a href="{{route('blogShow',['id'=>$blog->id])}}" class="article-side">
                                    <div class="article-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-text">
                                        {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-12">
                    
                    
                    <!--  Comments  -->
                    <div class="comments-wrapper">
                        <!--  Ad 160 * 600  -->
                    <!--    <div class="ad-160-600 visible-lg">-->
                        <!--<img src="{{asset('assets/web/newface/images/8897615623091846003.png')}}" alt="">-->
                    <!--</div>-->
                        <!--  Comments  -->
                        <div class="fb-comments" data-href="https://newfaceeg.com/blog/show/{{$blogshow->id}}" data-numposts="5" data-width=""></div>
                        <!--  Ad 160 * 600  -->
                        <!--<div class="ad-160-600 visible-lg">-->
                            <!--<img src="{{asset('assets/web/newface/images/8897615623091846003.png')}}" alt="">-->
                        <!--</div>-->
                    </div>
                    
                    
                    
                    <!--  Section title  -->
                    <div class="articles-section-title articles-side">
                <span>
                    {{__('general.most_read')}}
                </span>
                    </div>
                    <!--  Articles  -->
                    <div class="row">
                        @foreach(\App\Blog::orderBy('read_number', 'desc')->take(6)->get() as $blog)
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <a href="{{route('blogShow',['id'=>$blog->id])}}" class="article-side">
                                    <div class="article-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-text">
                                        {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
