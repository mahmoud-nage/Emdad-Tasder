                                       @foreach ($options as $option_key => $option)
                                                  {{--  @if($option->image)
                                                <li data-level="{{$choice}}" onclick="" class="size" data-value="{{ $option->id }}" style="border:0 !important;height: auto;padding: 5px 0 !important;">
                                                    
                                                    
                                                <input type="hidden" name="option" value="{{ $option->id }}" class="hidden">
                                                        <a data-fancybox="gallery" href="{{asset($option->image)}}">
                                                            <img width="50px" height="50px" src="{{asset($option->image)}}" alt="{{$option['value_'.app()->getLocale()]}}" title="{{$option['value_'.app()->getLocale()]}}">
                                                        </a>
                                                           </li>
                                                     @else --}}
                                                <li data-level="{{$choice}}" onclick="" class="size" data-value="{{ $option->id }}">
                                                <input type="hidden" name="option" value="{{ $option->id }}" class="hidden">
                                                        {{isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}
                                                       </li>
                                                    {{-- @endif --}}
                                             
                                            @endforeach
                                            
                                            
                                            <script>
            $(".size-list li,.colors-list li").click(function () {
            var elem = $(this);
            $(this).parent().children().removeClass("active");
            $(this).addClass("active");
            console.log(elem.data('value'));
            $(this).parent().parent().prev().val(elem.data('value'));
            getVariantPrice();
        });
                                            </script>