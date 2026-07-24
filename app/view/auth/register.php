<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mon SPA & Serenity</title>
    
    <!-- Google Fonts Luxe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        gold: {
                            100: '#FDF8E2',
                            200: '#F9ECC1',
                            300: '#F3E5AB',
                            400: '#E6CA65',
                            500: '#D4AF37', // Or classique
                            600: '#B8860B',
                            700: '#996515',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Gradient Or Métallique Premium */
        .bg-gold-metallic {
            background: linear-gradient(135deg, #bf953f 0%, #fcf6ba 25%, #b38728 50%, #fbf5b7 75%, #aa771c 100%);
        }
        .text-gold-metallic {
            background: linear-gradient(135deg, #bf953f 0%, #fcf6ba 30%, #b38728 60%, #fbf5b7 80%, #aa771c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .border-gold-gradient {
            border-image: linear-gradient(135deg, #bf953f, #fcf6ba, #b38728) 1;
        }
    </style>
</head>
<body class="h-full bg-zinc-950 text-zinc-100 flex items-center justify-center p-0 md:p-6 font-sans antialiased selection:bg-gold-500 selection:text-zinc-950">

    <div class="w-full max-w-5xl h-full md:h-auto min-h-[680px] bg-zinc-900/90 rounded-none md:rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] overflow-hidden grid grid-cols-1 md:grid-cols-2 border border-gold-500/20 backdrop-blur-xl">
        
        <!-- SECTION GAUCHE : Visuel Immersif & Ambiance SPA -->
        <div class="relative hidden md:flex flex-col justify-between p-12 bg-cover bg-center overflow-hidden group" 
             style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1000&auto=format&fit=crop');">
            
            <!-- Masque Dégradé Obscur & Chaleureux -->
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/70 to-zinc-950/20 z-0 transition-opacity duration-700 group-hover:opacity-90"></div>
            <div class="absolute inset-0 bg-gold-500/5 mix-blend-overlay z-0"></div>

            <!-- Header Branding -->
            <div class="relative z-10 space-y-1">
                <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block">Maison de Bien-Être</span>
                <h1 class="text-3xl font-serif text-white tracking-wide font-normal">Mon SPA <span class="text-gold-metallic font-semibold">&</span> Serenity</h1>
            </div>

            <!-- Citation Luxe -->
            <div class="relative z-10 space-y-4">
                <p class="text-xl font-serif italic text-zinc-200 font-light leading-relaxed">
                    « Laissez le temps s'arrêter et plongez dans une parenthèse d'exception dédiée à vos sens. »
                </p>
                <div class="flex items-center gap-3">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-gold-400 to-transparent"></div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-gold-400/80 font-medium">Expérience Privée</span>
                </div>
            </div>
        </div>

        <!-- SECTION DROITE : Formulaire Raffiné -->
        <div class="p-8 sm:p-12 flex flex-col justify-center bg-zinc-900/80 relative">
            
            <div class="mb-6">
                <span class="text-gold-400 uppercase tracking-[0.2em] text-[11px] font-semibold block mb-1">Adhésion</span>
                <h2 class="text-3xl sm:text-4xl font-serif text-white tracking-wide font-normal">
                    Créer un compte
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-zinc-400 font-light leading-relaxed">
                    Rejoignez notre cercle privilégié pour réserver vos soins d'exception.
                </p>
            </div>

            <!-- Message d'Erreur PHP -->
            <?php if (isset($error)): ?>
                <div class="mb-5 bg-rose-950/40 border-l-2 border-rose-500 p-3.5 rounded-r-xl text-xs text-rose-200 flex items-center gap-3 shadow-inner">
                    <svg class="h-4 h-4 text-rose-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>
            
            <form class="space-y-4" action="index.php?action=register" method="POST">
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Prénom</label>
                        <input type="text" id="first_name" name="first_name" required 
                               class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                               placeholder="Jean">
                    </div>
                    <div>
                        <label for="last_name" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Nom</label>
                        <input type="text" id="last_name" name="last_name" required 
                               class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                               placeholder="Dupont">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Téléphone</label>
                    <input type="tel" id="phone" name="phone" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                           placeholder="+33 6 12 34 56 78">
                </div>

                <div>
                    <label for="email" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Adresse Email</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                           placeholder="vous@exemple.com">
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Mot de passe</label>
                    <input type="password" id="password" name="password" minlength="8" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300">
                    <span class="text-[10px] text-zinc-500 mt-1 block font-light">8 caractères minimum requis</span>
                </div>

                <div class="pt-3">
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-gold-400/50 transition-all duration-300 shadow-[0_10px_25px_-5px_rgba(212,175,55,0.3)] cursor-pointer uppercase tracking-[0.15em] active:scale-[0.99]">
                        Créer mon compte
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 mt-6 border-t border-zinc-800/80">
                <p class="text-xs text-zinc-400 font-light">
                    Vous possédez déjà un compte ? 
                    <a href="index.php?action=login" class="font-medium text-gold-300 hover:text-gold-200 underline underline-offset-4 decoration-gold-500/40 hover:decoration-gold-300 transition duration-200 ml-1">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>