<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - SPA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen font-sans">

    <!-- Navbar / En-tête -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex flex-wrap justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-teal-500/20 p-2.5 rounded-xl border border-teal-500/30 text-teal-400 font-bold text-xl">
                🌿
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">Mon Espace SPA</h1>
                <p class="text-xs text-slate-400">
                    Bienvenue, <span class="text-teal-400 font-semibold"><?= htmlspecialchars($_SESSION['user']['first_name'] ?? $_SESSION['user']['email']) ?></span> !
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <!-- Raccourci Spécial Employé -->
            <?php if (($_SESSION['user']['role'] ?? '') === 'employe'): ?>
                <a href="index.php?action=staff_dashboard" class="bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 border border-teal-500/30 text-xs px-3 py-2 rounded-lg transition font-medium flex items-center gap-1.5">
                    🧑‍⚕️ Mon Espace Praticien
                </a>
            <?php endif; ?>

            <!-- Raccourci Spécial Admin -->
            <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                <a href="index.php?action=admin_dashboard" class="bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs px-3 py-2 rounded-lg transition font-medium flex items-center gap-1.5">
                    ⚙️ Administration
                </a>
            <?php endif; ?>

            <!-- Bouton Déconnexion -->
            <a href="index.php?action=logout" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs px-3 py-2 rounded-lg transition font-medium">
                Déconnexion 🚪
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6 space-y-8 mt-4">

        <?php $flash = get_flash(); ?>
        <?php if (!empty($flash)): ?>
            <div class="max-w-6xl mx-auto px-4 sm:px-0">
                <div class="rounded-2xl border px-5 py-4 shadow-sm text-sm font-medium 
                    <?= $flash['type'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-100' : 'bg-rose-500/10 border-rose-500/20 text-rose-100' ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Carte Profil & Actions Rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Carte Profil -->
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-xs uppercase tracking-wider font-semibold text-slate-400">Mon Compte</span>
                        <span class="px-2.5 py-1 text-xs rounded-full font-bold uppercase bg-teal-500/10 text-teal-400 border border-teal-500/30">
                            <?= htmlspecialchars($_SESSION['user']['role'] ?? 'client') ?>
                        </span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p class="text-slate-300">
                            <strong class="text-slate-400 block text-xs">Email :</strong> 
                            <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Non renseigné') ?>
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-700/60 text-xs text-slate-400 flex items-center gap-2">
                    <span>✨ Statut du compte :</span>
                    <span class="text-emerald-400 font-semibold">Actif</span>
                </div>
            </div>

            <!-- Carte Prochain RDV -->
            <div class="bg-gradient-to-br from-emerald-900/30 to-slate-800 border border-emerald-500/20 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-3xl mb-3">🕘</div>
                    <h3 class="text-lg font-bold text-white mb-1">Prochain rendez-vous</h3>
                    <?php
                        $next = null;
                        if (!empty($userAppointments)) {
                            usort($userAppointments, function($a, $b){
                                return strtotime($a['appointment_date']) <=> strtotime($b['appointment_date']);
                            });
                            $now = time();
                            foreach ($userAppointments as $appt) {
                                if (strtotime($appt['appointment_date']) >= $now) { $next = $appt; break; }
                            }
                        }
                    ?>
                    <?php if ($next): ?>
                        <p class="text-sm text-slate-300 mt-2">Le <?= date('d/m/Y \à H:i', strtotime($next['appointment_date'])) ?> avec <strong class="text-white"><?= htmlspecialchars(trim(($next['employee_firstname'] ?? '') . ' ' . ($next['employee_lastname'] ?? ''))) ?: 'Praticien' ?></strong></p>
                    <?php else: ?>
                        <p class="text-sm text-slate-300 mt-2">Aucun rendez-vous à venir. Réservez votre prochain soin.</p>
                    <?php endif; ?>
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="index.php?action=booking" class="flex-1 text-center bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold py-2 rounded-xl transition text-sm">Réserver</a>
                    <?php if ($next): ?>
                        <form action="index.php?action=cancel_appointment" method="POST" class="m-0">
                            <?php echo csrf_input_field(); ?>
                            <input type="hidden" name="id_appointments" value="<?= htmlspecialchars($next['id_appointments'] ?? '') ?>">
                            <button type="submit" class="text-sm px-3 py-2 rounded-xl border border-rose-600 text-rose-300 hover:bg-rose-800">Annuler</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Carte Réserver un Soin -->
            <div class="bg-gradient-to-br from-teal-900/40 to-slate-800 border border-teal-500/30 rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-teal-500/60 transition group">
                <div>
                    <div class="text-3xl mb-3 group-hover:scale-110 transition duration-300">📅</div>
                    <h3 class="text-lg font-bold text-white mb-1">Prendre un Rendez-vous</h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Choisissez votre soin, sélectionnez votre praticien favori et réservez votre créneau en quelques clics.
                    </p>
                </div>

                <div class="mt-6">
                    <a href="index.php?action=booking" class="block text-center bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold py-2.5 px-4 rounded-xl transition shadow-lg text-sm">
                        Réserver un soin →
                    </a>
                </div>
            </div>

            <!-- Carte Explorer les Soins -->
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-slate-600 transition group">
                <div>
                    <div class="text-3xl mb-3 group-hover:scale-110 transition duration-300">💆‍♀️</div>
                    <h3 class="text-lg font-bold text-white mb-1">Nos Prestations & Soins</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Découvrez l'ensemble de nos massages, soins du visage et rituels bien-être ainsi que leurs tarifs.
                    </p>
                </div>

                <div class="mt-6">
                    <a href="index.php?action=booking" class="block text-center bg-slate-700 hover:bg-slate-600 text-slate-200 border border-slate-600 font-medium py-2.5 px-4 rounded-xl transition text-sm">
                        Découvrir la carte
                    </a>
                </div>
            </div>

        </div>

        <!-- Section Mes Rendez-vous -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-lg space-y-4">
            <div class="flex justify-between items-center border-b border-slate-700/60 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <span>🗓️</span> Mes Rendez-vous
                    </h2>
                    <p class="text-xs text-slate-400">Consultez l'historique et l'état de vos réservations.</p>
                </div>
                <a href="index.php?action=booking" class="text-xs text-teal-400 hover:underline">
                    + Nouveau rendez-vous
                </a>
            </div>

            <!-- Liste des RDV (Si le contrôleur passe $userAppointments) -->
            <?php if (empty($userAppointments)): ?>
                <div class="text-center py-10 text-slate-400 space-y-3">
                    <div class="text-4xl">🧘‍♂️</div>
                    <p class="text-sm">Vous n'avez aucun rendez-vous prévu pour le moment.</p>
                    <a href="index.php?action=booking" class="inline-block bg-teal-500/10 hover:bg-teal-500/20 text-teal-300 border border-teal-500/30 text-xs px-4 py-2 rounded-lg font-medium transition">
                        Réserver mon premier soin
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-700/40 text-slate-300 uppercase text-xs">
                            <tr>
                                <th class="p-3 rounded-l-lg">Date & Heure</th>
                                <th class="p-3">Soin</th>
                                <th class="p-3">Praticien</th>
                                <th class="p-3">Prix</th>
                                <th class="p-3 rounded-r-lg">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50 text-slate-200">
                            <?php foreach ($userAppointments as $rdv): ?>
                                <tr class="hover:bg-slate-700/30 transition">
                                    <td class="p-3 font-mono text-teal-300">
                                        <?= date('d/m/Y à H:i', strtotime($rdv['appointment_date'])) ?>
                                    </td>
                                    <td class="p-3 font-medium text-white">
                                        <?= htmlspecialchars($rdv['service_name'] ?? 'Soin') ?>
                                    </td>
                                    <td class="p-3 text-slate-400">
                                        <?= htmlspecialchars(($rdv['staff_firstname'] ?? '') . ' ' . ($rdv['staff_lastname'] ?? 'Sur place')) ?>
                                    </td>
                                    <td class="p-3 text-slate-300">
                                        <?= htmlspecialchars($rdv['price'] ?? '-') ?> $
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 border border-emerald-500/30 text-emerald-400">
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