<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>
    
<section class="relative min-h-[90vh] overflow-hidden">

    <!-- Video -->
    <video
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 w-full h-full object-cover">

        <source src="/spa/assets/videos/video.mp4" type="video/mp4">

    </video>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-6">

        <img
            src="/spa/assets/images/logo/logo1.png"
            alt="Bien-Être Salon"
            class="h-48 w-auto">

        <h1
            class="text-5xl lg:text-7xl font-serif text-white">

            Bienvenue chez
            <span class="text-[#D4AF37]">
                Bien-Être-Salon
            </span>

        </h1>

        <p
            class="mt-8 max-w-2xl text-gray-200 text-lg leading-8">

            Découvrez un espace dédié à votre beauté et à votre
            bien-être. Profitez de soins professionnels dans une
            ambiance élégante, apaisante et raffinée.

        </p>

        <a
            href="/reservation"
            class="mt-10 border-2 border-[#D4AF37]
                   text-[#D4AF37]
                   px-10 py-4
                   rounded-full
                   uppercase
                   tracking-widest
                   transition-all
                   duration-300
                   hover:bg-[#D4AF37]
                   hover:text-black">

            Réservez maintenant

        </a>

    </div>

</section>

<section class="pt-20 pb-16 bg-[#F8F3EC]">
    <div class="container mx-auto px-6 lg:px-16 grid lg:grid-cols-2 gap-20 items-center">

        <!-- Image -->
        <div class="lg:pr-8">
            <img 
                src="/spa/assets/images/spa/img29.jpg"
                alt="Notre institut de beauté"
                class="w-full h-[380px] object-cover rounded-xl">
        </div>


        <!-- Texte -->
        <div class="max-w-xl">

            <p class="text-[#B08D2C] uppercase tracking-[0.25em] text-sm mb-5">
                À propos de nous
            </p>


            <h2 class="text-4xl lg:text-5xl font-serif text-gray-900 leading-tight mb-6">
                Un lieu où la beauté
                <span class="text-[#B08D2C]">
                    rencontre le bien-être
                </span>
            </h2>


            <p class="text-gray-600 text-lg leading-8 mb-8">
                Bien-Être-Salon vous offre une expérience unique où chaque soin
                est pensé pour révéler votre beauté naturelle et vous offrir
                un véritable moment de relaxation.
            </p>


            <a href="/apropos"
               class="inline-block border border-[#B08D2C]
                      text-[#B08D2C]
                      px-8 py-3
                      rounded-full
                      tracking-wide
                      hover:bg-[#B08D2C]
                      hover:text-white
                      transition duration-300">
                Découvrir notre histoire
            </a>

        </div>

    </div>
</section>

   