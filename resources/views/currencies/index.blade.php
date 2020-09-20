@extends('layouts.app')

@section('content')

    {{-- <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('currencies.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Currency')}}</a>
        </div>
    </div> --}}
    <hr>
    <div class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __(' Currencies') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Country Name')}}</th>
                        <th>{{__('Symbol')}}</th>
                        <th>{{__('Exchange_rate')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Code')}}</th>
                        {{-- <th></th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($currencies as $key => $currency)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $currency->name_en }}</td>
                            <td>{{ $currency->name }}</td>
                            <td>{{ $currency->symbol }}</td>
                            <td>{{ $currency->exchange_rate  }}</td>
                            <td>{{ $currency->status  }}</td>
                            <td>{{ $currency->code  }}</td>
                            <td><div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                     <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('currencies.edit', encrypt($currency->id))}}">{{__('Edit')}}</a></li>
                                    </ul> 
                                </div>
                            </td> 
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Todays Deal updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Published products updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Featured products updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
