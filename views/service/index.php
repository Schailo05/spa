<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nos Services | Mon SPA & Serenity</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
}

.font-serif{
    font-family:'Cormorant Garamond',serif;
}

.service-card{
    transition:.4s ease;
}

.service-card:hover{
    transform:translateY(-8px);
}

.service-card img{
    transition:.6s ease;
}

.service-card:hover img{
    transform:scale(1.08);
}

</style>

</head>


<body class="bg-[#F8F6F3] text-[#222]">


<?php require_once __DIR__.'/../layouts/navbar.php'; ?>



<!-- TITRE -->

<section class="pt-24 pb-8">

<div class="max-w-5xl mx-auto px-6 text-center">


<p class="uppercase tracking-[6px] text-[#D4AF37] text-xs">
Mon SPA & Serenity
</p>


<h1 class="font-serif text-5xl mt-3">
Nos Services
</h1>


<p class="text-gray-500 text-sm max-w-xl mx-auto mt-3 leading-7">

Des soins personnalisés pour révéler votre beauté
et vous offrir un moment de détente absolue.

</p>


</div>

</section>




<!-- FILTRES -->


<section class="max-w-6xl mx-auto px-6">


<div class="flex justify-center gap-3 mb-10 flex-wrap">


<button 
data-filter="all"
class="filter-btn active px-6 py-2 rounded-full bg-[#D4AF37] text-white text-sm">

Tous

</button>


<button 
data-filter="Femmes"
class="filter-btn px-6 py-2 rounded-full border border-[#D4AF37] text-sm">

Femmes

</button>


<button 
data-filter="Hommes"
class="filter-btn px-6 py-2 rounded-full border border-[#D4AF37] text-sm">

Hommes

</button>


</div>





<!-- SERVICES -->


<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 pb-20">


<?php foreach($services as $service): ?>


<div 
class="service-card bg-white rounded-3xl overflow-hidden shadow-sm border border-[#D4AF37]/10"
data-category="<?= htmlspecialchars($service['categorie_nom']) ?>">



<!-- IMAGE -->


<div class="h-56 overflow-hidden">


<img
src="/spa/assets/images/spa/services/<?= htmlspecialchars($service['service_image']) ?>"
alt="<?= htmlspecialchars($service['service_nom']) ?>"
class="w-full h-full object-cover">


</div>




<!-- CONTENU -->


<div class="p-5">


<div class="flex justify-between items-center mb-3">


<span class="text-[11px] uppercase tracking-[2px] text-[#D4AF37]">

<?= htmlspecialchars($service['categorie_nom']) ?>

</span>


<span class="text-xs text-gray-400">

<?= htmlspecialchars($service['duree']) ?> min

</span>


</div>



<h2 class="font-serif text-2xl">

<?= htmlspecialchars($service['service_nom']) ?>

</h2>



<p class="text-sm text-gray-500 mt-2 leading-6">

<?= mb_strimwidth(htmlspecialchars($service['service_description']),0,90,"...") ?>

</p>




<div class="flex justify-between items-center mt-5">


<span class="text-xl font-semibold text-[#D4AF37]">

$<?= htmlspecialchars($service['prix']) ?>

</span>



<a href="index.php?action=service_details&id=<?= $service['service_id'] ?>"
class="text-sm text-[#D4AF37] hover:text-black transition">

Découvrir →

</a>


</div>


</div>


</div>


<?php endforeach; ?>


</div>


</section>




<?php require_once __DIR__.'/../layouts/footer.php'; ?>





<script>


const buttons=document.querySelectorAll(".filter-btn");

const cards=document.querySelectorAll(".service-card");



buttons.forEach(button=>{


button.addEventListener("click",()=>{


let filter=button.dataset.filter;



buttons.forEach(btn=>{

btn.classList.remove("bg-[#D4AF37]","text-white");

});



button.classList.add("bg-[#D4AF37]","text-white");



cards.forEach(card=>{


let category=card.dataset.category;



if(filter==="all" || category===filter){

card.style.display="block";

}else{

card.style.display="none";

}


});


});


});

</script>



</body>

</html>