<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Get in Touch</h2>
            <p class="text-blue-100 mt-2 text-sm">Fill out the form below to send us a message.</p>
        </div>

        <!-- Form -->
        <form   action="{{ route('editproduct',$product->id) }}" method="POST"  class="px-8 py-8 space-y-6">
             @csrf
            <!-- Field 1: Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{$product->name}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                    required
                >
            </div>

            <!-- Field 2: Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input 
                    type="number" 
                    id="email" 
                    name="stock" 
                    value="{{$product->stock}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                    required
                >
            </div>

            <!-- Field 3: Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input 
                    type="text" 
                    id="subject" 
                    name="description" 
                    value="{{$product->description}}"
                    placeholder="What is this regarding?"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"
                    required
                >
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                >
                Send Message
            </button>
        </form>

        <!-- Success Message (Hidden by default) -->
      

    <script>
        const form = document.getElementById('contactForm');
        const successMessage = document.getElementById('successMessage');
        const resetBtn = document.getElementById('resetBtn');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Simulate form submission
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            
            btn.disabled = true;
            btn.innerText = 'Sending...';
            btn.classList.add('opacity-75');

            setTimeout(() => {
                form.classList.add('hidden');
                successMessage.classList.remove('hidden');
                
                // Reset button state for next time
                btn.disabled = false;
                btn.innerText = originalText;
                btn.classList.remove('opacity-75');
            }, 800);
        });

        resetBtn.addEventListener('click', () => {
            form.reset();
            successMessage.classList.add('hidden');
            form.classList.remove('hidden');
        });
    </script>
</body>
</html>