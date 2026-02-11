@extends('admin.components.app')
@section('page-title','varient Form')
@section('content')

<div class="container mt-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
             

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-12 ">

                     <form 
                        action="{{ $varient->id? route('admin.varient_management.edit_varient', $varient->id): route('admin.varient_management.add_varient') }}"
                        method="POST" 
                        autocomplete="off">
                        @csrf
                        @if($varient->id)
                            @method('PUT')
                        @endif
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Size"  value="{{ old('size', $varient->size ?? '') }}"  
                                    >
                                @error('size')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>     

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Color" 
                                    value="{{ old('color', $varient->color ?? '') }}">
                                @error('color')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                             <div class="col-md-4 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" class="form-control" placeholder="Stock" 
                             value="{{ old('stock', $varient->stock ?? '') }}">
                                @error('stock')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div> 

                            <div class="col-md-6 mb-3 mt-3 mt-5 w-25 m-lg-0 mx-lg-4 m-lg-2 ">
                                <label class="form-label d-block ">Status</label>
                                <input type="hidden" name="status" value="0">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                         data-id="{{$varient->id ?? '' }}" {{ $varient->status ?? old('status', 1) ? 'checked' : '' }}
                                        type="checkbox"
                                        name="status"
                                        id="statusSwitch"
                                        value="1"   
                                    >
                                    <label class="form-check-label" for="statusSwitch" id="statusLabel">
                                        {{ $varient->status ?? old('status', 1) ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- CHANGED: Combined Button Container using Bootstrap d-flex --}}
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            
                           
                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-primary px-5 p-md-2">
                                {{$varient->id ?? '' ? 'Update' : 'Submit' }}
                            </button> 
                        </div>        
                    </form>
                    
                </div>
                
                {{-- Previous Form: Hidden shell that handles the logic --}}
             
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
$(document).ready(function() {
    // ✅ RESTORE FORM DATA ON PAGE LOAD (from localStorage)
    // const savedData = localStorage.getItem('varientForm');
    // if (savedData) {
    //     const formData = JSON.parse(savedData);
    //     $('.VarientForm input[name="size"]').val(formData.size || '');
    //     $('.VarientForm input[name="color"]').val(formData.color || '');
    //     $('.VarientForm input[name="stock"]').val(formData.stock || '');
            
    //     // Restore status toggle
    //     const statusSwitch = $('#statusSwitch');
    //     if (formData.status === '1' || formData.status === 1) {
    //         statusSwitch.prop('checked', true);
    //         $('#statusLabel').text('Active');
    //     }
    // }

    // // ✅ SAVE FORM DATA ON ANY INPUT CHANGE (before Previous button)

    // $('.VarientForm input, .VarientForm select, .VarientForm textarea').on('input change', function() {
    //     saveFormData();
    // });

    // ✅ SAVE FORM DATA BEFORE PREVIOUS BUTTON CLICK
    // $('.previous-form').on('submit', function(e) {
    //     saveFormData();
    // });

    // function saveFormData() {
    //     const formData = {
    //         size: $('.VarientForm input[name="size"]').val(),
    //         color: $('.VarientForm input[name="color"]').val(),
    //         stock: $('.VarientForm input[name="stock"]').val(),
    //         status: $('#statusSwitch').is(':checked') ? '1' : '0'
    //     };
    //     localStorage.setItem('varientForm', JSON.stringify(formData));
    // }

    // ✅ ORIGINAL FORM SUBMIT (unchanged)


    // $('.VarientForm').on('submit', function (e) {
    //     e.preventDefault();
    //     let formData = new FormData(this);
    //     formData.append('_token', '{{ csrf_token() }}');

    //     $.ajax({
    //         url: "{{ route('admin.varient_management.add_varient') }}",
    //         type: "POST",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function (response) {
    //             // localStorage.removeItem('varientForm'); // ✅ CLEAR ON SUCCESS
    //             // localStorage.removeItem('productForm');
    //             alert(response.message);
    //             window.location.href ="{{ route('admin.varient_management.show_varient') }}";
    //         },
    //         error: function (xhr) {
    //             if (xhr.status === 422) {
    //                 $('.text-danger').remove();
    //                 let errors = xhr.responseJSON.errors;
    //                 $.each(errors, function (field, messages) {
    //                     $('[name="' + field + '"]')
    //                         .after(
    //                             '<small class="text-danger d-block mt-1">' +
    //                             messages[0] +
    //                             '</small>'
    //                         );
    //                 });
    //             }
    //         }
    //     });
    // });

    // ✅ STATUS TOGGLE (unchanged)
    document.addEventListener('DOMContentLoaded', function () {
        const statusSwitch = document.getElementById('statusSwitch');
        const statusLabel = document.getElementById('statusLabel');
        if (statusSwitch) {
            statusSwitch.addEventListener('change', function () {
                statusLabel.innerText = this.checked ? 'Active' : 'Inactive';
                saveFormData(); // ✅ SAVE STATUS CHANGE
            });
        }
    });

    // $(document).on('change', '.toggle-status', function () {
    //     let varientId = $(this).data('id');
    //     let status = $(this).is(':checked') ? 1 : 0;
    //     $.ajax({
    //         url: "{{ route('admin.varient_management.change-status') }}",
    //         type: "POST",
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             id: varientId,
    //             status: status
    //         },
    //     });
    // });
});
</script>
@endsection
@endsection