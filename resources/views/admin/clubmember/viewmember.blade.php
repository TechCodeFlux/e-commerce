
@extends('admin.components.app')
 @section('page-title', $club->name) 

@section('head')
@endsection

@section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubsindex') }}">
                        <i class="bi bi-people-fill small me-2"></i> Clubs
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clubs.dashboard', $club->id) }}">
                        <i class="bi bi-people-fill small me-2"></i>{{$club->name}}
                    </a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-building small me-2"></i>club members</li>  
            </ol>
        </nav>
    </div>

<div class="content ">
    <div class="row flex-md-row">
        
        @include('admin.club.side_bar')

        <div class="col-md-9">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                    <div class="d-md-flex gap-4 align-items-center">
                                        <div class="d-none d-md-flex">All Club Members</div>
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
                                            <a href="{{ route('admin.clubmember.addmember',$club->id) }}">
                                                <button class="btn btn-primary btn-icon">
                                                        <i class="bi bi-plus-circle"></i> Add Club Members
                                                </button>
                                            </a>
                                        </div>
                                        
                                    </div>
                                    </div>
                                </div>
                                <div class="">
                                    <table class="table table-custom table-lg mb-0" id="clubmember">
                                    <thead>
                                    <tr>
                                        <th>Name</th> 
                                        <th>contact</th> 
                                        <th>email</th>                         
                                        <th>Address</th>
                                        <th>zip code</th>
                                        <th>country</th>
                                        <th>state</th>
                                        <th>city</th>
                                        <th>club name</th>
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
                                <h5 class="modal-title" id="staticBackdropLabel">Delete Club Member</h5>
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
                    $clubTable= $('#clubmember').DataTable({
                        processing: true,
                        serverSide: true,
                        dom:'rtip',
                        scrollY: '400px', 
                        scrollX: true,  // 👈 height of table
                        scrollCollapse: true,
                        ajax: {
                            url: "{{ route('admin.clubmember.viewmembers',compact('club')) }}",
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
                            },{
                                data: 'zip_code',
                                name: 'zip_code'
                            },{
                                data: 'country',
                                name: 'country'
                            },
                            {
                                data: 'state',
                                name: 'state'
                            },{
                                data: 'city',
                                name: 'city'
                            },
                            {
                                data: 'club',
                                name: 'club'
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

                    $('.dataTables_paginate').addClass('d-flex justify-content-center');
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
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
