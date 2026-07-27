<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mon SPA & Serenity</title>
    
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
    </style>
</head>
<body class="h-full bg-zinc-950 text-zinc-100 flex items-center justify-center p-0 md:p-6 font-sans antialiased selection:bg-gold-500 selection:text-zinc-950">

    <div class="w-full max-w-5xl h-full md:h-auto min-h-[620px] bg-zinc-900/90 rounded-none md:rounded-3xl shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] overflow-hidden grid grid-cols-1 md:grid-cols-2 border border-gold-500/20 backdrop-blur-xl">
        
        <!-- SECTION GAUCHE : Visuel Immersif & Ambiance SPA -->
        <div class="relative hidden md:flex flex-col justify-between p-12 bg-cover bg-center overflow-hidden group" 
             style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1000&auto=format&fit=crop');">
            
            <!-- Masque Dégradé Obscur & Chaleureux -->
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/70 to-zinc-950/20 z-0 transition-opacity duration-700 group-hover:opacity-90"></div>
            <div class="absolute inset-0 bg-gold-500/5 mix-blend-overlay z-0"></div>

            <!-- Header Branding -->
            <div class="relative z-10 space-y-1">
                <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block">Espace Privé</span>
                <h1 class="text-3xl font-serif text-white tracking-wide font-normal">Mon SPA <span class="text-gold-metallic font-semibold">&</span> Serenity</h1>
            </div>

            <!-- Citation Luxe -->
            <div class="relative z-10 space-y-4">
                <p class="text-xl font-serif italic text-zinc-200 font-light leading-relaxed">
                    « Retrouvez votre havre de paix et accédez à l'ensemble de vos soins sur mesure. »
                </p>
                <div class="flex items-center gap-3">
                    <div class="h-[1px] w-12 bg-gradient-to-r from-gold-400 to-transparent"></div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-gold-400/80 font-medium">Sérénité Garantie</span>
                </div>
            </div>
        </div>

        <!-- SECTION DROITE : Formulaire Raffiné -->
        <div class="p-8 sm:p-12 flex flex-col justify-center bg-zinc-900/80 relative">
            
            <div class="mb-8">
                <span class="text-gold-400 uppercase tracking-[0.2em] text-[11px] font-semibold block mb-1">Bon Retour</span>
                <h2 class="text-3xl sm:text-4xl font-serif text-white tracking-wide font-normal">
                    Connexion
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-zinc-400 font-light leading-relaxed">
                    Accédez à votre espace membre pour gérer vos rendez-vous.
                </p>
            </div>

            <!-- Message d'Erreur et Flash -->
            <?php $flash = get_flash(); ?>
            <?php if (!empty($flash)): ?>
                <div class="mb-6 <?= $flash['type'] === 'success' ? 'bg-emerald-950/40 border-l-2 border-emerald-500 text-emerald-200' : 'bg-rose-950/40 border-l-2 border-rose-500 text-rose-200' ?> p-3.5 rounded-r-xl text-xs flex items-center gap-3 shadow-inner">
                    <svg class="h-4 w-4 <?= $flash['type'] === 'success' ? 'text-emerald-400' : 'text-rose-400' ?> shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <?php if ($flash['type'] === 'success'): ?>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        <?php else: ?>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        <?php endif; ?>
                    </svg>
                    <p class="font-medium"><?= htmlspecialchars($flash['message']) ?></p>
                </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="mb-6 bg-rose-950/40 border-l-2 border-rose-500 p-3.5 rounded-r-xl text-xs text-rose-200 flex items-center gap-3 shadow-inner">
                    <svg class="h-4 w-4 text-rose-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium"><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>
            
            <form action="index.php?action=login" method="POST" class="space-y-5">
                <?php echo csrf_input_field(); ?>
                <div>
                    <label for="email" class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Adresse Email</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                           placeholder="exemple@domaine.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[10px] font-semibold text-gold-300/90 uppercase tracking-[0.15em]">Mot de passe</label>
                    </div>
                    <input type="password" name="password" id="password" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                           placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-gold-400/50 transition-all duration-300 shadow-[0_10px_25px_-5px_rgba(212,175,55,0.3)] cursor-pointer uppercase tracking-[0.15em] active:scale-[0.99]">
                        Se connecter
                    </button>
                </div>
            </form>

            <div class="text-center pt-6 mt-6 border-t border-zinc-800/80 space-y-2">
                <p class="text-xs text-zinc-400 font-light">
                    Pas encore de compte ?
                    <a href="index.php?action=register" class="font-medium text-gold-300 hover:text-gold-200 underline underline-offset-4 decoration-gold-500/40 hover:decoration-gold-300 transition duration-200 ml-1">
                        Inscrivez-vous
                    </a>
                </p>
                <p class="text-xs text-zinc-400 font-light">
                    <a href="index.php?action=forgot_password" class="font-medium text-gold-300 hover:text-gold-200 underline underline-offset-4 decoration-gold-500/40 hover:decoration-gold-300 transition duration-200">
                        Mot de passe oublié ?
                    </a>
                </p>
            </div>
        </div>

    </div>

</body>
</html>