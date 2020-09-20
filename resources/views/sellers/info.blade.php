@extends('layouts.app')

@section('content')

@include('sellers.summary')

<div class="col-lg-12" id="data" style="margin-bottom: 50px">

</div>

@endsection



@section('script')

    <script type="text/javascript">

            
        function get_seller_products(id) {
            $.post('{{ route('seller.products') }}', {
                _token: '{{ csrf_token() }}',
                seller_id: id
            }, function (data) {
                $('#data').html(data);
            });
        }
        function get_seller_orders(id) {
            $.post('{{ route('seller.orders') }}', {
                _token: '{{ csrf_token() }}',
                seller_id: id
            }, function (data) {
                $('#data').html(data);
            });
        }
                function get_seller_payments(id) {
            $.post('{{ route('sellers.payment_histories') }}', {
                _token: '{{ csrf_token() }}',
                seller_id: id
            }, function (data) {
                $('#data').html(data);
            });
        }
    </script>
        <script type="text/javascript">

            $(document).ready(function () {
                //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
            });
    
            function update_todays_deal(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('products.todays_deal') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function (data) {
                    if (data == 1) {
                        showAlert('success', 'Todays Deal updated successfully');
                    } else {
                        showAlert('danger', 'Something went wrong');
                    }
                });
            }
    
            function update_published(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('products.published') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function (data) {
                    if (data == 1) {
                        showAlert('success', 'Published products updated successfully');
                    } else {
                        showAlert('danger', 'Something went wrong');
                    }
                });
            }
    
            function update_featured(el) {
                if (el.checked) {
                    var status = 1;
                } else {
                    var status = 0;
                }
                $.post('{{ route('products.featured') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                }, function (data) {
                    if (data == 1) {
                        showAlert('success', 'Featured products updated successfully');
                    } else {
                        showAlert('danger', 'Something went wrong');
                    }
                });
            }
        </script>
        <script>
                $("#image").spartanMultiImagePicker({
                fieldName: 'file',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12',
                maxFileSize: '',
                dropFileLabel: "Drop Here",
                onExtensionErr: function (index, file) {
                    console.log(index, file, 'extension err');
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
</script>
@endsection
