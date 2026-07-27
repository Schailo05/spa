<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Suggestions de réservation | Mon SPA & Serenity</title>

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
Créneau indisponible
</h1>


<p class="text-gray-500 mt-4">
Nous avons trouvé d'autres disponibilités pour vous.
</p>


</div>





<div class="bg-white rounded-3xl shadow-sm p-8">



<h2 class="font-serif text-3xl mb-6">
Suggestions disponibles
</h2>




<?php if(!empty($suggestions)): ?>



<div class="grid md:grid-cols-3 gap-6">



<?php foreach($suggestions as $slot): ?>



<div class="border rounded-2xl p-6 hover:shadow-lg transition">



<div class="text-[#D4AF37] text-xl mb-4">
✦
</div>



<p class="text-gray-500 text-sm">
Date proposée
</p>


<h3 class="font-serif text-2xl">

<?= htmlspecialchars($slot['date']) ?>

</h3>




<p class="text-gray-500 text-sm mt-4">
Heure
</p>


<h3 class="text-xl">

<?= htmlspecialchars($slot['time']) ?>

</h3>





<?php if(isset($slot['employee_name'])): ?>

<p class="text-sm text-gray-400 mt-3">

Professionnel :
<?= htmlspecialchars($slot['employee_name']) ?>

</p>

<?php endif; ?>





<form action="index.php?action=confirm_suggestion" method="POST">


<input type="hidden"
name="date"
value="<?= htmlspecialchars($slot['date']) ?>">



<input type="hidden"
name="time"
value="<?= htmlspecialchars($slot['time']) ?>">



<input type="hidden"
name="employee_id"
value="<?= htmlspecialchars($slot['employee_id']) ?>">





<button

class="mt-6 w-full bg-[#D4AF37] text-white py-3 rounded-full hover:bg-black transition"

>

Choisir ce créneau

</button>



</form>



</div>



<?php endforeach; ?>



</div>




<?php else: ?>



<div class="text-center text-gray-400 py-10">


<p>
Aucune disponibilité trouvée pour le moment.
</p>


<a href="index.php?action=booking"

class="inline-block mt-5 text-[#D4AF37]">

Modifier la recherche

</a>


</div>



<?php endif; ?>



</div>



</section>




<?php require_once __DIR__.'/../layouts/footer.php'; ?>


</body>

</html>