<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Member Profile</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/dist/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center p-3">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Main Card -->
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white">
                    
                    <!-- Header Banner -->
                    <div class="p-5 bg-primary bg-gradient position-relative" style="height: 120px;">
                        <!-- Avatar Container -->
                        <div class="position-absolute bottom-0 start-0 ms-4 translate-middle-y" style="margin-bottom: -40px;">
                            <div class="bg-white p-1 rounded-4 shadow-sm">
                                <img id="profileImage" src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Avatar" class="rounded-4 bg-light" style="width: 90px; height: 90px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 pt-5 mt-2">
                        <!-- Profile Header Info -->
                        <div class="mb-4">
                            <h2 id="display-name" class="fw-bold text-dark mb-0">Alex Thompson</h2>
                            <p class="text-primary fw-semibold">Premium Gold Member</p>
                        </div>

                        <!-- Navigation Tab Buttons -->
                        <div class="nav nav-pills nav-fill bg-light p-1 rounded-4 mb-4" id="pills-tab" role="tablist">
                            <button onclick="switchTab('details')" id="btn-details" class="nav-link active rounded-4 fw-bold py-2" type="button">
                                <i class="fa-solid fa-user-check me-2"></i>Details
                            </button>
                            <button onclick="switchTab('edit')" id="btn-edit" class="nav-link text-secondary rounded-4 fw-bold py-2" type="button">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit
                            </button>
                            <button onclick="switchTab('settings')" id="btn-settings" class="nav-link text-secondary rounded-4 fw-bold py-2" type="button">
                                <i class="fa-solid fa-gears me-2"></i>Settings
                            </button>
                        </div>

                        <!-- Details Tab Content -->
                        <div id="tab-details" class="d-block">
                            <div class="row g-4">
                                <div class="col-12 col-sm-6">
                                    <label class="small fw-bold text-uppercase text-secondary ls-wide mb-1 d-block" style="letter-spacing: 0.05em;">Email Address</label>
                                    <div id="view-email" class="text-dark fw-medium d-flex align-items-center">
                                        <i class="fa-solid fa-envelope me-3 text-muted opacity-50"></i>alex.thompson@example.com
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="small fw-bold text-uppercase text-secondary ls-wide mb-1 d-block" style="letter-spacing: 0.05em;">Contact Number</label>
                                    <div id="view-contact" class="text-dark fw-medium d-flex align-items-center">
                                        <i class="fa-solid fa-phone me-3 text-muted opacity-50"></i>+1 (555) 012-3456
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="small fw-bold text-uppercase text-secondary ls-wide mb-1 d-block" style="letter-spacing: 0.05em;">Physical Address</label>
                                    <div id="view-address" class="text-dark fw-medium d-flex align-items-center">
                                        <i class="fa-solid fa-location-dot me-3 text-muted opacity-50"></i>123 Membership Lane, Social Circle, NY 10001
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4 opacity-10">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Joined Jan 2023</span>
                                <span class="badge rounded-pill bg-success px-3 py-2 fw-bold text-uppercase" style="font-size: 0.65rem;">Active Member</span>
                            </div>
                        </div>

                        <!-- Edit Tab Content -->
                        <div id="tab-edit" class="d-none">
                            <form onsubmit="saveProfile(event)" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-secondary">Full Name</label>
                                    <input type="text" id="edit-name" value="Alex Thompson" class="form-control form-control-lg border-light bg-light rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Email</label>
                                    <input type="email" id="edit-email" value="alex.thompson@example.com" class="form-control border-light bg-light rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Contact</label>
                                    <input type="text" id="edit-contact" value="+1 (555) 012-3456" class="form-control border-light bg-light rounded-3">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-secondary">Address</label>
                                    <textarea id="edit-address" rows="2" class="form-control border-light bg-light rounded-3">123 Membership Lane, Social Circle, NY 10001</textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm rounded-3">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <!-- Settings Tab Content -->
                        <div id="tab-settings" class="d-none">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 py-3 border-0 border-bottom d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                                            <i class="fa-solid fa-bell"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold">Push Notifications</p>
                                            <p class="mb-0 small text-muted">Alerts for club events</p>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                                <div class="list-group-item px-0 py-3 border-0 border-bottom d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-3 me-3">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold">Private Profile</p>
                                            <p class="mb-0 small text-muted">Hide info from members</p>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button onclick="showAlert('Deactivation request sent.')" class="btn btn-outline-danger w-100 rounded-3 small fw-bold">Deactivate Membership</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Toast (Custom Bootstrap) -->
    <div id="custom-alert" class="position-fixed top-0 start-50 translate-middle-x mt-3 opacity-0 transition shadow-lg px-4 py-2 bg-dark text-white rounded-pill d-none" style="transition: all 0.5s ease; z-index: 1060;">
        <span id="alert-message">Message here</span>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/dist/bootstrap.bundle.min.js"></script>

    <script>
        function switchTab(tabName) {
            // Hide all tab content
            document.getElementById('tab-details').className = 'd-none';
            document.getElementById('tab-edit').className = 'd-none';
            document.getElementById('tab-settings').className = 'd-none';
            
            // Show selected
            document.getElementById('tab-' + tabName).className = 'd-block';

            // Reset all buttons
            ['details', 'edit', 'settings'].forEach(btn => {
                const el = document.getElementById('btn-' + btn);
                el.classList.remove('active', 'btn-primary');
                el.classList.add('text-secondary');
            });

            // Set active button
            const activeBtn = document.getElementById('btn-' + tabName);
            activeBtn.classList.add('active');
            activeBtn.classList.remove('text-secondary');
        }

        function saveProfile(event) {
            event.preventDefault();
            const name = document.getElementById('edit-name').value;
            const email = document.getElementById('edit-email').value;
            const contact = document.getElementById('edit-contact').value;
            const address = document.getElementById('edit-address').value;

            document.getElementById('display-name').textContent = name;
            document.getElementById('view-email').innerHTML = `<i class="fa-solid fa-envelope me-3 text-muted opacity-50"></i>${email}`;
            document.getElementById('view-contact').innerHTML = `<i class="fa-solid fa-phone me-3 text-muted opacity-50"></i>${contact}`;
            document.getElementById('view-address').innerHTML = `<i class="fa-solid fa-location-dot me-3 text-muted opacity-50"></i>${address}`;

            showAlert("Profile Updated!");
            switchTab('details');
        }

        function showAlert(msg) {
            const alertBox = document.getElementById('custom-alert');
            const message = document.getElementById('alert-message');
            message.textContent = msg;
            
            alertBox.classList.remove('d-none', 'opacity-0');
            alertBox.classList.add('opacity-100');
            
            setTimeout(() => {
                alertBox.classList.add('opacity-0');
                setTimeout(() => alertBox.classList.add('d-none'), 500);
            }, 3000);
        }
    </script>
</body>
</html>