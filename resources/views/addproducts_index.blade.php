<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar for description area */
        textarea::-webkit-scrollbar {
            width: 8px;
        }
        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        textarea::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        textarea::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Fade in animation for new items */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">

    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fa-solid fa-box-open text-indigo-600 text-xl mr-3"></i>
                    <h1 class="text-xl font-bold text-slate-800">Inventory Manager</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-sm text-slate-500 hover:text-indigo-600 transition-colors">Dashboard</button>
                    <button class="text-sm font-medium text-indigo-600">Add Product</button>
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs border border-indigo-200">
                        JD
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            
            <!-- Left Column: The Form -->
            <div class="lg:col-span-5 mb-8 lg:mb-0">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-slate-800">New Product Details</h2>
                        <span class="text-xs text-slate-500 bg-white px-2 py-1 rounded border border-slate-200">Draft</span>
                    </div>

                    <form id="productForm" action="{{route('addproducts')}}" method="POST" class="p-6 space-y-6">
                        @csrf
                        <!-- Product Name -->
                        <div>
                            <label for="productName" class="block text-sm font-medium text-slate-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-tag text-slate-400 text-sm"></i>
                                </div>
                                <input type="text" name="name" required
                                    class="pl-10 block w-full rounded-lg border-slate-300 bg-slate-50 border focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 transition-shadow shadow-sm" 
                                    placeholder="e.g. Wireless Headphones">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-cubes text-slate-400 text-sm"></i>
                                </div>
                                <input type="number" name="stock" min="0" required
                                    class="pl-10 block w-full rounded-lg border-slate-300 bg-slate-50 border focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 transition-shadow shadow-sm" 
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                            <div class="relative">
                                <textarea id="description" name="description" rows="4" 
                                    class="block w-full rounded-lg border-slate-300 bg-slate-50 border focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 transition-shadow shadow-sm resize-none" 
                                    placeholder="Enter detailed product description..."></textarea>
                                <div class="absolute bottom-2 right-2 text-xs text-slate-400">
                                    <span id="charCount">0</span>/500
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                            <button type="button" onclick="document.getElementById('productForm').reset()" class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Reset
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fa-solid fa-plus mr-2"></i> Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Recent Products List (Demo) -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 h-full flex flex-col">
                    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50 rounded-t-xl">
                        <h2 class="text-lg font-semibold text-slate-800">Recently Added</h2>
                        <div class="flex space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Live Updates
                            </span>
                        </div>
                    </div>
                    
                    <!-- Empty State -->
                    <div id="emptyState" class="flex-1 flex flex-col items-center justify-center p-10 text-center text-slate-400 min-h-[400px]">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-clipboard-list text-2xl text-slate-300"></i>
                        </div>
                        <h3 class="text-sm font-medium text-slate-900">No products yet</h3>
                        <p class="mt-1 text-sm text-slate-500">Fill out the form to add your first product.</p>
                    </div>

                    <!-- Product List Container -->
                    <div id="productList" class="hidden flex-1 overflow-y-auto p-4 space-y-3 max-h-[600px]">
                        <!-- Items will be injected here via JS -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Notification Toast -->
    <div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <div class="bg-slate-800 text-white px-6 py-3 rounded-lg shadow-lg flex items-center">
            <i class="fa-solid fa-circle-check text-green-400 mr-3"></i>
            <div>
                <h4 class="font-medium text-sm">Success</h4>
                <p class="text-xs text-slate-300">Product added to inventory.</p>
            </div>
        </div>
    </div>

    <script>
    const form = document.getElementById('productForm');
    const productList = document.getElementById('productList');
    const emptyState = document.getElementById('emptyState');
    const descInput = document.getElementById('description');
    const charCount = document.getElementById('charCount');

    // 1. INITIAL LOAD: Display existing products from Laravel
    const viewproducts = @json($viewproducts ?? []);
    
    if (viewproducts.length > 0) {
        emptyState.classList.add('hidden');
        productList.classList.remove('hidden');
        
        viewproducts.forEach(product => {
            renderProductCard(product);
        });
    }

    // 2. Helper function to render cards with Edit and Delete buttons
    function renderProductCard(product) {
        const productCard = document.createElement('div');
        productCard.className = 'bg-white p-4 rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition-shadow fade-in flex flex-col sm:flex-row gap-4';
        
        const time = product.created_at ? new Date(product.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Just now';

        productCard.innerHTML = `
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-box text-lg"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 truncate">${product.name}</h3>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="/edit_product_index/${product.id}" class="text-slate-400 hover:text-indigo-600 transition-colors p-1" title="Edit Product">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </a>
                        <form action="/deleteproduct/${product.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')" class="inline">
                            @csrf
                         @method('DELETE')
                            
                            <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-1" title="Delete Product">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mt-2 line-clamp-2">${product.description || 'No description provided.'}</p>
                <div class="mt-3 flex items-center justify-between">
                    <div class="flex items-center text-xs text-slate-500">
                        <span class="font-medium ${parseInt(product.stock) < 10 ? 'text-red-600' : 'text-green-600'}">
                            ${product.stock} in stock
                        </span>
                        <span class="mx-2">•</span>
                        <span>Added ${time}</span>
                    </div>
                </div>
            </div>
        `;
        productList.insertBefore(productCard, productList.firstChild);
    }

    // 3. Character counter
    descInput.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        this.value.length > 500 ? charCount.classList.add('text-red-500') : charCount.classList.remove('text-red-500');
    });

    // 4. Form Submission
    form.addEventListener('submit', function() {
        showToast();
    });

    function showToast() {
        const toast = document.getElementById('toast');
        toast.classList.remove('translate-y-20', 'opacity-0');
    }
</script>

</body>
</html>