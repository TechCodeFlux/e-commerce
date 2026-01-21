    @extends('admin.components.app')
    {{-- @yield('page-title','Club') --}}
    @section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-people-fill small me-2"></i>Clubs</li>
            </ol>
        </nav>
    </div>
    <div class="content">
        <div class="">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex gap-4 align-items-center">
                        <div class="d-none d-md-flex">All Clubs</div>
                        <div class="d-md-flex gap-4 align-items-center">
                            <form class="mb-3 mb-md-0">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <select class="form-select" id="sort">
                                            <option>Sort by</option>
                                            <option data-sort="asc" data-column="1" value="">Name A-z</option>
                                            <option data-sort="desc" data-column="1" value=""> Name Z-a
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-select" id="pageLength">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div> 
                        <div class="dropdown ms-auto">
                            <a href="{{ route('admin.club') }}">
                                <button class="btn btn-primary btn-icon">
                                        <i class="bi bi-plus-circle"></i> Add Club
                                </button>
                            </a>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom table-lg mb-0" id="club">
                    <thead>
                      <tr>
                         <th>Name</th>  
                         <th>email</th>  
                         <th>contact</th>
                         <th>Address</th>
                         <th>country_id</th>
                         <th>state_id</th>
                         <th>city</th>
                         <th>zip_code</th>
                        <th>Action</th>
                     </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Club</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
            <div class="modal-body">
                    <!-- <input type="hidden" name="_method" value="DELETE"> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="deleteId" name="deleteId">
                        <p>Are you sure you want to delete this club</p>
                        <div class="modal-footer">
                        
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-danger btn_delete_club_member" data-loading-text="">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>   
</div> 
@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script src="{{ url('libs/range-slider/js/ion.rangeSlider.min.js') }}"></script>
<script>

$(document).ready(function() {
    console.log("hello");
    var $column = $('#sort').find(':selected').data('column');
    var $sort = $('#sort').find(':selected').data('sort');
    $clubTable= $('#club').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.clubsindex') }}',
            data: function(d) {
                
            }
        },

        columns: [
           
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'contact',
                name: 'contact'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'country_id',
                name: 'country_id'
            },
            {
                data: 'state_id',
                name: 'state_id'
            },
            {
                data: 'city',
                name: 'city'
            },
             {
                data: 'zip_code',
                name: 'zipcode'
            },
            { 
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        columnDefs: [{
            'defaultContent': '--',
            "targets": "_all"
        }],
    });
    
    $(document).on("keyup", ".searchInput", function(e) {
        $clubTable.search($(this).val()).draw();
    });
    $("#club_filter").css({
        "display": "none"
    });
    $("#club_length").css({
        "display": "none"
    });
    $('#sort').on('change', function() {
        $column = $(this).find(':selected').data('column');
        $sort = $(this).find(':selected').data('sort');
        $clubTable.order([$column, $sort]).draw();
    })
    $('#pageLength').on('change',function(){
        $clubTable.page.len($(this).val()).draw();
    })
    $('#pageLength').val($clubTable.page.len());
})
//delete club member
// $('table').off('click').on('click','.delete-club-member',function(){
//     var href=$(this).data('href');
//     $('.btn_delete_club_member').click(function(){
//         $.ajax({
//             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
//             type: 'DELETE',
//             dataType : 'JSON',
//             url : href,
//             success:function(response){
//                 $('#delete-modal').modal('hide');
//                 $('#club').DataTable().ajax.reload();
//                 Swal.fire({
//                     icon: 'success',
//                     title: 'Member deleted successfully',
//                     footer: ''
//                 })
//             }  
//         })
//     })

// })
</script>

@endsection
@endsection