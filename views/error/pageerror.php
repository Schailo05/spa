<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>404 | Bien-Être-Salon</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
}

.title{
    font-family:'Cormorant Garamond',serif;
}

</style>

</head>


<body class="bg-[#F8F6F3] text-gray-900">


<?php require_once __DIR__.'/../layouts/navbar.php'; ?>


<section class="min-h-[80vh] flex items-center justify-center text-center px-6">


<div>


<p class="text-[#D4AF37] uppercase tracking-[5px] text-sm">
Erreur
</p>


<h1 class="title text-8xl mt-4 text-gray-900">
404
</h1>


<h2 class="title text-4xl mt-4">
Cette page n'existe pas
</h2>


<p class="text-gray-500 mt-6 max-w-md mx-auto leading-7">

La page que vous recherchez semble avoir été déplacée
ou supprimée.

</p>



<a href="index.php?action=home"

class="
inline-block
mt-8
bg-[#D4AF37]
text-white
px-8
py-3
rounded-full
hover:bg-black
transition
">

Retour à l'accueil

</a>


</div>


</section>



<?php require_once __DIR__.'/../layouts/footer.php'; ?>


</body>

</html>