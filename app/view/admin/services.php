<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Prestations & Soins</title>
    
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
                            500: '#D4AF37',
                            600: '#B8860B',
                            700: '#996515',
                        }
                    }
                }
            }
        }
    </script>

    <style>
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

    <header class="relative bg-cover bg-center border-b border-gold-500/20 overflow-hidden" 
            style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1600&auto=format&fit=crop');">
        
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/95 to-zinc-950/85 z-0"></div>
        <div class="absolute inset-0 bg-gold-500/5 mix-blend-overlay z-0"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block mb-1">Catalogue & Tarification</span>
                <h1 class="text-3xl font-serif text-white tracking-wide font-normal">Gestion des Soins <span class="text-gold-metallic">💆‍♂️</span></h1>
            </div>
            
            <a href="index.php?action=admin_dashboard" 
               class="bg-zinc-900/90 backdrop-blur-xl hover:bg-zinc-800/80 text-gold-300 border border-gold-500/30 px-4 py-2.5 rounded-2xl text-xs font-medium transition duration-300 shadow-2xl flex items-center gap-2">
                <span>🎛️</span> Retour Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 mt-4 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <?php $flash = get_flash(); ?>
        <?php if (!empty($flash)): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-0 mb-6">
                <div class="rounded-2xl border px-5 py-4 shadow-sm text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-100' : 'bg-rose-500/10 border-rose-500/20 text-rose-100' ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Formulaire d'Ajout de Soin -->
        <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 p-6 sm:p-8 rounded-2xl shadow-2xl h-fit">
            <div class="mb-6">
                <span class="text-gold-400 uppercase tracking-[0.2em] text-[10px] font-semibold block mb-1">Nouveau soin</span>
                <h2 class="text-2xl font-serif text-white tracking-wide font-normal">Ajouter un Soin</h2>
            </div>

            <form action="index.php?action=admin_services" method="POST" class="space-y-4">
                <?php echo csrf_input_field(); ?>
                <input type="hidden" name="add_service" value="1">
                
                <div>
                    <label class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Nom du soin</label>
                    <input type="text" name="name" required 
                           class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300"
                           placeholder="Ex: Massage Suédois">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300 leading-relaxed font-light"
                              placeholder="Description de la prestation..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Durée (min)</label>
                        <input type="number" name="duration" placeholder="60" min="1" required 
                               class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gold-300/90 mb-1.5 uppercase tracking-[0.15em]">Prix ($)</label>
                        <input type="number" step="0.01" min="0" name="price" placeholder="50" required 
                               class="w-full px-3.5 py-2.5 bg-zinc-950/80 border border-zinc-800 rounded-xl text-zinc-100 placeholder-zinc-600 focus:outline-none focus:border-gold-500/80 focus:ring-1 focus:ring-gold-500/30 text-xs transition-all duration-300">
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-gold-400/50 transition-all duration-300 shadow-[0_10px_25px_-5px_rgba(212,175,55,0.3)] cursor-pointer uppercase tracking-[0.15em] active:scale-[0.99]">
                        Enregistrer le soin
                    </button>
                </div>
            </form>
        </div>

        <!-- Tableau du Catalogue des Soins -->
        <div class="lg:col-span-2 bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl shadow-2xl overflow-hidden self-start">
            <div class="p-6 border-b border-zinc-800/80 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-serif text-white tracking-wide">Catalogue Actuel</h2>
                    <p class="text-zinc-400 text-xs font-light">Liste de toutes vos prestations enregistrées.</p>
                </div>
                <span class="bg-zinc-950/90 border border-gold-500/30 text-gold-300 px-3.5 py-1 rounded-full text-xs font-medium">
                    <?= !empty($services) ? count($services) : 0 ?> soin(s)
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-950/90 border-b border-zinc-800 text-gold-300/90 text-[10px] uppercase tracking-[0.15em]">
                            <th class="py-4 px-6">Soin</th>
                            <th class="py-4 px-6">Durée</th>
                            <th class="py-4 px-6">Prix</th>
                            <th class="py-4 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 text-sm">
                        <?php if(!empty($services)): ?>
                            <?php foreach($services as $s): ?>
                                <?php 
                                    $serviceId          = $s['id_services'] ?? $s['id'] ?? 0;
                                    $serviceName        = $s['name'] ?? 'Soin sans nom';
                                    $serviceDescription = $s['description'] ?? '';
                                    $serviceDuration    = $s['duration'] ?? 0;
                                    $servicePrice       = $s['price'] ?? 0;
                                ?>
                                <tr class="hover:bg-zinc-800/30 transition duration-150">
                                    <td class="py-4 px-6">
                                        <strong class="text-white block font-serif text-lg font-normal tracking-wide"><?= htmlspecialchars($serviceName) ?></strong>
                                        <?php if(!empty($serviceDescription)): ?>
                                            <span class="text-xs text-zinc-400 leading-relaxed font-light block mt-0.5"><?= htmlspecialchars($serviceDescription) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 text-zinc-300 whitespace-nowrap text-xs font-light">
                                        ⏱️ <?= htmlspecialchars((string)$serviceDuration) ?> min
                                    </td>
                                    <td class="py-4 px-6 text-gold-metallic font-serif font-semibold text-lg whitespace-nowrap">
                                        <?= htmlspecialchars((string)$servicePrice) ?> $
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <a href="index.php?action=admin_services&delete_id=<?= htmlspecialchars((string)$serviceId) ?>" 
                                           onclick="return confirm('Supprimer cette prestation ?')" 
                                           class="text-xs bg-rose-950/40 text-rose-300 hover:bg-rose-900/60 hover:text-white border border-rose-500/30 px-3.5 py-1.5 rounded-xl transition duration-200 inline-block font-medium">
                                            Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-10 text-center text-zinc-500 italic font-light">Aucun soin dans le catalogue.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>