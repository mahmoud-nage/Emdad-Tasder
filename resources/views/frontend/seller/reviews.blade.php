@extends('frontend.layouts.app')
@section('title' , __('general.product_rating') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.product_rating')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">

                <!-- Order -->
                <div class="profile-title">
                    {{__('general.product_rating')}}
                </div>
                <!-- User Info -->
                <div class="table-wrapper">
                    <div class="table-block">
                        <table class="table table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('general.product')}}</th>
                                <th>{{__('general.customer')}}</th>
                                <th>{{__('general.product_rating')}}</th>
                                <th>{{__('general.comments')}}</th>
                                <th>{{__('forms.published')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($reviews) > 0)
                                @foreach ($reviews as $key => $review)
                                    @php
                                        $review = \App\Review::find($review->id);
                                    @endphp
                                    @if($review != null && $review->product != null && $review->user != null)
                                        <tr>
                                            <td>
                                                {{ $key+1 }}
                                            </td>
                                            <td>
                                                <a href="{{ route('product',['country' => get_country()->code, 'slug'=>$review->product->slug]) }}" target="_blank">{{ app()->isLocale('ar') ? $review->product->name_ar : $review->product->name_en }}</a>
                                            </td>
                                            <td>{{ $review->user->name }} ({{ $review->user->email }})</td>
                                            <td>
                                                <div class="star-rating star-rating-sm mt-1">
                                                    @for ($i=0; $i < floor($review->rating); $i++)
                                                        <i class="fa fa-star active"></i>
                                                    @endfor
                                                    @for ($i=0; $i < ceil(5-$review->rating); $i++)
                                                        <i class="fa fa-star
                                                                        @if($i==0 && ($review->rating - floor($review->rating)) > 0 && ($review->rating - floor($review->rating)) <= 0.5)
                                                            half
@elseif($i==0 && (ceil($review->rating) - $review->rating) > 0 && (ceil($review->rating) - $review->rating) <= 0.5)
                                                            active
@endif">
                                                        </i>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>{{ $review->comment }}</td>
                                            <td>
                                                @if ($review->status == 1)
                                                    <span class="label label-success">{{ __('forms.published') }}</span>
                                                @else
                                                    <span class="label label-danger">{{ __('forms.unpublished') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center pt-5 h4" colspan="100%">
                                        <i class="la la-meh-o d-block heading-1 alpha-5"></i>
                                        <span class="d-block">{{ __('No review found.') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
