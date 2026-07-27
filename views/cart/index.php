<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panier</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-[#F8F6F3]">


<?php require_once __DIR__.'/../layouts/navbar.php'; ?>



<section class="max-w-5xl mx-auto px-6 pt-28 pb-20">


<h1 class="text-4xl font-serif mb-10">

Votre panier

</h1>



<?php if(empty($services)): ?>


<p class="text-gray-500">

Votre panier est vide.

</p>


<?php else: ?>



<div class="space-y-5">


<?php foreach($services as $key=>$service): ?>


<div class="bg-white rounded-2xl p-5 flex items-center justify-between">


<div class="flex items-center gap-5">


<img 
src="/spa/assets/images/spa/services/<?= $service['image'] ?>"
class="w-24 h-24 rounded-xl object-cover">


<div>

<h3 class="text-xl font-serif">

<?= htmlspecialchars($service['nom']) ?>

</h3>


<p class="text-[#D4AF37]">

$<?= $service['prix'] ?>

</p>


</div>


</div>




<a href="index.php?action=remove_cart&id=<?= $key ?>"
class="text-red-500">

Supprimer

</a>



</div>


<?php endforeach; ?>


</div>




<div class="mt-10 text-right">


<p class="text-2xl">

Total :

<span class="text-[#D4AF37]">

$<?= $total ?>

</span>

</p>



<a href="index.php?action=booking"

class="inline-block mt-6 bg-[#D4AF37] text-white px-8 py-3 rounded-full">

Continuer la réservation

</a>


</div>



<?php endif; ?>


</section>



<?php require_once __DIR__.'/../layouts/footer.php'; ?>

<script>
localStorage.setItem(
    "cart",
    JSON.stringify(cart)
);</script>

</body>

</html>