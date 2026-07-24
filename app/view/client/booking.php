<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver un Soin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">

    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-teal-400">Réserver une Prestation 🌿</h1>
        <a href="index.php?action=client_dashboard" class="text-sm bg-slate-700 hover:bg-slate-600 px-4 py-2 rounded transition">← Mon Espace</a>
    </header>

    <main class="max-w-3xl mx-auto p-6 mt-8">
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 shadow-xl">
            <h2 class="text-2xl font-bold text-white mb-6">Prendre Rendez-vous</h2>

            <form action="index.php?action=save_booking" method="POST" class="space-y-6">
                
                <!-- 1. Choix du Soin -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">1. Choisissez votre soin :</label>
                    <select name="id_services" id="service_select" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                        <option value="">-- Sélectionnez un soin --</option>
                        <?php foreach($services as $service): ?>
                            <option value="<?= $service['id_services'] ?>">
                                <?= htmlspecialchars($service['name']) ?> - <?= $service['duration'] ?> min (<?= $service['price'] ?> €)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 2. Choix du Praticien / Employé -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">2. Choisissez votre praticien :</label>
                    <select name="id_employee" id="employee_select" required disabled class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500 disabled:opacity-50">
                        <option value="">-- Sélectionnez d'abord un soin --</option>
                    </select>
                </div>

                <!-- 3. Choix de la Date et l'Heure -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">3. Date :</label>
                        <input type="date" name="appointment_date" min="<?= date('Y-m-d') ?>" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">4. Heure :</label>
                        <input type="time" name="appointment_time" min="09:00" max="19:00" step="1800" required class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-slate-100 focus:outline-none focus:border-teal-500">
                    </div>
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-500 text-white font-bold py-3 rounded-lg transition text-center cursor-pointer mt-4">
                    Confirmer la réservation
                </button>
            </form>
        </div>
    </main>

    <!-- Script AJAX pour charger dynamiquement les praticiens -->
    <script>
        document.getElementById('service_select').addEventListener('change', function() {
            const serviceId = this.value;
            const employeeSelect = document.getElementById('employee_select');

            if (!serviceId) {
                employeeSelect.innerHTML = '<option value="">-- Sélectionnez d\'abord un soin --</option>';
                employeeSelect.disabled = true;
                return;
            }

            employeeSelect.innerHTML = '<option value="">Chargement des praticiens...</option>';

            fetch(`index.php?action=get_employees_by_service&service_id=${serviceId}`)
                .then(response => response.json())
                .then(employees => {
                    employeeSelect.innerHTML = '';
                    
                    if (employees.length === 0) {
                        employeeSelect.innerHTML = '<option value="">Aucun praticien disponible pour ce soin</option>';
                        employeeSelect.disabled = true;
                    } else {
                        employeeSelect.disabled = false;
                        employeeSelect.innerHTML = '<option value="">-- Sélectionnez un praticien --</option>';
                        employees.forEach(emp => {
                            const option = document.createElement('option');
                            option.value = emp.id_users;
                            option.textContent = `${emp.first_name} ${emp.last_name}`;
                            employeeSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    employeeSelect.innerHTML = '<option value="">Erreur lors du chargement</option>';
                });
        });
    </script>
</body>
</html>