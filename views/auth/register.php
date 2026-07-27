<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Créer un compte</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="min-h-screen bg-[#f7f6f3] flex items-center justify-center px-4">


<div class="w-full max-w-2xl">


    <!-- CARD -->
    <div class="bg-[#fcfbf8] rounded-3xl shadow-xl overflow-hidden
                border border-[#d4af37]/25
                grid md:grid-cols-5">





        <!-- IMAGE -->

        <div class="md:col-span-2 relative h-44 md:h-auto">


            <img src="/SPA/assets/images/Spa/img001.jpg"
                 class="absolute inset-0 w-full h-full object-cover">



            <div class="absolute inset-0 bg-black/35"></div>




            <div class="absolute bottom-5 left-5 text-white">


                <h2 class="text-lg font-light leading-relaxed">

                    L'excellence
                    <br>
                    du bien-être

                </h2>



                <div class="w-10 h-[1px] bg-[#d4af37] my-2"></div>



                <p class="text-xs text-gray-200">

                    Soins & beauté
                    <br>
                    pour elle et lui

                </p>


            </div>


        </div>








        <!-- FORMULAIRE -->


        <div class="md:col-span-3 p-6">






            <!-- LOGO -->

            <div class="text-center mb-4">


                <img src="/SPA/assets/images/logo/logo1.png"

                     alt="Logo"

                     class="w-12 h-12 object-contain mx-auto mb-3">





                <h1 class="text-xl font-semibold text-black">

                    Créer un compte

                </h1>





                <p class="text-xs text-gray-500 mt-1">

                    Réservez vos rendez-vous facilement

                </p>


            </div>









            <form action="/register" method="POST"
                  class="space-y-3">







                <!-- NOM -->

                <div>

                    <label class="text-xs text-gray-700">
                        Nom complet
                    </label>


                    <input 
                    type="text"
                    name="nom"
                    placeholder="Votre nom"
                    required

                    class="mt-1 w-full px-3 py-2
                           rounded-lg
                           bg-white
                           border border-gray-200
                           text-sm
                           outline-none
                           focus:border-[#d4af37]
                           transition">

                </div>







                <!-- EMAIL -->

                <div>

                    <label class="text-xs text-gray-700">
                        Email
                    </label>


                    <input 
                    type="email"
                    name="email"
                    placeholder="Votre email"
                    required

                    class="mt-1 w-full px-3 py-2
                           rounded-lg
                           bg-white
                           border border-gray-200
                           text-sm
                           outline-none
                           focus:border-[#d4af37]
                           transition">

                </div>







                <!-- TELEPHONE -->

                <div>

                    <label class="text-xs text-gray-700">
                        Téléphone
                    </label>


                    <input 
                    type="tel"
                    name="telephone"
                    placeholder="+509 ..."

                    class="mt-1 w-full px-3 py-2
                           rounded-lg
                           bg-white
                           border border-gray-200
                           text-sm
                           outline-none
                           focus:border-[#d4af37]
                           transition">

                </div>








                <!-- PASSWORD -->

                <div>

                    <label class="text-xs text-gray-700">
                        Mot de passe
                    </label>


                    <input 
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required

                    class="mt-1 w-full px-3 py-2
                           rounded-lg
                           bg-white
                           border border-gray-200
                           text-sm
                           outline-none
                           focus:border-[#d4af37]
                           transition">

                </div>







                <!-- CONFIRM -->

                <div>

                    <label class="text-xs text-gray-700">
                        Confirmer le mot de passe
                    </label>


                    <input 
                    type="password"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required

                    class="mt-1 w-full px-3 py-2
                           rounded-lg
                           bg-white
                           border border-gray-200
                           text-sm
                           outline-none
                           focus:border-[#d4af37]
                           transition">

                </div>








                <!-- BUTTON -->

                <button type="submit"

                class="w-full mt-3
                       bg-[#d4af37]
                       hover:bg-[#b8962e]
                       text-black
                       py-2.5
                       rounded-xl
                       text-sm
                       font-semibold
                       transition
                       shadow-md">


                    Créer mon compte


                </button>





            </form>








            <p class="text-center text-xs text-gray-500 mt-4">


                Vous avez déjà un compte ?

                <a href="/SPA/app/views/auth/login.php"
                   class="text-[#d4af37] hover:underline">

                    Se connecter

                </a>


            </p>





        </div>



    </div>



</div>


</body>

</html>