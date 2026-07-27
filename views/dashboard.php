<!DOCTYPE html>
<html lang="fr" class="bg-[#0B0B0B]">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mon espace - Bien-Être SPA</title>

<script src="https://cdn.tailwindcss.com"></script>


<script>
tailwind.config = {

theme: {

extend: {

colors: {

gold:"#D4AF37"

},

fontFamily:{

serif:["Cormorant Garamond","serif"],

sans:["Inter","sans-serif"]

}

}

}

}
</script>


</head>



<body class="bg-[#0B0B0B] text-white min-h-screen">



<!-- HEADER -->

<header class="border-b border-[#D4AF37]/20 bg-[#111111]">


<div class="max-w-7xl mx-auto px-8 py-6 flex justify-between items-center">


<div>


<p class="text-[#D4AF37] text-xs tracking-[0.35em] uppercase">
Espace Client
</p>


<h1 class="text-3xl font-serif mt-2">
Bien-Être SPA
</h1>


</div>




<div class="flex items-center gap-6">


<div class="text-right">


<p class="text-xs text-gray-500 uppercase tracking-widest">
Bienvenue
</p>


<p class="text-[#D4AF37]">

<?= htmlspecialchars(
$_SESSION['user']['first_name'] 
?? $_SESSION['user']['email']
) ?>

</p>


</div>




<?php if(($_SESSION['user']['role'] ?? '') === 'employe'): ?>


<a href="index.php?action=staff_dashboard"

class="
px-5 py-2
border border-[#D4AF37]/40
rounded-full
text-sm
hover:bg-[#D4AF37]
hover:text-black
transition
">

Espace praticien

</a>


<?php endif; ?>





<?php if(($_SESSION['user']['role'] ?? '') === 'admin'): ?>


<a href="index.php?action=admin_dashboard"

class="
px-5 py-2
border border-[#D4AF37]/40
rounded-full
text-sm
hover:bg-[#D4AF37]
hover:text-black
transition
">

Administration

</a>


<?php endif; ?>





<a href="index.php?action=logout"

class="
px-5 py-2
rounded-full
bg-[#D4AF37]
text-black
text-sm
hover:bg-[#E6CA65]
transition
">

Déconnexion

</a>



</div>


</div>


</header>







<main class="max-w-7xl mx-auto px-8 py-12">





<!-- INTRO -->

<section>


<p class="
text-xs
uppercase
tracking-[0.3em]
text-gray-500
">

Tableau de bord

</p>



<h2 class="
text-5xl
font-serif
mt-4
">

Bonjour 
<?= htmlspecialchars($_SESSION['user']['first_name'] ?? '') ?>

</h2>



<p class="text-gray-400 mt-3">

Gérez vos rendez-vous et découvrez nos soins bien-être.

</p>


</section>








<!-- ACTIONS -->


<section class="grid md:grid-cols-3 gap-6 mt-12">





<!-- PROFIL -->


<div class="
bg-[#151515]
border border-white/10
rounded-3xl
p-7
">


<p class="
text-xs
uppercase
tracking-[0.25em]
text-[#D4AF37]
">

Mon profil

</p>



<h3 class="text-2xl font-serif mt-5">

<?= htmlspecialchars(
$_SESSION['user']['first_name'] ?? 'Client'
) ?>

</h3>



<p class="text-gray-400 text-sm mt-3">

<?= htmlspecialchars(
$_SESSION['user']['email'] ?? ''
) ?>

</p>



<div class="
mt-6
pt-4
border-t border-white/10
text-sm
text-gray-400
">

Statut :

<span class="text-[#D4AF37]">
Actif
</span>


</div>


</div>







<!-- RESERVATION -->


<div class="
bg-[#151515]
border border-[#D4AF37]/20
rounded-3xl
p-7
hover:border-[#D4AF37]/50
transition
">


<p class="
text-xs
uppercase
tracking-[0.25em]
text-[#D4AF37]
">

Réservation

</p>


<h3 class="text-2xl font-serif mt-5">

Prendre un soin

</h3>



<p class="
text-gray-400
text-sm
mt-3
">

Choisissez votre prestation et votre créneau.

</p>



<a href="index.php?action=booking"

class="
inline-block
mt-6
px-6
py-3
rounded-full
bg-[#D4AF37]
text-black
text-sm
hover:bg-[#E6CA65]
transition
">

Réserver maintenant

</a>


</div>







<!-- SERVICES -->


<div class="
bg-[#151515]
border border-white/10
rounded-3xl
p-7
">


<p class="
text-xs
uppercase
tracking-[0.25em]
text-[#D4AF37]
">

Nos soins

</p>



<h3 class="text-2xl font-serif mt-5">

Catalogue beauté

</h3>



<p class="
text-gray-400
text-sm
mt-3
">

Massages, soins visage, beauté et détente.

</p>



<a href="index.php?action=services"

class="
inline-block
mt-6
text-sm
text-[#D4AF37]
hover:underline
">

Découvrir →

</a>


</div>



</section>










<!-- RENDEZ VOUS -->


<section class="mt-14">


<div class="
flex justify-between items-center mb-6
">


<div>


<h2 class="
text-3xl
font-serif
">

Mes rendez-vous

</h2>


<p class="text-gray-500 text-sm mt-2">

Historique et prochaines réservations

</p>


</div>



<a href="index.php?action=booking"

class="
text-[#D4AF37]
text-sm
hover:underline
">

+ Nouveau rendez-vous

</a>


</div>






<div class="
bg-[#151515]
rounded-3xl
border border-white/10
overflow-hidden
">





<?php if(empty($userAppointments)): ?>



<div class="
py-16
text-center
text-gray-400
">


<p>

Vous n'avez aucun rendez-vous actuellement.

</p>



<a href="index.php?action=booking"

class="
inline-block
mt-5
px-6
py-3
rounded-full
border border-[#D4AF37]
text-[#D4AF37]
text-sm
">

Réserver mon premier soin

</a>


</div>





<?php else: ?>



<table class="w-full text-left">


<thead class="bg-[#111111] text-[#D4AF37] text-xs uppercase">


<tr>

<th class="p-5">
Date
</th>


<th class="p-5">
Service
</th>


<th class="p-5">
Praticien
</th>


<th class="p-5">
Prix
</th>


<th class="p-5">
Statut
</th>


</tr>


</thead>



<tbody>


<?php foreach($userAppointments as $rdv): ?>


<tr class="border-t border-white/10 hover:bg-white/5 transition">


<td class="p-5 text-gray-300">

<?= date(
'd/m/Y H:i',
strtotime($rdv['appointment_date'])
) ?>

</td>



<td class="p-5">

<?= htmlspecialchars(
$rdv['service_name'] ?? 'Soin'
) ?>

</td>



<td class="p-5 text-gray-400">

<?= htmlspecialchars(
($rdv['staff_firstname'] ?? '')
.' '.
($rdv['staff_lastname'] ?? '')
) ?>

</td>



<td class="p-5">

<?= htmlspecialchars(
$rdv['price'] ?? '-'
) ?> €

</td>




<td class="p-5">


<span class="
px-4
py-1.5
rounded-full
text-xs
border
border-[#D4AF37]/40
text-[#D4AF37]
">

<?= htmlspecialchars(
$rdv['status'] ?? 'Confirmé'
) ?>


</span>


</td>


</tr>



<?php endforeach; ?>


</tbody>


</table>



<?php endif; ?>




</div>


</section>






</main>




</body>

</html>