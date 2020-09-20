@extends('layouts.app')
@section('title' , 'Zones')
@section('content')
    <!-- BEGIN CONTENT -->
    <div id="areas" class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>Zones</h1>
                    <button class="btn btn-primary" data-toggle="modal"
                            data-target="#create">Create</button>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="areas-table">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> Name ar</th>
                                <th> Name en</th>
                                <th> Area</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th> #</th>
                                <th> Name ar</th>
                                <th> Name en</th>
                                <th> Area</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr v-for="zone, index  in zones">
                                <td> @{{ parseInt(index) +1 }}</td>
                                <td> @{{ zone.name_ar }}</td>
                                <td> @{{ zone.name_en }}</td>
                                <td> @{{ zone.area.name_en }}</td>
                                <td>
                                    <button type="button" class="btn btn-info"
                                            @click="edit(zone.id,zone.name_ar,zone.name_en,zone.area_id)">
                                        edit
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" @click="destroy(zone.id , index)">
                                        delete
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                         aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">{{__('forms.edit')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="update-form">
                                        <input type="hidden" name="zone_id" v-model="area_id">
                                        <div class="form-group">
                                            <select class="form-control" name="city_id" v-model="area_id">
                                                <option value="">{{__('general.choose_area')}}</option>
                                                @foreach(\App\Area::all() as $area)
                                                    <option value="{{ $area->id }}">
                                                        {{ \App::isLocale('en') ? $area->name_en : $area->name_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name_ar" v-model="name_ar"
                                                   placeholder="Name ar">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name_en" v-model="name_en"
                                                   placeholder="Name en">
                                        </div>
                                        <div class="form-group">
                                            <input type="button" class="btn btn-primary" value="عدل"
                                                   @click="update()">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect text-left"
                                            data-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div id="create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                         aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">{{__('forms.create')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <select class="form-control" name="city_id" v-model="area_id">
                                                <option value="">{{__('general.choose_area')}}</option>
                                                @foreach(\App\Area::all() as $area)
                                                    <option value="{{ $area->id }}">
                                                        {{ $area->name_ar }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name_ar" v-model="name_ar"
                                                   placeholder="Name ar">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name_en" v-model="name_en"
                                                   placeholder="Name en">
                                        </div>
                                        <div class="form-group">
                                            <input type="button" class="btn btn-primary" value="Create"
                                                   @click="store()">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect text-left"
                                            data-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>


                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>


            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection
@section('script')
    <script>
        new Vue({
            el: "#areas",
            data: {
                zones: {},
                area_id: '',
                zone_id: '',
                name_ar: '',
                name_en: '',
                base_url: "{!! url('/') !!}",
                url: "{!! url('/') !!}" + '/admin/zones',
            },
            mounted() {
                this.getZones();
            },
            methods: {
                edit(id, name_ar, name_en , area_id) {
                    this.name_ar = name_ar;
                    this.name_en = name_en;
                    this.zone_id = id;
                    this.area_id = area_id;
                    $("#edit").modal('show');
                },
                store() {
                    $.ajax({
                        url: "{{ route('api.zones.store') }}",
                        type: 'POST',
                        data: {
                            area_id: this.area_id,
                            name_ar: this.name_ar,
                            name_en: this.name_en,
                        },
                    }).then((response) => {
                        this.getAreas();
                        $("#create").modal('toggle');
                        $.toast({
                            heading: 'Sucessfully',
                            text: response.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'info',
                            hideAfter: 3000,
                            stack: 6
                        });
                    });
                },
                update() {
                    $.ajax({
                        url: this.base_url + '/api/admin/zones/update/' + this.zone_id,
                        type: 'POST',
                        data: {
                            name_ar: this.name_ar,
                            name_en: this.name_en,
                            area_id: this.area_id,
                        },
                    }).then((response) => {
                        this.getAreas();
                        $("#edit").modal('toggle');
                        $.toast({
                            heading: 'Sucessfully',
                            text: response.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'info',
                            hideAfter: 3000,
                            stack: 6
                        });
                    });
                },
                getZones: function () {
                    $.ajax({
                        url: "{!! route('api.zones') !!}",
                        type: 'GET',
                    }).then((response) => {
                        this.zones = response.data;
                    })
                },
                destroy: function (id, index) {
                    console.log(index);
                    if (confirm('Do you really want to delete this item?')) {
                        $.ajax({
                            url: "{!! url('/api/admin/zones/') !!}" + '/' + id,
                            type: 'POST',
                        }).then((response) => {
                            $.toast({
                                heading: 'Successfully',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'info',
                                hideAfter: 3000,
                                stack: 6
                            });
                            
                            this.$delete(this.zones, index);
                        })
                    }
                },
            },
        })
        ;
    </script>
@stop

