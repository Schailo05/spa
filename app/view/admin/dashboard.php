<!DOCTYPE html>
<html lang="fr" class="h-full bg-zinc-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard Global & Utilisateurs</title>
    
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

    <!-- Header avec visuel immersif SPA & Filtre Luxueux -->
    <header class="relative bg-cover bg-center border-b border-gold-500/20 overflow-hidden" 
            style="background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=1600&auto=format&fit=crop');">
        
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/95 to-zinc-950/85 z-0"></div>
        <div class="absolute inset-0 bg-gold-500/5 mix-blend-overlay z-0"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="text-gold-300 uppercase tracking-[0.25em] text-[10px] font-semibold block mb-1">Console Administrateur</span>
                <h1 class="text-3xl font-serif text-white tracking-wide font-normal">Mon SPA <span class="text-gold-metallic font-semibold">&</span> Serenity ⚙️</h1>
            </div>
            
            <div class="flex items-center gap-4 bg-zinc-900/90 backdrop-blur-xl px-5 py-2.5 rounded-2xl border border-gold-500/30 shadow-2xl">
                <div class="text-xs">
                    <span class="text-zinc-400 block font-light">Connecté en tant que</span>
                    <span class="font-semibold text-gold-200">
                        <?= htmlspecialchars($_SESSION['user']['first_name'] ?? 'Admin') ?> <span class="text-gold-400 font-normal">👑 (Admin)</span>
                    </span>
                </div>
                <a href="index.php?action=logout" class="bg-rose-950/40 hover:bg-rose-900/60 text-rose-200 border border-rose-500/30 px-3.5 py-2 rounded-xl text-xs font-medium transition-all duration-300">
                    Déconnexion
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 mt-4 space-y-10">
        <?php $flash = get_flash(); ?>
        <?php if (!empty($flash)): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-0">
                <div class="rounded-2xl border px-5 py-4 shadow-sm text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-100' : 'bg-rose-500/10 border-rose-500/20 text-rose-100' ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- 📊 SECTION 1 : CHIFFRES CLÉS -->
        <div>
            <span class="text-gold-400 uppercase tracking-[0.2em] text-[11px] font-semibold block mb-3">Vue d'ensemble du système</span>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Catalogue -->
                <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl p-6 shadow-2xl flex justify-between items-center relative overflow-hidden group hover:border-gold-500/50 transition duration-300">
                    <div class="space-y-1">
                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-[0.15em]">Catalogue de Soins</p>
                        <p class="text-4xl font-serif text-gold-metallic font-bold"><?= $totalServices ?></p>
                        <p class="text-[11px] text-zinc-500 font-light">Prestations (Option A)</p>
                    </div>
                    <div class="p-4 bg-zinc-950 border border-gold-500/30 text-gold-300 rounded-2xl text-2xl shadow-inner group-hover:scale-110 transition duration-300">✂️</div>
                </div>

                <!-- Rendez-vous -->
                <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl p-6 shadow-2xl flex justify-between items-center relative overflow-hidden group hover:border-gold-500/50 transition duration-300">
                    <div class="space-y-1">
                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-[0.15em]">Réservations Clients</p>
                        <p class="text-4xl font-serif text-gold-metallic font-bold"><?= $totalAppointments ?></p>
                        <p class="text-[11px] text-zinc-500 font-light">Plannings (Option B)</p>
                    </div>
                    <div class="p-4 bg-zinc-950 border border-gold-500/30 text-gold-300 rounded-2xl text-2xl shadow-inner group-hover:scale-110 transition duration-300">📅</div>
                </div>

                <!-- Employés -->
                <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl p-6 shadow-2xl flex justify-between items-center relative overflow-hidden group hover:border-gold-500/50 transition duration-300">
                    <div class="space-y-1">
                        <p class="text-[10px] font-semibold text-zinc-400 uppercase tracking-[0.15em]">Équipe & Spécialités</p>
                        <p class="text-4xl font-serif text-gold-metallic font-bold"><?= $totalEmployees ?></p>
                        <p class="text-[11px] text-zinc-500 font-light">Membres du staff (Option C)</p>
                    </div>
                    <div class="p-4 bg-zinc-950 border border-gold-500/30 text-gold-300 rounded-2xl text-2xl shadow-inner group-hover:scale-110 transition duration-300">🧑‍⚕️</div>
                </div>

            </div>
        </div>

        <!-- 🔗 SECTION 2 : ACCÈS RAPIDE AUX MODULES -->
        <div>
            <span class="text-gold-400 uppercase tracking-[0.2em] text-[11px] font-semibold block mb-3">Actions de configuration</span>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-gold-500/40 transition duration-300 shadow-xl">
                    <div>
                        <h3 class="font-serif text-white text-lg"><span class="text-gold-300">Option A :</span> Catalogue des Soins</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed font-light">Ajoutez, modifiez ou supprimez les massages et prestations proposés.</p>
                    </div>
                    <a href="index.php?action=admin_services" 
                       class="mt-6 text-center text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 py-3 px-4 rounded-xl transition duration-300 uppercase tracking-[0.15em] shadow-lg shadow-gold-500/10 active:scale-[0.99]">
                        Ouvrir le Catalogue →
                    </a>
                </div>

                <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-gold-500/40 transition duration-300 shadow-xl">
                    <div>
                        <h3 class="font-serif text-white text-lg"><span class="text-gold-300">Option B :</span> Planning Global</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed font-light">Visualisez les créneaux et changez le statut des rendez-vous clients.</p>
                    </div>
                    <a href="index.php?action=admin_appointments" 
                       class="mt-6 text-center text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 py-3 px-4 rounded-xl transition duration-300 uppercase tracking-[0.15em] shadow-lg shadow-gold-500/10 active:scale-[0.99]">
                        Ouvrir le Planning →
                    </a>
                </div>

                <div class="bg-zinc-900/80 backdrop-blur-xl border border-zinc-800 rounded-2xl p-6 flex flex-col justify-between hover:border-gold-500/40 transition duration-300 shadow-xl">
                    <div>
                        <h3 class="font-serif text-white text-lg"><span class="text-gold-300">Option C :</span> Affectation des Soins</h3>
                        <p class="text-xs text-zinc-400 mt-2 leading-relaxed font-light">Cochez les soins et compétences pour chaque membre de l'équipe.</p>
                    </div>
                    <a href="index.php?action=admin_staff" 
                       class="mt-6 text-center text-xs font-semibold text-zinc-950 bg-gold-metallic hover:opacity-95 py-3 px-4 rounded-xl transition duration-300 uppercase tracking-[0.15em] shadow-lg shadow-gold-500/10 active:scale-[0.99]">
                        Gérer l'Équipe →
                    </a>
                </div>

            </div>
        </div>

        <!-- 👥 SECTION 3 : TABLEAU DE GESTION DES UTILISATEURS -->
        <div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 gap-2">
                <div>
                    <h2 class="text-2xl font-serif text-white tracking-wide">Gestion des Rôles & Comptes</h2>
                    <p class="text-zinc-400 text-xs font-light">Modifiez les rôles et gérez les accès du personnel et des clients.</p>
                </div>
                <span class="inline-self-start bg-zinc-900/90 border border-gold-500/30 text-gold-300 px-3.5 py-1.5 rounded-full text-xs font-medium backdrop-blur-md">
                    Total : <?= isset($users) ? count($users) : 0 ?> inscrit(s)
                </span>
            </div>

            <div class="bg-zinc-900/80 backdrop-blur-xl border border-gold-500/20 rounded-2xl shadow-2xl overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-zinc-950/90 border-b border-zinc-800 text-gold-300/90 text-[10px] uppercase tracking-[0.15em]">
                                <th class="py-4 px-6">Nom / Prénom</th>
                                <th class="py-4 px-6">Email</th>
                                <th class="py-4 px-6">Téléphone</th>
                                <th class="py-4 px-6">Rôle Actuel</th>
                                <th class="py-4 px-6 text-center">Statut</th>
                                <th class="py-4 px-6 text-center">Actions de mise à jour</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800/60 text-sm">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $u): 
                                    $fname = $u['first_name'] ?? $u['firstname'] ?? 'Utilisateur';
                                    $lname = $u['last_name'] ?? $u['lastname'] ?? '';
                                ?>
                                    <tr class="hover:bg-zinc-800/30 transition duration-150">
                                        
                                        <td class="py-4 px-6 font-medium text-white">
                                            <?= htmlspecialchars($fname . ' ' . $lname) ?>
                                        </td>
                                        
                                        <td class="py-4 px-6 text-zinc-400 font-mono text-xs">
                                            <?= htmlspecialchars($u['email'] ?? '') ?>
                                        </td>
                                        
                                        <td class="py-4 px-6 text-zinc-400 text-xs font-light">
                                            <?= htmlspecialchars($u['phone'] ?? 'Non renseigné') ?>
                                        </td>
                                        
                                        <td class="py-4 px-6">
                                            <?php if (($u['role'] ?? '') === 'admin'): ?>
                                                <span class="bg-gold-500/10 text-gold-300 border border-gold-500/30 px-2.5 py-1 rounded-lg text-xs font-medium">Admin</span>
                                            <?php elseif (($u['role'] ?? '') === 'employe'): ?>
                                                <span class="bg-sky-500/10 text-sky-400 border border-sky-500/20 px-2.5 py-1 rounded-lg text-xs font-medium">Staff</span>
                                            <?php else: ?>
                                                <span class="bg-zinc-950 text-zinc-400 border border-zinc-800 px-2.5 py-1 rounded-lg text-xs font-light">Client</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="py-4 px-6 text-center">
                                            <?php if ((int)($u['is_active'] ?? 0) === 1): ?>
                                                <span class="text-[11px] text-emerald-400 font-medium bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">Actif</span>
                                            <?php else: ?>
                                                <span class="text-[11px] text-rose-400 font-medium bg-rose-500/10 px-2.5 py-1 rounded-full border border-rose-500/20">Bloqué</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="py-4 px-6">
                                            <form action="index.php?action=update_user" method="POST" class="flex items-center justify-center gap-3">
                                                <?php echo csrf_input_field(); ?>
                                                <input type="hidden" name="id_users" value="<?= $u['id_users'] ?? '' ?>">
                                                
                                                <select name="role" class="bg-zinc-950 border border-zinc-800 text-zinc-200 text-xs rounded-xl px-2.5 py-1.5 focus:outline-none focus:border-gold-500/80 transition duration-200">
                                                    <option value="client" <?= ($u['role'] ?? '') === 'client' ? 'selected' : '' ?>>Client</option>
                                                    <option value="employe" <?= ($u['role'] ?? '') === 'employe' ? 'selected' : '' ?>>Employé</option>
                                                    <option value="admin" <?= ($u['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                </select>

                                                <label class="flex items-center gap-2 cursor-pointer text-xs text-zinc-300 select-none">
                                                    <input type="checkbox" name="is_active" value="1" <?= (int)($u['is_active'] ?? 0) === 1 ? 'checked' : '' ?> class="accent-gold-500 rounded w-3.5 h-3.5">
                                                    Actif
                                                </label>

                                                <button type="submit" class="bg-gold-metallic hover:opacity-95 text-zinc-950 font-semibold text-xs px-3.5 py-1.5 rounded-xl transition duration-200 cursor-pointer shadow-md active:scale-95">
                                                    OK
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-zinc-500 italic font-light">Aucun utilisateur trouvé.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
</body>
</html>