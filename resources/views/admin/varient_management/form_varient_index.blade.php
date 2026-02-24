<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Member Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-active {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="max-w-2xl w-full glass-card rounded-3xl shadow-2xl overflow-hidden">
        <!-- Header / Banner -->
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
            <div class="absolute -bottom-12 left-8">
                <div class="h-24 w-24 rounded-2xl bg-white p-1 shadow-lg">
                    <img id="profileImage" src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Avatar" class="h-full w-full rounded-xl bg-slate-100 object-cover">
                </div>
            </div>
        </div>

        <div class="pt-16 px-8 pb-8">
            <!-- Basic Info Header -->
            <div class="mb-8">
                <h1 id="display-name" class="text-3xl font-bold text-slate-800">Alex Thompson</h1>
                <p class="text-blue-600 font-medium">Premium Gold Member</p>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex flex-wrap gap-2 mb-8 bg-slate-100 p-1.5 rounded-xl">
                <button onclick="switchTab('details')" id="btn-details" class="flex-1 py-2.5 px-4 rounded-lg font-semibold text-sm transition-all btn-active">
                    <i class="fa-solid fa-user-check mr-2"></i>Details
                </button>
                <button onclick="switchTab('edit')" id="btn-edit" class="flex-1 py-2.5 px-4 rounded-lg font-semibold text-sm text-slate-600 hover:bg-white hover:shadow-sm transition-all">
                    <i class="fa-solid fa-pen-to-square mr-2"></i>Edit
                </button>
                
            </div>

            <!-- Tab: View Details -->
            <div id="tab-details" class="tab-content active space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email Address</label>
                        <p id="view-email" class="text-slate-700 font-medium flex items-center">
                            <i class="fa-solid fa-envelope w-6 text-slate-400"></i>alex.thompson@example.com
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Contact Number</label>
                        <p id="view-contact" class="text-slate-700 font-medium flex items-center">
                            <i class="fa-solid fa-phone w-6 text-slate-400"></i>+1 (555) 012-3456
                        </p>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Physical Address</label>
                        <p id="view-address" class="text-slate-700 font-medium flex items-center">
                            <i class="fa-solid fa-location-dot w-6 text-slate-400"></i>123 Membership Lane, Social Circle, NY 10001
                        </p>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Member since: January 2023</span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold text-xs">ACTIVE</span>
                    </div>
                </div>
            </div>

            <!-- Tab: Edit Profile -->
            <div id="tab-edit" class="tab-content space-y-4">
                <form id="editForm" onsubmit="saveProfile(event)" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                        <input type="text" id="edit-name" value="Alex Thompson" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" id="edit-email" value="alex.thompson@example.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Contact</label>
                            <input type="text" id="edit-contact" value="+1 (555) 012-3456" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Address</label>
                        <textarea id="edit-address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">123 Membership Lane, Social Circle, NY 10001</textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition-all active:scale-[0.98]">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Tab: Settings -->
            <div id="tab-settings" class="tab-content space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg"><i class="fa-solid fa-bell"></i></div>
                            <div>
                                <p class="font-semibold text-slate-800">Notifications</p>
                                <p class="text-xs text-slate-500">Email & push alerts</p>
                            </div>
                        </div>
                        <input type="checkbox" checked class="w-10 h-5 appearance-none bg-slate-300 rounded-full checked:bg-blue-500 cursor-pointer transition-all relative after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:top-0.5 after:left-0.5 checked:after:left-5.5 after:transition-all">
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg"><i class="fa-solid fa-lock"></i></div>
                            <div>
                                <p class="font-semibold text-slate-800">Privacy Mode</p>
                                <p class="text-xs text-slate-500">Hide profile from public</p>
                            </div>
                        </div>
                        <input type="checkbox" class="w-10 h-5 appearance-none bg-slate-300 rounded-full checked:bg-blue-500 cursor-pointer transition-all relative after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:top-0.5 after:left-0.5 checked:after:left-5.5 after:transition-all">
                    </div>

                    <div class="pt-4">
                        <button onclick="showAlert('Account deactivation requested. Our team will contact you.')" class="w-full text-red-500 text-sm font-bold py-2 border border-red-100 rounded-xl hover:bg-red-50 transition-colors">
                            Deactivate Membership
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Alert (instead of browser alert) -->
        <div id="custom-alert" class="fixed inset-x-0 top-4 mx-auto w-max px-6 py-3 bg-slate-800 text-white rounded-full shadow-2xl opacity-0 transform -translate-y-12 transition-all duration-500 pointer-events-none z-50">
            <span id="alert-message">Message here</span>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Update Tab Visibility
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById('tab-' + tabName).classList.add('active');

            // Update Button Styling
            const buttons = ['details', 'edit', 'settings'];
            buttons.forEach(btn => {
                const element = document.getElementById('btn-' + btn);
                if (btn === tabName) {
                    element.classList.add('btn-active');
                    element.classList.remove('text-slate-600');
                } else {
                    element.classList.remove('btn-active');
                    element.classList.add('text-slate-600');
                }
            });
        }

        function saveProfile(event) {
            event.preventDefault();
            
            // Get values from form
            const name = document.getElementById('edit-name').value;
            const email = document.getElementById('edit-email').value;
            const contact = document.getElementById('edit-contact').value;
            const address = document.getElementById('edit-address').value;

            // Update display fields
            document.getElementById('display-name').textContent = name;
            document.getElementById('view-email').innerHTML = `<i class="fa-solid fa-envelope w-6 text-slate-400"></i>${email}`;
            document.getElementById('view-contact').innerHTML = `<i class="fa-solid fa-phone w-6 text-slate-400"></i>${contact}`;
            document.getElementById('view-address').innerHTML = `<i class="fa-solid fa-location-dot w-6 text-slate-400"></i>${address}`;

            // Show success message and go back to details
            showAlert("Profile updated successfully!");
            switchTab('details');
        }

        function showAlert(msg) {
            const alertBox = document.getElementById('custom-alert');
            const message = document.getElementById('alert-message');
            message.textContent = msg;
            alertBox.classList.remove('opacity-0', '-translate-y-12');
            alertBox.classList.add('opacity-100', 'translate-y-0');
            
            setTimeout(() => {
                alertBox.classList.add('opacity-0', '-translate-y-12');
                alertBox.classList.remove('opacity-100', 'translate-y-0');
            }, 3000);
        }
    </script>
</body>
</html>