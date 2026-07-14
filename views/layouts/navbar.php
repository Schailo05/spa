<!-- Navbar fixe en haut -->
<nav class="fixed top-0 left-0 w-full z-50 bg-transparent">
    <div class="max-w-7xl mx-auto flex items-center justify-between h-20 px-8">

        <!-- Logo -->
        <a href="/" class="flex-shrink-0">
            <img src="/spa/assets/images/logo/logo1.png"
                 alt="Bien-Être Salon"
                 class="h-20 w-auto">
        </a>

        <!-- Menu -->
        <ul class="hidden lg:flex items-center space-x-10 text-white text-sm tracking-wider">

            <li>
                <a href="#" class="hover:text-[#D4AF37] transition-colors duration-300">
                    Acceuil
                </a>
            </li>

            <li>
                <a href="/about" class="hover:text-[#D4AF37] transition-colors duration-300">
                    Apropos
                </a>
            </li>

            <li>
                <a href="/services" class="hover:text-[#D4AF37] transition-colors duration-300">
                    Services
                </a>
            </li>

            <li>
                <a href="/contact" class="hover:text-[#D4AF37] transition-colors duration-300">
                    Contact
                </a>
            </li>

        </ul>

        <!-- Actions -->
        <div class="hidden lg:flex items-center space-x-6">

            <a href="/cart"
               class="text-white text-lg hover:text-[#D4AF37] transition-colors duration-300">
                🛒
            </a>

            <a href="/login"
               class="border border-[#D4AF37] text-[#D4AF37] px-6 py-2 rounded-full hover:bg-[#D4AF37] hover:text-black transition-all duration-300">
                Login
            </a>

        </div>

        <!-- Mobile -->
        <button id="menu-btn"
            class="lg:hidden text-white text-3xl">
            ☰
        </button>

    </div>
</nav>