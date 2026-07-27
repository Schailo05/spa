<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

    
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
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-6 pt-16">

        <img
            src="/spa/assets/images/logo/logo1.png"
            alt="Bien-Être Salon"
            class="h-48 w-auto">

        <h1
            class="text-4xl lg:text-6xl font-serif text-white max-w-4xl leading-tight ">

            Bienvenue chez
            <span class="text-[#D4AF37]">
                Bien-Être-Salon
            </span>

        </h1>

        <p
            class="mt-6 max-w-xl text-gray-200 text-base lg:text-lg leading-7">

            Découvrez un espace dédié à votre beauté et à votre
            bien-être. Profitez de soins professionnels dans une
            ambiance élégante, apaisante et raffinée.

        </p>

        <a href="index.php?action=booking"
            class="mt-8 border-2 border-[#D4AF37]
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

            <p class="text-[#D4AF37] uppercase tracking-[0.25em] text-sm mb-5">
                À propos de nous
            </p>


            <h2 class="text-4xl lg:text-5xl font-serif text-gray-900 leading-tight mb-6">
                Un lieu où la beauté
                <span class="text-[#D4AF37]">
                    rencontre le bien-être
                </span>
            </h2>


            <p class="text-gray-600 text-lg leading-8 mb-8">
                Bien-Être-Salon vous offre une expérience unique où chaque soin
                est pensé pour révéler votre beauté naturelle et vous offrir
                un véritable moment de relaxation.
            </p>


            <a href="index.php?action=about"
               class="inline-block border border-[#D4AF37]
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

<section class="pt-6 pb-14 bg-[#F8F3EC]">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Titre -->
        <div class="text-center mb-8">

            <p class="text-[#B08D2C] uppercase tracking-[0.3em] text-xs mb-3">
                Nos services
            </p>

            <h2 class="text-3xl lg:text-4xl font-serif text-gray-900">
                Des soins adaptés à chacun
            </h2>

        </div>


        <!-- Cartes -->
        <div class="grid md:grid-cols-2 gap-8">


            <!-- Femmes -->
            <a href="index.php?action=services&categorie=Femmes"
               class="group relative h-[320px] overflow-hidden rounded-xl">

                <img
                    src="/spa/assets/images/spa/img50.jfif"
                    alt="Services femmes"
                    class="w-full h-full object-cover 
                           transition duration-700
                           group-hover:scale-105">


                <div class="absolute inset-0 bg-black/40 
                            group-hover:bg-black/30 
                            transition">
                </div>


                <div class="absolute inset-0 flex flex-col 
                            justify-end p-6 text-white">


                    <h3 class="text-3xl font-serif mb-3">
                        Beauté Femme
                    </h3>


                    <p class="text-gray-200 text-sm max-w-xs mb-5">
                        Soins du visage, coiffure, onglerie
                        et moments de détente.
                    </p>


                    <span class="border border-[#D4AF37]
                                 text-[#D4AF37]
                                 w-fit
                                 px-5 py-2
                                 rounded-full
                                 text-sm
                                 group-hover:bg-[#D4AF37]
                                 group-hover:text-black
                                 transition">

                        Découvrir

                    </span>


                </div>

            </a>



            <!-- Hommes -->
            <a href="index.php?action=services&categorie=Hommes"
               class="group relative h-[320px] overflow-hidden rounded-xl">

                <img
                    src="/spa/assets/images/spa/img313.jpg"
                    alt="Services hommes"
                    class="w-full h-full object-cover
                           transition duration-700
                           group-hover:scale-105">


                <div class="absolute inset-0 bg-black/40
                            group-hover:bg-black/30
                            transition">
                </div>


                <div class="absolute inset-0 flex flex-col
                            justify-end p-6 text-white">


                    <h3 class="text-3xl font-serif mb-3">
                        Élégance Homme
                    </h3>


                    <p class="text-gray-200 text-sm max-w-xs mb-5">
                        Coupe, barbe, soins visage
                        et prestations personnalisées.
                    </p>


                    <span class="border border-[#D4AF37]
                                 text-[#D4AF37]
                                 w-fit
                                 px-5 py-2
                                 rounded-full
                                 text-sm
                                 group-hover:bg-[#D4AF37]
                                 group-hover:text-black
                                 transition">

                        Découvrir

                    </span>


                </div>

            </a>


        </div>

    </div>

</section>
   
<section class="py-12 bg-[#F8F3EC]">

    <div class="max-w-5xl mx-auto px-6">

        <!-- Titre -->
        <div class="text-center mb-8">

            <p class="text-[#B08D2C] uppercase tracking-[0.3em] text-xs mb-3">
                Témoignages
            </p>

            <h2 class="text-3xl font-serif text-gray-900">
                Ce que nos clients disent
            </h2>

        </div>


        <!-- Carousel -->
        <div class="relative overflow-hidden">

            <div id="testimonialContainer"
                 class="flex transition-transform duration-500">


                <!-- Avis 1 -->
                <div class="min-w-full flex justify-center">

                    <div class="bg-white shadow-sm rounded-xl p-8 
                                max-w-xl text-center">

                        <div class="text-[#D4AF37] text-xl mb-4">
                            ★★★★★
                        </div>

                        <p class="text-gray-600 leading-7 italic">
                            "Une expérience magnifique. Le personnel est
                            accueillant et les soins sont réalisés avec
                            beaucoup de professionnalisme."
                        </p>

                        <h4 class="mt-5 font-serif text-gray-900">
                            Marie D.
                        </h4>

                    </div>

                </div>



                <!-- Avis 2 -->
                <div class="min-w-full flex justify-center">

                    <div class="bg-white shadow-sm rounded-xl p-8 
                                max-w-xl text-center">

                        <div class="text-[#D4AF37] text-xl mb-4">
                            ★★★★★
                        </div>

                        <p class="text-gray-600 leading-7 italic">
                            "Un endroit chaleureux et élégant.
                            Je recommande vivement leurs prestations."
                        </p>

                        <h4 class="mt-5 font-serif text-gray-900">
                            Sophie M.
                        </h4>

                    </div>

                </div>



                <!-- Avis 3 -->
                <div class="min-w-full flex justify-center">

                    <div class="bg-white shadow-sm rounded-xl p-8 
                                max-w-xl text-center">

                        <div class="text-[#D4AF37] text-xl mb-4">
                            ★★★★★
                        </div>

                        <p class="text-gray-600 leading-7 italic">
                            "Une vraie pause bien-être.
                            L'équipe est attentive et professionnelle."
                        </p>

                        <h4 class="mt-5 font-serif text-gray-900">
                            Jean P.
                        </h4>

                    </div>

                </div>


            </div>


            <!-- Boutons -->
            <button id="prevBtn"
    class="absolute left-2 top-1/2 -translate-y-1/2
           text-[#B08D2C] text-2xl">
    ‹
</button>


            <button id="nextBtn"
    class="absolute right-2 top-1/2 -translate-y-1/2
           text-[#B08D2C] text-2xl">
    ›
</button>


        </div>

    </div>

</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>