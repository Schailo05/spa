<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement du rendez-vous</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[radial-gradient(circle_at_top,_rgba(45,212,191,0.12),_transparent_40%),#020617] text-slate-100 min-h-screen">

    <header class="bg-slate-900/80 border-b border-slate-800 px-6 py-4 backdrop-blur">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-teal-400">Paiement sécurisé</h1>
                <p class="text-sm text-slate-400 mt-1">Finalisez votre rendez-vous en toute sérénité</p>
            </div>
            <a href="index.php?action=booking" class="text-sm bg-slate-800 hover:bg-slate-700 border border-slate-700 px-4 py-2 rounded-lg transition">← Retour</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-6 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_0.8fr] gap-6">
            <section class="bg-slate-900/80 border border-slate-800 rounded-2xl p-8 shadow-2xl shadow-black/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-teal-500/15 flex items-center justify-center text-teal-400 text-xl">✓</div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Confirmez votre rendez-vous</h2>
                        <p class="text-sm text-slate-400">Voici le résumé de votre réservation avant validation.</p>
                    </div>
                </div>

                <?php $flash = get_flash(); ?>
                <?php if (!empty($flash)): ?>
                    <div class="mb-6 <?= $flash['type'] === 'success' ? 'bg-emerald-950/40 border border-emerald-700 text-emerald-200' : 'bg-rose-950/40 border border-rose-700 text-rose-200' ?> p-4 rounded-xl text-sm">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-4 mb-8">
                    <div class="p-4 bg-slate-800/80 border border-slate-700 rounded-xl">
                        <p class="text-sm text-zinc-400 uppercase tracking-[0.2em] mb-2">Prestation</p>
                        <p class="text-lg font-semibold text-white"><?= htmlspecialchars($pending['service_name']) ?></p>
                    </div>
                    <div class="p-4 bg-slate-800/80 border border-slate-700 rounded-xl">
                        <p class="text-sm text-zinc-400 uppercase tracking-[0.2em] mb-2">Praticien</p>
                        <p class="text-lg font-semibold text-white"><?= htmlspecialchars($pending['employee_name']) ?></p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-800/80 border border-slate-700 rounded-xl">
                            <p class="text-sm text-zinc-400 uppercase tracking-[0.2em] mb-2">Date</p>
                            <p class="text-lg font-semibold text-white"><?= htmlspecialchars($pending['appointment_date']) ?></p>
                        </div>
                        <div class="p-4 bg-slate-800/80 border border-slate-700 rounded-xl">
                            <p class="text-sm text-zinc-400 uppercase tracking-[0.2em] mb-2">Heure</p>
                            <p class="text-lg font-semibold text-white"><?= htmlspecialchars($pending['appointment_time']) ?></p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-800/80 border border-slate-700 rounded-xl">
                        <p class="text-sm text-zinc-400 uppercase tracking-[0.2em] mb-2">Montant</p>
                        <p class="text-3xl font-bold text-teal-300"><?= number_format((float)$pending['service_price'], 2, ',', ' ') ?> $</p>
                    </div>
                </div>

                <form action="index.php?action=process_payment" method="POST" class="space-y-6">
                    <?php echo csrf_input_field(); ?>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-500 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-teal-500/20">
                        Payer <?= number_format((float)$pending['service_price'], 2, ',', ' ') ?> $
                    </button>
                </form>
            </section>

            <aside class="space-y-4">
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/20">
                    <h3 class="text-lg font-semibold text-white mb-4">Sécurité</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Votre paiement est traité via Stripe. Une fois le paiement confirmé, votre rendez-vous sera enregistré automatiquement.</p>
                </div>

                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/20">
                    <h3 class="text-lg font-semibold text-white mb-4">Prochaine étape</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex gap-2"><span class="text-teal-400">1.</span> Cliquez sur le bouton de paiement</li>
                        <li class="flex gap-2"><span class="text-teal-400">2.</span> Validez votre paiement Stripe</li>
                        <li class="flex gap-2"><span class="text-teal-400">3.</span> Retrouvez votre rendez-vous dans votre espace</li>
                    </ul>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="index.php?action=dashboard" class="text-center bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white px-4 py-2 rounded-lg transition">Retour au tableau de bord</a>
                    <a href="index.php?action=booking" class="text-center bg-transparent border border-slate-600 hover:border-slate-400 text-slate-300 px-4 py-2 rounded-lg transition">Modifier la réservation</a>
                </div>
            </aside>
        </div>
    </main>
</body>
</html>
