@extends('layouts.app')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Unit Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('events.update', $record->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name Ar')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name_ar" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" required value="{{$record->name_ar}}">
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name En')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name_en" name="name_en" class="form-control @error('name_en') is-invalid @enderror" required value="{{$record->name_en}}">
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Description Ar')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-10">
                                <textarea class="editor @error('desc_ar') is-invalid @enderror"
                                          name="desc_ar" oninvalid="alert('You must fill Event Description Ar!');" required>{{$record->desc_ar}}</textarea>
                        @error('desc_ar')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Description En')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-10">
                                <textarea class="editor @error('desc_en') is-invalid @enderror"
                                          name="desc_en" oninvalid="alert('You must fill Event Description En!');" required>{{$record->desc_en}}</textarea>
                        @error('desc_en')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Date')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-10">
                        <input type="date" value="{{$record->date}}" class=" @error('date') is-invalid @enderror"
                               name="date" oninvalid="alert('You must fill Event Date!');" required>
                        @error('date')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{__('Main Images')}}
                        <span class="text-danger">*</span>
                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                        <br><small class="text-danger text-xs">Best Size: (450*450)</small></label>
                    <div class="col-lg-7">
                        <div id="photos">
                            @if(is_array(json_decode($record->photos)))
                                @foreach (json_decode($record->photos) as $key => $photo)
                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="img-upload-preview">
                                            <img src="{{ asset($photo) }}" alt="" class="img-responsive">
                                            <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @error('photos')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>


            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $("#photos").spartanMultiImagePicker({
                fieldName: 'photos[]',
                maxCount: 10,
                rowHeight: '200px',
                groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("photos") is-invalid @enderror',
                maxFileSize:      '',
                allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
                dropFileLabel : "Drop Here",
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();

            });
        });
    </script>
@endsection

