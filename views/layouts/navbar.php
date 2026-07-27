<?php

$action = $_GET['action'] ?? 'home';

$isHero = in_array($action, ['home','about']);


$cartCount = 0;

if(isset($_SESSION['cart'])){

    $cartCount = count($_SESSION['cart']);

}

?>

<nav class="
<?= $isHero
? 'absolute bg-transparent text-white'
: 'fixed bg-[#111111] text-white shadow-lg border-b border-[#D4AF37]/30'
?>
top-0 left-0 w-full z-50 transition duration-300
">


<div class="max-w-7xl mx-auto flex items-center justify-between h-20 px-5 md:px-8">


<!-- LOGO -->

<a href="/spa/public/index.php?action=home">

<img 
src="/SPA/assets/images/logo/logo1.png"
alt="Salon-Bien-Être"
class="h-14 md:h-16 w-auto object-contain"
/>

</a>





<!-- MENU DESKTOP -->

<ul class="
hidden lg:flex items-center gap-10 
text-sm tracking-[0.18em] uppercase
text-white
">


<li>
<a href="/spa/public/index.php?action=home"
class="hover:text-[#D4AF37] transition">

Accueil

</a>
</li>


<li>
<a href="/spa/public/index.php?action=about"
class="hover:text-[#D4AF37] transition">

À propos

</a>
</li>


<li>
<a href="/spa/public/index.php?action=services"
class="hover:text-[#D4AF37] transition">

Services

</a>
</li>


<li>
<a href="/spa/public/index.php?action=contact"
class="hover:text-[#D4AF37] transition">

Contact

</a>
</li>


</ul>






<!-- ACTIONS -->

<div class="hidden lg:flex items-center gap-7">


<a href="/spa/public/index.php?action=cart"
class="relative text-xl hover:text-[#D4AF37] transition">

🛒

<?php if($cartCount > 0): ?>

<span
class="
absolute -top-3 -right-3
bg-[#D4AF37]
text-black
text-xs
w-5 h-5
rounded-full
flex items-center justify-center
font-semibold
">

<?= $cartCount ?>

</span>

<?php endif; ?>

</a>



<a href="/spa/public/index.php?action=login"

class="
px-7 py-2.5
rounded-full
border border-[#D4AF37]
text-sm
tracking-wider
hover:bg-[#D4AF37]
hover:text-black
transition
">

Mon profil

</a>


</div>





<!-- MOBILE -->

<button 
id="menu-btn"
class="lg:hidden text-3xl">

☰

</button>


</div>


</nav>