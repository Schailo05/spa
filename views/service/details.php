<?php
/** @var array $service */
/** @var array $avis */
/** @var array $servicesSimilaires */
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($service['nom']) ?> | Mon SPA & Serenity</title>

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



<section class="max-w-6xl mx-auto px-6 pt-28 pb-16">


<div class="grid lg:grid-cols-2 gap-10 items-center">



<!-- IMAGE -->


<div class="rounded-3xl overflow-hidden">

<img
src="/spa/assets/images/spa/services/<?= htmlspecialchars($service['image']) ?>"
alt="<?= htmlspecialchars($service['nom']) ?>"
class="w-full h-[430px] object-cover">


</div>





<!-- INFORMATIONS -->


<div>


<p class="uppercase tracking-[4px] text-xs text-[#D4AF37]">

<?= htmlspecialchars($service['categorie_nom']) ?>

</p>



<h1 class="font-serif text-5xl mt-3">

<?= htmlspecialchars($service['nom']) ?>

</h1>



<div class="flex items-center gap-2 mt-4 text-[#D4AF37]">

★★★★★

<span class="text-gray-400 text-sm">

(<?= isset($avis) ? count($avis) : 0 ?> avis)

</span>

</div>




<p class="text-gray-500 leading-7 mt-6">

<?= nl2br(htmlspecialchars($service['description'])) ?>

</p>




<div class="flex gap-12 mt-8">


<div>

<p class="uppercase text-xs tracking-widest text-gray-400">
Durée
</p>

<p class="text-xl mt-1">
<?= htmlspecialchars($service['duree']) ?> min
</p>

</div>



<div>

<p class="uppercase text-xs tracking-widest text-gray-400">
Prix
</p>

<p class="text-2xl text-[#D4AF37] font-semibold">
$<?= htmlspecialchars($service['prix']) ?>
</p>

</div>


</div>




<form action="index.php?action=add_cart" method="POST">


<input type="hidden" name="service_id"
value="<?= $service['id'] ?>">


<input type="hidden" name="nom"
value="<?= htmlspecialchars($service['nom']) ?>">


<input type="hidden" name="prix"
value="<?= $service['prix'] ?>">


<input type="hidden" name="image"
value="<?= htmlspecialchars($service['image']) ?>">



<button class="bg-[#D4AF37] text-white px-8 py-3 rounded-full  hover:bg-black transition">

Ajouter au panier

</button>


</form>


</div>


</div>


</section>


<!-- AVIS -->


<section class="bg-white py-12">


<div class="max-w-6xl mx-auto px-6">


<h2 class="font-serif text-4xl mb-8">

Avis clients

</h2>



<div class="grid md:grid-cols-3 gap-5">


<?php if(!empty($avis)): ?>


<?php foreach($avis as $review): ?>


<div class="border border-gray-100 rounded-2xl p-5">


<div class="text-[#D4AF37]">

<?= str_repeat("★", $review['note']) ?>

</div>



<p class="text-gray-500 text-sm mt-3">

<?= htmlspecialchars($review['commentaire']) ?>

</p>



<p class="mt-4 font-medium">

<?= htmlspecialchars($review['nom']) ?>

</p>


</div>


<?php endforeach; ?>


<?php else: ?>


<p class="text-gray-400">

Aucun avis pour le moment.

</p>


<?php endif; ?>


</div>


</div>


</section>


<!-- SERVICES SIMILAIRES -->


<section class="max-w-6xl mx-auto px-6 py-14">


<h2 class="font-serif text-4xl mb-2">
Découvrez nos autres soins
</h2>

<p class="text-gray-500 mb-8">
Des prestations sélectionnées pour prolonger votre expérience bien-être.
</p>

<div class="grid md:grid-cols-3 gap-6">


<?php if(!empty($servicesSimilaires)): ?>


<?php foreach($servicesSimilaires as $item): ?>


<a href="index.php?action=service_details&id=<?= $item['id'] ?>"
class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">


<img
src="/spa/assets/images/spa/services/<?= htmlspecialchars($item['image']) ?>"
class="h-48 w-full object-cover">


<div class="p-4">

<h3 class="font-serif text-2xl">

<?= htmlspecialchars($item['nom']) ?>

</h3>


<p class="text-[#D4AF37] mt-2">

$<?= htmlspecialchars($item['prix']) ?>

</p>


</div>


</a>


<?php endforeach; ?>


<?php endif; ?>


</div>


</section>




<?php require_once __DIR__.'/../layouts/footer.php'; ?>





<?php foreach($avis as $review): ?>

<div>

<div class="text-[#D4AF37]">
<?= str_repeat("★", $review['note']) ?>
</div>

<p>
<?= htmlspecialchars($review['commentaire']) ?>
</p>

<span>
<?= htmlspecialchars($review['nom']) ?>
</span>

</div>

<?php endforeach; ?>

</body>

</html>