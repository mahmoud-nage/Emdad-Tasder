<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Banner Information')}}</h3>
    </div>

    <!--Horizontal Form-->
    <!--===================================================-->
    <form class="form-horizontal" action="{{ route('home_banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="type1" value="{{ $type1 }}">
        <input type="hidden" name="type2" value="{{ $type2 }}">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3" for="url">{{__('URL')}}</label>
                <div class="col-sm-9">
                    <input type="url" placeholder="{{__('URL')}}" id="url" name="url" value="{{old('url')}}" class="form-control @error('name_ar') is-invalid @enderror" required>
                    @error('url')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
            </div>
            <input type="hidden" name="position" value="{{ $position }}">
            <div class="form-group">
                <label class="col-sm-3" for="url">{{__('Banner Position')}}</label>
                <div class="col-sm-9">
                    <select class="form-control select2" name="position" required>
                        <option value="1">{{__('Banner Position 1')}}(300px*260px)</option>
                        <option value="2">{{__('Banner Position 2')}}(630px*260px)</option>
                        <option value="3">{{__('Banner Position 3')}}(450px*200px)</option>
                        <option value="4">{{__('Banner Position 4')}}(230px*200px)</option>
                        <option value="5">{{__('Banner Position 5')}}(1100px*270px)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3" for="country_id">{{__('Country')}}</label>
                <div class="col-sm-9">
                    <select class="form-control select2" name="country_id" required>
                        @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name_en}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="control-label">{{__('Banner Images')}} 
                    <span class='text-danger'>*</span>
                    <br><small class="text-danger">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                    </label>
                </div>
                <div class="col-sm-9">
                    <div id="photo">

                    </div>
                </div>
                @error('photo')
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

<script type="text/javascript">

    $(document).ready(function(){

        $('.demo-select2').select2();

        $("#photo").spartanMultiImagePicker({
            fieldName:        'photo',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-4 col-sm-9 col-xs-6 @error("photo") is-invalid @enderror',
            maxFileSize:      '',
            allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
            dropFileLabel : "Drop Here",
            onExtensionErr : function(index, file){
                console.log(index, file,  'extension err');
                alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
            },
            onSizeErr : function(index, file){
                console.log(index, file,  'file size too big');
                alert('File size too big');
            }
        });
    });

</script>
