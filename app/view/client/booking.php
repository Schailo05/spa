<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un Soin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[radial-gradient(circle_at_top,_rgba(45,212,191,0.12),_transparent_40%),#020617] text-slate-100 min-h-screen">

    <header class="bg-slate-900/80 border-b border-slate-800 px-6 py-4 backdrop-blur">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-teal-400">Réserver une prestation 🌿</h1>
                <p class="text-sm text-slate-400 mt-1">Prenez rendez-vous en quelques étapes simples</p>
            </div>
            <a href="index.php?action=client_dashboard" class="text-sm bg-slate-800 hover:bg-slate-700 border border-slate-700 px-4 py-2 rounded-lg transition">← Mon espace</a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-6">
            <section class="bg-slate-900/80 border border-slate-800 rounded-2xl p-8 shadow-2xl shadow-black/20">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-teal-500/15 flex items-center justify-center text-teal-400 text-xl">✦</div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Prendre rendez-vous</h2>
                        <p class="text-sm text-slate-400">Choisissez votre soin, votre praticien et votre créneau.</p>
                    </div>
                </div>

                <?php $flash = get_flash(); ?>
                <?php if (!empty($flash)): ?>
                    <div class="mb-6 <?= $flash['type'] === 'success' ? 'bg-emerald-950/40 border border-emerald-700 text-emerald-200' : 'bg-rose-950/40 border border-rose-700 text-rose-200' ?> p-4 rounded-xl text-sm">
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=save_booking" method="POST" class="space-y-6" novalidate>
                    <?php echo csrf_input_field(); ?>

                    <?php $old = $_SESSION['booking_old'] ?? []; ?>

                    <div class="bg-slate-800/80 border border-slate-700 rounded-xl p-4">
                        <label class="block text-sm font-medium text-slate-300 mb-2">1. Choisissez votre soin</label>
                        <select name="id_services" id="service_select" required class="w-full bg-slate-950 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                            <option value="">-- Sélectionnez un soin --</option>
                            <?php foreach ($services as $service): ?>
                                <?php $availableCount = $serviceAvailability[$service['id_services']] ?? 0; ?>
                                <option value="<?= htmlspecialchars($service['id_services']) ?>" <?= $availableCount === 0 ? 'disabled' : '' ?> <?= isset($old['id_services']) && $old['id_services'] == $service['id_services'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($service['name']) ?> · <?= htmlspecialchars($service['duration']) ?> min · <?= htmlspecialchars($service['price']) ?> $ <?= $availableCount === 0 ? '(Aucun praticien)' : '(' . $availableCount . ' praticien' . ($availableCount > 1 ? 's' : '') . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($old['id_services']) && ($serviceAvailability[$old['id_services']] ?? 0) === 0): ?>
                            <p class="mt-3 text-sm text-amber-300">Ce soin n'a actuellement aucun praticien disponible. Choisissez un autre soin.</p>
                        <?php endif; ?>
                    </div>

                    <div class="bg-slate-800/80 border border-slate-700 rounded-xl p-4">
                        <label class="block text-sm font-medium text-slate-300 mb-2">2. Choisissez votre praticien</label>
                        <select name="id_employee" id="employee_select" required class="w-full bg-slate-950 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500 disabled:opacity-50" <?= empty($old['id_services']) ? 'disabled' : '' ?> >
                            <option value="">-- Sélectionnez d'abord un soin --</option>
                        </select>
                        <p id="employee_help" class="mt-3 text-sm text-slate-400">Sélectionnez un soin pour afficher les praticiens disponibles.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-800/80 border border-slate-700 rounded-xl p-4">
                            <label class="block text-sm font-medium text-slate-300 mb-2">3. Date</label>
                            <input type="date" name="appointment_date" min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($old['appointment_date'] ?? '') ?>" required class="w-full bg-slate-950 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                        </div>
                        <div class="bg-slate-800/80 border border-slate-700 rounded-xl p-4">
                            <label class="block text-sm font-medium text-slate-300 mb-2">4. Heure</label>
                            <input type="time" name="appointment_time" min="09:00" max="19:00" step="1800" value="<?= htmlspecialchars($old['appointment_time'] ?? '') ?>" required class="w-full bg-slate-950 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-500 text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-teal-500/20">
                        Continuer vers le paiement
                    </button>
                </form>
            </section>

            <aside class="space-y-4">
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/20">
                    <h3 class="text-lg font-semibold text-white mb-4">Pourquoi réserver ici ?</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex gap-2"><span class="text-teal-400">✓</span> Sélection simple du soin et du praticien</li>
                        <li class="flex gap-2"><span class="text-teal-400">✓</span> Paiement sécurisé avant confirmation</li>
                        <li class="flex gap-2"><span class="text-teal-400">✓</span> Confirmation rapide par email</li>
                    </ul>
                </div>

                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-black/20">
                    <h3 class="text-lg font-semibold text-white mb-4">Étapes du rendez-vous</h3>
                    <div class="space-y-3 text-sm text-slate-400">
                        <div class="flex gap-3"><span class="w-7 h-7 rounded-full bg-teal-500/15 text-teal-400 flex items-center justify-center font-semibold">1</span><div>Choisissez votre soin</div></div>
                        <div class="flex gap-3"><span class="w-7 h-7 rounded-full bg-teal-500/15 text-teal-400 flex items-center justify-center font-semibold">2</span><div>Sélectionnez un praticien</div></div>
                        <div class="flex gap-3"><span class="w-7 h-7 rounded-full bg-teal-500/15 text-teal-400 flex items-center justify-center font-semibold">3</span><div>Choisissez la date et l’heure</div></div>
                        <div class="flex gap-3"><span class="w-7 h-7 rounded-full bg-teal-500/15 text-teal-400 flex items-center justify-center font-semibold">4</span><div>Validez le paiement</div></div>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    <script>
        const oldBooking = <?= json_encode($old, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const employeeSelect = document.getElementById('employee_select');
        const serviceSelect = document.getElementById('service_select');

        function loadEmployees(serviceId, selectedEmployeeId = null) {
            employeeSelect.innerHTML = '<option value="">Chargement des praticiens...</option>';
            employeeSelect.disabled = true;
            document.getElementById('employee_help').textContent = 'Recherche des praticiens disponibles...';

            fetch(`index.php?action=get_employees_by_service&service_id=${serviceId}`)
                .then(response => response.json())
                .then(employees => {
                    employeeSelect.innerHTML = '';

                    if (!Array.isArray(employees) || employees.length === 0) {
                        employeeSelect.innerHTML = '<option value="">Aucun praticien disponible pour ce soin</option>';
                        employeeSelect.disabled = true;
                        document.getElementById('employee_help').textContent = 'Aucun praticien disponible pour ce soin sélectionné.';
                        return;
                    }

                    employeeSelect.disabled = false;
                    employeeSelect.innerHTML = '<option value="">-- Sélectionnez un praticien --</option>';
                    employees.forEach(emp => {
                        const option = document.createElement('option');
                        option.value = emp.id_users;
                        option.className = 'bg-slate-900 text-slate-100';
                        option.textContent = `${emp.first_name || ''} ${emp.last_name || ''}`.trim() || 'Praticien';
                        if (selectedEmployeeId && selectedEmployeeId.toString() === emp.id_users.toString()) {
                            option.selected = true;
                        }
                        employeeSelect.appendChild(option);
                    });
                    document.getElementById('employee_help').textContent = employees.length + ' praticien' + (employees.length > 1 ? 's' : '') + ' disponibles.';
                })
                .catch(() => {
                    employeeSelect.innerHTML = '<option value="">Erreur lors du chargement</option>';
                    document.getElementById('employee_help').textContent = 'Impossible de charger les praticiens pour le moment.';
                });
        }

        document.getElementById('service_select').addEventListener('change', function() {
            const serviceId = this.value;

            if (!serviceId) {
                employeeSelect.innerHTML = '<option value="">-- Sélectionnez d’abord un soin --</option>';
                employeeSelect.disabled = true;
                document.getElementById('employee_help').textContent = 'Sélectionnez un soin pour afficher les praticiens disponibles.';
                return;
            }

            loadEmployees(serviceId);
        });

        if (oldBooking.id_services) {
            loadEmployees(oldBooking.id_services, oldBooking.id_employee);
        }
    </script>
</body>
</html>
