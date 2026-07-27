<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Praticien - Planning</title>
    
    <!-- Google Fonts Luxe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
<body class="bg-zinc-950 text-zinc-100 min-h-screen font-sans antialiased selection:bg-gold-500 selection:text-zinc-950">

    <!-- En-tête avec fond SPA & effet luxueux -->
    <header class="relative bg-cover bg-center border-b border-gold-500/20 overflow-hidden" 
            style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1600&auto=format&fit=crop');">
        
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/95 to-zinc-950/85 z-0"></div>
        <div class="absolute inset-0 bg-gold-500/5 mix-blend-overlay z-0"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <a href="index.php?action=dashboard" 
                   class="bg-zinc-900/90 backdrop-blur-xl hover:bg-zinc-800/80 text-gold-300 border border-gold-500/30 px-4 py-2.5 rounded-2xl text-xs font-medium transition duration-300 shadow-2xl flex items-center gap-2 w-fit">
                    <span>←</span> Retour Dashboard
                </a>
                <div>
                    <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block mb-0.5">Espace Praticien</span>
                    <h1 class="text-2xl sm:text-3xl font-serif text-white tracking-wide font-normal">Mon Planning <span class="text-gold-metallic">🧑‍⚕️</span></h1>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-zinc-900/90 backdrop-blur-xl px-5 py-2.5 rounded-2xl border border-gold-500/30 shadow-2xl">
                <div class="text-xs">
                    <span class="text-zinc-400 block font-light">Praticien connecté</span>
                    <span class="font-semibold text-gold-200">
                        <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Employé') ?>
                    </span>
                </div>
                <a href="index.php?action=logout" class="bg-rose-950/40 hover:bg-rose-900/60 text-rose-200 border border-rose-500/30 px-3.5 py-2 rounded-xl text-xs font-medium transition duration-300">
                    Déconnexion
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4 sm:p-6 mt-4 space-y-6">

        <!-- Carte d'accueil / Synthèse -->
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl p-6 shadow-2xl flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <span class="text-gold-400 uppercase tracking-[0.2em] text-[10px] font-semibold block mb-1">Vue d'ensemble</span>
                <h2 class="text-2xl font-serif text-white font-normal tracking-wide">Prestations à Venir</h2>
                <p class="text-xs text-zinc-400 font-light mt-1">Retrouvez ici tous les rendez-vous qui vous ont été attribués.</p>
            </div>
            <span class="bg-zinc-950 border border-gold-500/30 text-gold-metallic font-serif text-base font-semibold px-4 py-2 rounded-full shadow-inner self-start sm:self-auto">
                <?= count($appointments ?? []) ?> Rendez-vous
            </span>
        </div>

        <!-- Liste des RDV -->
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl overflow-hidden shadow-2xl mb-12">
            <?php if (empty($appointments)): ?>
                <div class="p-12 text-center text-zinc-400">
                    <span class="text-4xl block mb-3 opacity-60">📅</span>
                    <p class="text-lg font-serif text-zinc-300 font-normal">Aucun rendez-vous planifié</p>
                    <p class="text-xs text-zinc-500 mt-1 font-light">Aucune prestation ne vous est assignée pour le moment.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-950/90 border-b border-zinc-800 text-gold-300/90 text-[10px] uppercase tracking-[0.15em]">
                                <th class="py-4 px-6">Date & Heure</th>
                                <th class="py-4 px-6">Client</th>
                                <th class="py-4 px-6">Soin</th>
                                <th class="py-4 px-6">Durée</th>
                                <th class="py-4 px-6 text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-sm">
                            <?php foreach ($appointments as $rdv): ?>
                                <tr class="hover:bg-zinc-800/30 transition duration-150">
                                    <td class="py-4 px-6 text-white font-medium whitespace-nowrap text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gold-400">📅</span>
                                            <span class="font-light tracking-wide font-mono text-gold-200"><?= date('d/m/Y à H:i', strtotime($rdv['appointment_date'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-white text-sm">
                                            <?= htmlspecialchars(($rdv['client_firstname'] ?? '') . ' ' . ($rdv['client_lastname'] ?? '')) ?>
                                        </div>
                                        <div class="text-[11px] text-zinc-400 font-mono font-light mt-0.5"><?= htmlspecialchars($rdv['client_email'] ?? '') ?></div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-gold-300 font-serif font-normal text-lg tracking-wide block">
                                            <?= htmlspecialchars($rdv['service_name'] ?? 'Soin') ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-xs text-zinc-400 font-light whitespace-nowrap">
                                        ⏱️ <?= htmlspecialchars($rdv['duration'] ?? 30) ?> min
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-medium bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                                            <?= htmlspecialchars($rdv['status'] ?? 'Confirmé') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>