<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connexion - Mon SPA & Serenity</title>


    <!-- Fonts Luxe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" 
    rel="stylesheet">



    <script src="https://cdn.tailwindcss.com"></script>


    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        serif: ['Cormorant Garamond','serif'],
                        sans: ['Plus Jakarta Sans','sans-serif']

                    },

                    colors: {

                        gold: {

                            300:'#F3E5AB',
                            400:'#E6CA65',
                            500:'#D4AF37',
                            600:'#B8860B'

                        }

                    }

                }

            }

        }


    </script>


</head>





<body class="min-h-screen bg-[#f6f5f2] flex items-center justify-center px-4 font-sans">





<div class="w-full max-w-3xl">





    <!-- CARD -->


    <div class="grid md:grid-cols-2

                bg-white

                rounded-3xl

                overflow-hidden

                border border-[#d4af37]/30

                shadow-[0_20px_50px_rgba(0,0,0,0.15)]">







        <!-- IMAGE -->

        <div class="relative hidden md:block">


            <img src="/SPA/assets/images/Spa/img001.jpg"

                 class="absolute inset-0 w-full h-full object-cover">



            <!-- sombre léger -->

            <div class="absolute inset-0 bg-black/35"></div>





            <div class="absolute bottom-8 left-7 text-white">



                <p class="uppercase tracking-[0.3em]
                          text-[10px]
                          text-[#f3e5ab]">

                    Espace Premium

                </p>




                <h2 class="font-serif text-3xl mt-3">

                    Salon-

                    <span class="text-[#d4af37]">

                       Bien-Etre

                    </span>

                    Serenity

                </h2>





                <div class="w-12 h-[1px]
                            bg-[#d4af37]
                            my-4">

                </div>





                <p class="text-sm text-gray-200 font-light">

                    Beauté & bien-être
                    <br>
                    pour elle et lui

                </p>




            </div>




        </div>









        <!-- FORMULAIRE -->


        <div class="p-7 flex flex-col justify-center">







            <!-- LOGO -->


            <div class="text-center mb-7">



                <img src="/SPA/assets/images/logo/logo1.png"

                     alt="Logo"

                     class="w-20 h-20 object-contain mx-auto">





                <h1 class="font-serif text-3xl text-black mt-3">

                    Salon-

                    <span class="text-[#d4af37]">
Bien-Etre

                    </span>

                    

                </h1>




                <div class="w-12 h-[1px]
                            bg-[#d4af37]
                            mx-auto
                            my-3">

                </div>





                <h2 class="text-xl font-semibold text-black">

                    Connexion

                </h2>




                <p class="text-xs text-gray-500 mt-2">

                    Accédez à votre espace membre

                </p>




            </div>









            <!-- ERREUR -->


            <?php if (!empty($error)): ?>

                <div class="mb-5
                            bg-red-50
                            border-l-4
                            border-red-500
                            p-3
                            rounded-r-xl
                            text-xs
                            text-red-700">

                    <?= htmlspecialchars($error) ?>

                </div>


            <?php endif; ?>









            <form action="index.php?action=login"

                  method="POST"

                  class="space-y-5">







                <!-- EMAIL -->


                <div>


                    <label class="block
                                  text-xs
                                  uppercase
                                  tracking-[0.15em]
                                  text-gray-700
                                  mb-2">

                        Adresse Email

                    </label>




                    <input

                    type="email"

                    name="email"

                    required

                    placeholder="exemple@email.com"


                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           bg-[#fafafa]
                           border border-gray-200
                           text-sm
                           text-black
                           placeholder-gray-400
                           outline-none
                           focus:border-[#d4af37]
                           transition">


                </div>









                <!-- PASSWORD -->


                <div>


                    <label class="block
                                  text-xs
                                  uppercase
                                  tracking-[0.15em]
                                  text-gray-700
                                  mb-2">

                        Mot de passe

                    </label>




                    <input

                    type="password"

                    name="password"

                    required

                    placeholder="••••••••"


                    class="w-full
                           px-4
                           py-3
                           rounded-xl
                           bg-[#fafafa]
                           border border-gray-200
                           text-sm
                           text-black
                           placeholder-gray-400
                           outline-none
                           focus:border-[#d4af37]
                           transition">


                </div>








                <div class="text-right">


                    <a href="#"

                       class="text-xs text-[#b8860b]
                              hover:text-[#d4af37]">

                        Mot de passe oublié ?

                    </a>


                </div>









                <!-- BUTTON -->


                <button type="submit"


                class="w-full
                       py-3.5
                       rounded-xl
                       bg-[#d4af37]
                       hover:bg-[#b8962e]
                       text-black
                       text-xs
                       font-semibold
                       uppercase
                       tracking-[0.15em]
                       shadow-lg
                       transition">


                    Se connecter


                </button>





            </form>









            <div class="text-center mt-6 pt-5 border-t border-gray-100">


                <p class="text-xs text-gray-500">


                    Pas encore de compte ?


                    <a href="/spa/public/index.php?action=register"

                       class="text-[#d4af37]
                              font-medium
                              hover:underline
                              ml-1">


                        Inscrivez-vous


                    </a>


                </p>


            </div>







        </div>






    </div>






</div>





</body>

</html>