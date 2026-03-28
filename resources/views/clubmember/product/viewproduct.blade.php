@extends('clubmember.components.app')
    <!-- @yield('page-title','Club') -->
    @section('content')
    <style>
        /* Transform Table into a Responsive Grid */
        #product { border: none !important; display: block; width: 100% !important; }
        #product thead { display: none; } /* Hide headers for card view */
        #product tbody { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 1.5rem; 
            padding: 1rem 0;
            border: none !important;
        }
        #product tr { 
            display: flex; 
            flex-direction: column; 
            height: 100%; 
            background: #fff;
            border: 1px solid #e9ecef !important;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        #product tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        #product td { 
            display: block; 
            padding: 0; 
            border: none !important;
        }

        /* Utility for fixed aspect ratio images */
        .card-img-container {
            height: 200px;
            width: 100%;
            background-color: #f8f9fa;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Alignment fix for DataTables elements */
        .dataTables_wrapper .dataTables_processing { top: 20% !important; }
        .dataTables_empty { grid-column: 1 / -1; padding: 3rem !important; text-align: center; }
    </style>

    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 m-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/clubmember') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">
                    <i class="bi bi-people-fill small me-2"></i>Products
                </li>
            </ol>
        </nav>
    </div>

    <div class="col-md-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                    <div class="d-md-flex gap-4 align-items-center">                                
                                    <div class="d-none d-md-flex">My Orders</div>
                                        <div class="d-md-flex gap-4 align-items-center">
                                            <form class="mb-3 mb-md-0">
                                                <div class="row g-3">
                                                    <div class="col-md-7">
                                                        <select class="form-select" id="sort">
                                                            <option>Sort by</option>
                                                            <option data-sort="asc" data-column="0" value="">Name A-z</option>
                                                            <option data-sort="desc" data-column="0" value=""> Name Z-a
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
                                        {{-- <div class="position-relative mt-3" style="min-width: 250px;">
                                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                            <input type="text" class="form-control ps-5 rounded-pill border-light-subtle shadow-none searchInput" placeholder="Search orders...">
                                        </div> --}}
                                    </div>
                                </div>
            </div>
        </div>

        <!-- Product Grid Area -->
        <div class="table-responsive" style="overflow: visible;">
            <table class="table mb-0 w-100" id="product">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Description</th>                            
                        <th>Size</th>
                        <th>Colour</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTable will inject cards here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Delete Product</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body text-center py-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="deleteId" name="deleteId">
                        <div class="mb-3">
                            <i class="bi bi-trash3 text-danger fs-1"></i>
                        </div>
                        <p class="mb-0">Are you sure you want to delete this product? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger px-4 rounded-pill btn_delete_club_member">Delete</button>
                    </div>
                </form>
            </div>
        </div>   
    </div> 

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    var $ProductTable = $('#product').DataTable({
        processing: true,
        serverSide: true,
        scrollX: false,
        autoWidth: false,
        dom: 'rt<"d-flex justify-content-center mt-4"p>', // Show only processing and pagination
        ajax: {
            url: "{{ route('clubmember.viewproduct') }}",
            data: function(d) {}
        },
        columns: [
            {
                data: 'name',
                name: 'name',
                className: 'order-2',
                render: function(data) {
                    return `<div class="px-3 pt-3"><h6 class="fw-bold text-dark mb-1 text-truncate" title="${data}">${data}</h6></div>`;
                }
            },
            {
                data: 'image',
                name: 'image',
                className: 'order-1',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Check if server sent raw HTML or just URL
                    let imgSrc = "";
                    if (data && data.includes('<img')) {
                        const match = data.match(/src=["']([^"']+)["']/);
                        imgSrc = match ? match[1] : '';
                    } else {
                        imgSrc = data;
                    }
                    let finalImg = imgSrc ? imgSrc : 'https://via.placeholder.com/400x300?text=No+Image';
                    return `<div class="card-img-container"><img class="w-50 mt-sm-5"src="${finalImg}" alt="${row.name}" ></div>`;
                }
            },
            {
                data: 'description',
                name: 'description',
                className: 'order-3 flex-grow-1',
                render: function(data) {
                    return `<div class="px-3"><p class="text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">${data || 'No description available for this item.'}</p></div>`;
                }
            },
            {
                data: 'size',
                name: 'size',
                className: 'order-4',
                render: function(data, type, row) {
                    let stockClass = Number(row.stock) > 0 ? 'bg-success text-success' : 'bg-danger text-danger';
                    let stockText = Number(row.stock) > 0 ? 'In Stocks' : 'Out of Stock';
                    return `
                        <div class="px-3 pb-2">
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge bg-light text-dark border fw-normal">Size: ${data || 'N/A'}</span>
                                <span class="badge bg-light text-dark border fw-normal">Color: ${row.color || 'N/A'}</span>
                            </div>
                            <div class="card-img-top small fw-bold  bg-opacity-10 py-1 rounded text-center" style="background-color: rgba(230, 103, 19, 0.97); color: rgb(240, 240, 240);">
                                ${stockText}
                            </div>
                        </div>`;
                }
            },
            { data: 'color', name: 'color', visible: false },
            { data: 'stock', name: 'stock', visible: false },
            { 
                data: 'action',
                name: 'action',
                className: 'order-5 p-3 mt-auto border-top',
                orderable: false,
                searchable: false,
                render: function(data) {
                    // Style existing buttons to be modern grid buttons
                    let styledButtons = data.replace(/btn /g, 'btn btn-sm flex-fill rounded-pill shadow-none ');
                    return `<div class="d-flex gap-2">${styledButtons}</div>`;
                }
            }
        ],
        columnDefs: [{
            'defaultContent': '--',
            "targets": "_all"
        }]
    });
    
    // External search control
    $(document).on("keyup", ".searchInput", function() {
        $ProductTable.search($(this).val()).draw();
    });

    // Sort control
    $('#sort').on('change', function() {
        var col = $(this).find(':selected').data('column');
        var sort = $(this).find(':selected').data('sort');
        $ProductTable.order([col, sort]).draw();
    });

    // Page Length control
    $('#pageLength').on('change',function(){
        $ProductTable.page.len($(this).val()).draw();
    });

    $('#pageLength').val(12);
});
</script>

{{-- @if (session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
        <div id="successAlert" class="alert alert-success shadow-lg border-0 d-flex align-items-center mb-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const alert = document.getElementById('successAlert');
            if(alert) {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
@endif --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonText: 'OK'
    });
});
</script>
@endif

@endsection
@endsection