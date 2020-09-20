@php
    $coupon_det = json_decode($coupon->details);
@endphp

<div class="panel-heading">
   <h3 class="panel-title">{{__('Add Your Cart Base Coupon')}}</h3>
</div>
<div class="form-group">
   <label class="col-lg-3 control-label" for="coupon_code">{{__('Coupon code')}}
      <span class="text-danger">*</span>
   </label>
   <div class="col-lg-9">
       <input type="text" value="{{$coupon->code}}" id="coupon_code" name="coupon_code" class="form-control @error('coupon_code') is-invalid @enderror" required>
       @error('coupon_code')
       <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
       </span>
       @enderror
   </div>
</div>


<div class="form-group">
  <label class="col-lg-3 control-label">{{__('Minimum Shopping')}}
   <span class="text-danger">*</span>
</label>
  <div class="col-lg-9">
     <input type="number" min="0" step="0.01" name="min_buy" class="form-control @error('min_buy') is-invalid @enderror" value="{{ $coupon_det->min_buy }}" required>
     @error('min_buy')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
  </div>
</div>
<div class="form-group">
  <label class="col-lg-3 control-label">{{__('Discount')}}
   <span class="text-danger">*</span>
</label>
  <div class="col-lg-8">
     <input type="number" min="0" step="0.01" placeholder="{{__('Discount')}}" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ $coupon->discount }}" required>
     @error('discount')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
  </div>
  <div class="col-lg-1">
     <select class="select2 @error('discount_type') is-invalid @enderror" name="discount_type">
        <option value="amount" @if ($coupon->discount_type == 'amount') selected  @endif >LE</option>
        <option value="percent" @if ($coupon->discount_type == 'percent') selected  @endif>%</option>
     </select>
     @error('discount_type')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
  </div>
</div>
<div class="form-group">
  <label class="col-lg-3 control-label">{{__('Maximum Discount Amount')}}
   <span class="text-danger">*</span>
</label>
  <div class="col-lg-9">
     <input type="number" min="0" step="0.01" placeholder="{{__('Maximum Discount Amount')}}" name="max_discount" class="form-control @error('max_discount') is-invalid @enderror" value="{{ $coupon_det->max_discount }}" required>
     @error('max_discount')
     <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
     </span>
     @enderror
   </div>
</div>
<div class="form-group">
   <label class="col-lg-3 control-label" for="start_date">{{__('Date')}}
      <span class="text-danger">*</span>
   </label>
   <div class="col-lg-9">
       <div id="demo-dp-range">
           <div class="input-daterange input-group" id="datepicker">
               <input type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ date('m/d/Y', $coupon->start_date) }}">
               @error('start_date')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
               <span class="input-group-addon">{{__('to')}}
                  <span class="text-danger">*</span>
               </span>
               <input type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ date('m/d/Y', $coupon->end_date) }}">
               @error('end_date')
               <span class="invalid-feedback" role="alert">
                   <strong>{{ $message }}</strong>
               </span>
               @enderror
           </div>
       </div>
   </div>
</div>

<script type="text/javascript">

   $(document).ready(function(){
       $('.demo-select2').select2();
   });

</script>
