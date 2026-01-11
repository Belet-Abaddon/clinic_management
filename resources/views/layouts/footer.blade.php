<footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-1">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-2">
                        <span class="font-bold text-white">M</span>
                    </div>
                    <span class="font-bold text-xl tracking-tight">MedCLINIC</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Connecting patients with top-tier healthcare providers through simple, efficient scheduling.
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-blue-400 mb-4">Navigation</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/" class="hover:text-white transition">Home</a></li>
                    @auth
                        <li><a href="/dashboard" class="hover:text-white transition">My Dashboard</a></li>
                        <li><a href="/appointments" class="hover:text-white transition">My Appointments</a></li>
                    @else
                        <li><a href="/login" class="hover:text-white transition">Login</a></li>
                        <li><a href="/register" class="hover:text-white transition">Create Account</a></li>
                    @endauth
                </ul>
            </div>
            
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-blue-400 mb-4">Support</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/#about" class="hover:text-white">About the Clinic</a></li>
                    <li><a href="/#contact" class="hover:text-white">Contact Us</a></li>
                    <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-blue-400 mb-4">Clinic Hours</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li class="flex justify-between"><span>Mon - Fri</span> <span class="text-white font-medium">8:00 - 20:00</span></li>
                    <li class="flex justify-between"><span>Saturday</span> <span class="text-white font-medium">9:00 - 18:00</span></li>
                    <li class="flex justify-between"><span>Sunday</span> <span class="text-white font-medium text-red-400">Closed</span></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 text-xs">
            <p>&copy; {{ date('Y') }} MedCLINIC Health Systems. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-white"><i class="ri-facebook-fill text-lg"></i></a>
                <a href="#" class="hover:text-white"><i class="ri-twitter-fill text-lg"></i></a>
                <a href="#" class="hover:text-white"><i class="ri-instagram-line text-lg"></i></a>
            </div>
        </div>
    </div>
</footer>