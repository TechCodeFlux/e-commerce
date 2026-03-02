@extends('club.components.app')
    {{-- @yield('page-title','Club') --}}
    @section('content')
    <div class="mb-4">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-decoration-none" style="color: #fb641b;">
                        <i class="bi bi-globe2 small me-2"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-bag-check-fill small me-2"></i>Orders</li>
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

        <!-- Order List Container -->
        <div class="table-responsive" style="overflow-x: hidden;">
            <table class="table border-0 mb-0" id="order" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                <thead class="d-none">
                    <tr><th>Order Details</th></tr>
                </thead>
                <tbody class="border-0">
                    <!-- DataTables renders cards here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body text-center p-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="deleteId" name="deleteId">
                        <div class="bg-danger-subtle text-danger d-inline-flex p-3 rounded-circle mb-3">
                            <i class="bi bi-trash3-fill h3 mb-0"></i>
                        </div>
                        <h5 class="fw-bold">Delete Order</h5>
                        <p class="text-muted">Are you sure you want to delete this order entry? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger px-4 btn_delete_club_member">Delete Now</button>
                    </div>
                </form>
            </div>
        </div>   
    </div> 

@section('script')
<script src="{{ url('libs/dataTable/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    $orderTable = $('#order').DataTable({
        processing: true,
        serverSide: false,
        autoWidth: false,
        dom: 'rtip',
        ajax: {
            url: "{{ route('clubmember.vieworder') }}",
            data: function(d) {}
        },
        columns: [
            { 
                data: 'name',
                render: function(data, type, row) {
                    const isCancelled = row.order_status.toLowerCase().includes('cancel');
                    const statusColor = isCancelled ? 'text-danger' : 'text-success';
                    const stockText = Number(row.stock) > 0 ? 'In Stock' : 'Out of Stock';
                    const stockClass = Number(row.stock) > 0 ? 'text-success' : 'text-danger';
                    const formattedDate = row.created_at ? new Date(row.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'N/A';

                  return `
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body py-3">
        <div class="row align-items-center text-center text-md-start g-3">

            
            <!-- Image -->
            <div class="col-12 col-md-2 d-flex justify-content-center">
                <img src="${row.image}" 
                class="img-fluid rounded-3 bg-light p-2"
                style="max-height:80px; object-fit:contain;">
    
            </div>

            <!-- Product Details -->
            <div class="col-12 col-md-4">
                <h6 class="fw-bold text-warning mb-2">${row.name}</h6>

                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 small">
                    <span class="badge bg-light text-muted border">
                        Size: ${row.size || 'N/A'}
                    </span>
                    <span class="badge bg-light text-muted border">
                        Color: ${row.color || 'N/A'}
                    </span>
                    <span class="${stockClass} fw-semibold">
                        ${stockText}
                    </span>
                </div>
            </div>

            <!-- User Info -->
            <div class="col-12 col-md-3 border-md-start">
                <div class="small d-flex flex-column gap-1">
                    <div class="fw-semibold">
                        <i class="bi bi-person me-1 text-muted"></i>
                        ${row.username || 'User'}
                    </div>
                    <div class="text-muted">
                        <i class="bi bi-envelope me-1"></i>
                        ${row.email || 'N/A'}
                    </div>
                    <div class="text-muted">
                        <i class="bi bi-telephone me-1"></i>
                        ${row.phone || 'N/A'}
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="col-12 col-md-3 text-md-end border-md-start">
                <div class="d-flex flex-column align-items-center align-items-md-end gap-1">
                    <div class="fw-bold ${statusColor}">
                        <i class="bi bi-circle-fill small me-1"></i>
                        ${row.order_status}
                    </div>
                    <div class="text-muted small">
                        Ordered on ${formattedDate}
                    </div>
                    <div class="small">
                        Qty: <strong>${row.quantity}</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
`;
                }
            }
        ],
        "createdRow": function(row, data, dataIndex) {
            $(row).addClass('bg-transparent');
            $('td', row).addClass('p-0 border-0 bg-transparent');
        }
    });
    
    $(document).on("keyup", ".searchInput", function(e) {
        $orderTable.search($(this).val()).draw();
    });

    $('#sort').on('change', function() {
        let col = $(this).find(':selected').data('column');
        let sort = $(this).find(':selected').data('sort');
        if(col !== undefined) $orderTable.order([col, sort]).draw();
    });

    $('#pageLength').on('change', function(){
        $orderTable.page.len($(this).val()).draw();
    });
});
</script>

@if (session('success'))
    <div class="alert alert-success position-fixed bottom-0 end-0 m-3 shadow rounded-3 border-0" id="successAlert" style="z-index: 9999">
        <div class="d-flex align-items-center p-1">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i> 
            <span>{{ session('success') }}</span>
        </div>
    </div>
    <script>
        setTimeout(() => { 
            const el = document.getElementById('successAlert');
            if(el) el.classList.add('fade-out');
            setTimeout(() => el.remove(), 500);
        }, 3000);
    </script>
@endif
@endsection
@endsection