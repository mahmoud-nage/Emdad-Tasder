@extends('layouts.app')

@section('content')


<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">{{ __('Language Info') }}</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('languages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="col-lg-3">
                        <label class="control-label">{{ __('Name') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('Name') }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3">
                        <label class="control-label">{{ __('Code') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <select class="country-flag-select @error('code') is-invalid @enderror" name="code">
                            @foreach(\File::files(base_path('public/frontend/images/icons/flags')) as $path)
                                <option value="{{ pathinfo($path)['filename'] }}" data-flag="{{ asset('frontend/images/icons/flags/'.pathinfo($path)['filename'].'.png') }}"> {{ strtoupper(pathinfo($path)['filename']) }}</option>
                            @endforeach
                        </select>
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
