@extends('affiliate.layouts.app')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="settings">

        <!-- begin:: Subheader -->


        <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand flaticon2-box"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Update Settings
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form kt-form--label-right" method="POST" action="{{ route('affiliate.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Name *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name" value="{{ $user->name }}"
                                               placeholder="Enter Name" required>
                                    </div>
                                    @error('name_ar')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email" value="{{ $user->email }}"
                                               placeholder="Email" readonly>
                                    </div>
                                    @error('name_en')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Password *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               placeholder="Password">
                                    </div>
                                    @error('password')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Password Confirmation *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                               name="password_confirmation"
                                               placeholder="Password">
                                    </div>
                                    @error('password')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Phone *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               name="phone" value="{{ $user->phone }}"
                                               placeholder="Phone">
                                    </div>
                                    @error('name_en')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Country *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <select type="text" class="form-control @error('country') is-invalid @enderror"
                                                name="country">
                                            <option value="">Select Country</option>
                                            @foreach(\App\Country::all() as $country)
                                                <option value="{{ $country->code }}"
                                                        @if($country->code == $user->country) selected @endif>{{ $country->name_en }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('country')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">egyptian mail *</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" name="egyptian_mail_status"
                                               v-model="egyptian_mail_status" value="1"> egyptian mail
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="egyptian_mail_status">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Full name *</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control @error('full_name') is-invalid @enderror"
                                                   name="full_name" value="{{ $affiliate->full_name }}"
                                                   placeholder="Full name">
                                        </div>
                                        @error('full_name')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">SSN *</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('SSN') is-invalid @enderror"
                                                   maxlength="14"
                                                   name="SSN" value="{{ $affiliate->SSN }}"
                                                   placeholder="SSN">
                                        </div>
                                        @error('name_en')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">bank account </label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" name="bank_account_status" v-model="bank_account_status"
                                               value="1"> bank account
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="bank_account_status">

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Bank name *</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control @error('bank_name') is-invalid @enderror"
                                                   maxlength="14"
                                                   name="bank_name" value="{{ $affiliate->bank_name }}"
                                                   placeholder="bank_name">
                                        </div>
                                        @error('bank_name')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Bank account username *</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control @error('bank_account_username') is-invalid @enderror"
                                                   maxlength="14"
                                                   name="bank_account_username"
                                                   value="{{ $affiliate->bank_account_username }}"
                                                   placeholder="Bank account username ">
                                        </div>
                                        @error('bank_account_username')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3 col-sm-12">Bank account number *</label>
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            <input type="text"
                                                   class="form-control @error('bank_account_number') is-invalid @enderror"
                                                   maxlength="14"
                                                   name="bank_account_number"
                                                   value="{{ $affiliate->bank_account_number }}"
                                                   placeholder="bank_name">
                                        </div>
                                        @error('bank_account_number')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 col-sm-12">Avatar</label>
                                <div class="col-lg-3 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="file" name="avatar" id="input-file-now" class="dropify"  data-default-file="{{ asset($user->avatar) }}"/>
                                    </div>
                                    @error('avatar')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class=" ">
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>

        <!-- end:: Content -->
    </div>
@stop
@section('script')
    <script src="{{ asset('assets/admin/js/pages/crud/forms/validation/form-widgets.js') }}"
            type="text/javascript"></script>
    <script>
        var x = 1;
        var home = new Vue({
            el: "#settings",
            data: {
                urls: {},
                egyptian_mail_status: '{!! $affiliate->egyptian_mail_status == 1 ? true : false !!}',
                bank_account_status: '{!! $affiliate->bank_account_status == 1 ? true : false !!}',
                query: $(location).attr('search'),
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
        });
    </script>

@stop
