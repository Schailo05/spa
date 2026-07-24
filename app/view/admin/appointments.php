<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Planning & Réservations</title>
    
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
            <div>
                <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block mb-1">Gestion du Planning</span>
                <h1 class="text-3xl font-serif text-white tracking-wide font-normal">Planning & Réservations <span class="text-gold-metallic">🗓️</span></h1>
            </div>
            
            <a href="index.php?action=admin_dashboard" 
               class="bg-zinc-900/90 backdrop-blur-xl hover:bg-zinc-800/80 text-gold-300 border border-gold-500/30 px-4 py-2.5 rounded-2xl text-xs font-medium transition duration-300 shadow-2xl flex items-center gap-2">
                <span>🎛️</span> Retour Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 mt-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2">
            <div>
                <h2 class="text-2xl font-serif text-white tracking-wide font-normal">Rendez-vous clients</h2>
                <p class="text-zinc-400 text-xs font-light">Aperçu chronologique des soins réservés au SPA.</p>
            </div>
            <span class="inline-self-start bg-zinc-900/90 border border-gold-500/30 text-gold-300 px-3.5 py-1.5 rounded-full text-xs font-medium backdrop-blur-md">
                Total : <?= !empty($appointments) ? count($appointments) : 0 ?> réservation(s)
            </span>
        </div>

        <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl shadow-2xl overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-950/90 border-b border-zinc-800 text-gold-300/90 text-[10px] uppercase tracking-[0.15em]">
                            <th class="py-4 px-6">Date & Heure</th>
                            <th class="py-4 px-6">Client</th>
                            <th class="py-4 px-6">Prestation</th>
                            <th class="py-4 px-6 text-center">Statut</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 text-sm">
                        <?php if(!empty($appointments)): ?>
                            <?php foreach($appointments as $app): ?>
                                <tr class="hover:bg-zinc-800/30 transition duration-150">
                                    
                                    <!-- Date -->
                                    <td class="py-4 px-6 text-white font-medium whitespace-nowrap text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gold-400">📅</span>
                                            <span class="font-light tracking-wide"><?= date('d/m/Y à H:i', strtotime($app['appointment_date'])) ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- Client -->
                                    <td class="py-4 px-6">
                                        <span class="block text-white font-medium text-sm"><?= htmlspecialchars($app['first_name'] . ' ' . $app['last_name']) ?></span>
                                        <span class="text-xs text-zinc-400 font-mono text-[11px] font-light"><?= htmlspecialchars($app['email']) ?></span>
                                    </td>
                                    
                                    <!-- Prestation -->
                                    <td class="py-4 px-6">
                                        <span class="block text-gold-300 font-serif font-normal text-lg tracking-wide"><?= htmlspecialchars($app['service_name']) ?></span>
                                        <span class="text-xs text-zinc-400 font-light">⏱️ <?= $app['duration'] ?> min &nbsp;|&nbsp; <strong class="text-gold-metallic font-semibold"><?= $app['price'] ?> €</strong></span>
                                    </td>
                                    
                                    <!-- Statut Badge -->
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <?php if($app['status'] === 'confirme'): ?>
                                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full text-[11px] font-medium">Confirmé</span>
                                        <?php elseif($app['status'] === 'annule'): ?>
                                            <span class="bg-rose-500/10 text-rose-400 border border-rose-500/20 px-3 py-1 rounded-full text-[11px] font-medium">Annulé</span>
                                        <?php else: ?>
                                            <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1 rounded-full text-[11px] font-medium">En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Actions rapides -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <?php if($app['status'] !== 'confirme'): ?>
                                                <a href="index.php?action=admin_appointments&change_status=confirme&id=<?= $app['id_appointments'] ?>" 
                                                   class="text-xs bg-gold-metallic hover:opacity-95 text-zinc-950 font-semibold px-3.5 py-1.5 rounded-xl transition duration-200 shadow-md active:scale-95">
                                                    Accepter
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if($app['status'] !== 'annule'): ?>
                                                <a href="index.php?action=admin_appointments&change_status=annule&id=<?= $app['id_appointments'] ?>" 
                                                   class="text-xs bg-zinc-950 text-zinc-400 hover:text-rose-300 hover:bg-rose-950/40 border border-zinc-800 hover:border-rose-500/30 px-3.5 py-1.5 rounded-xl transition duration-200">
                                                    Annuler
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-10 text-center text-zinc-500 italic font-light">Aucun rendez-vous planifié pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>