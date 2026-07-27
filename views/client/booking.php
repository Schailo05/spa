<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Réservation | Mon SPA & Serenity</title>

<script src="https://cdn.tailwindcss.com"></script>


<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">


<style>

body{
    font-family:'Poppins',sans-serif;
}

.font-serif{
    font-family:'Cormorant Garamond',serif;
}

</style>


</head>


<body class="bg-[#F8F6F3] text-[#222]">


<?php require_once __DIR__.'/../layouts/navbar.php'; ?>



<section class="max-w-5xl mx-auto px-6 pt-28 pb-16">


<div class="text-center mb-10">


<p class="uppercase tracking-[5px] text-xs text-[#D4AF37]">
Mon Spa & Serenity
</p>


<h1 class="font-serif text-5xl mt-3">
Finaliser votre réservation
</h1>

<?php if(isset($_SESSION['booking_error'])): ?>

<div class="mt-6 bg-red-50 text-red-600 p-4 rounded-xl">

<?= $_SESSION['booking_error']; ?>

</div>


<?php unset($_SESSION['booking_error']); ?>

<?php endif; ?>

<p class="text-gray-500 mt-4">
Choisissez votre créneau, nous nous occupons de trouver le professionnel disponible.
</p>


</div>





<div class="grid lg:grid-cols-2 gap-8">





<!-- SERVICES DU PANIER -->


<div class="bg-white rounded-3xl p-7 shadow-sm">


<h2 class="font-serif text-3xl mb-6">
Vos soins
</h2>



<?php $total = 0; ?>


<?php foreach($cart as $service): ?>


<div class="flex items-center gap-4 border-b py-4">


<img
src="/spa/assets/images/spa/services/<?= htmlspecialchars($service['image']) ?>"
class="w-20 h-20 object-cover rounded-xl"
>


<div class="flex-1">


<h3 class="font-medium">
<?= htmlspecialchars($service['nom']) ?>
</h3>


<p class="text-[#D4AF37]">
$<?= htmlspecialchars($service['prix']) ?>
</p>


</div>


</div>



<?php 

$total += $service['prix'];

?>


<?php endforeach; ?>



<div class="flex justify-between mt-6 text-lg font-semibold">


<span>
Total
</span>


<span class="text-[#D4AF37]">

$<?= $total ?>

</span>


</div>



</div>







<!-- FORMULAIRE -->


<div class="bg-white rounded-3xl p-7 shadow-sm">


<h2 class="font-serif text-3xl mb-6">
Choisir un créneau
</h2>




<form action="index.php?action=save_booking" method="POST">





<div class="mb-5">


<label class="block text-sm mb-2">
Date souhaitée
</label>


<input 
type="date"
name="appointment_date"
required
class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-[#D4AF37]"
>


</div>





<div class="mb-6">


<label class="block text-sm mb-2">
Heure souhaitée
</label>


<input 
type="time"
name="appointment_time"
required
class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:border-[#D4AF37]"
>


</div>






<button
type="submit"
class="w-full bg-[#D4AF37] text-white py-4 rounded-full uppercase tracking-widest text-sm hover:bg-black transition"
>


Confirmer la demande


</button>




</form>


</div>





</div>


</section>





<?php require_once __DIR__.'/../layouts/footer.php'; ?>



</body>

</html>