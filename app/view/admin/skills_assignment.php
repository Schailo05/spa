<form action="index.php?action=save_skills_assignment" method="POST">
    <?php echo csrf_input_field(); ?>
    <?php $flash = get_flash(); ?>
    <?php if (!empty($flash)): ?>
        <div class="mb-5 rounded-2xl border px-4 py-3 text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-100' : 'bg-rose-500/10 border-rose-500/20 text-rose-100' ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-zinc-700">
                <th class="p-3">Soin / Service</th>
                <?php foreach ($employees as $emp): ?>
                    <th class="p-3 text-center">
                        <?= htmlspecialchars(($emp['first_name'] ?? 'Employé') . ' ' . ($emp['last_name'] ?? '#' . $emp['id_users'])) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr class="border-b border-zinc-800">
                    <td class="p-3 font-medium">
                        <?= htmlspecialchars($service['name']) ?>
                    </td>
                    <?php foreach ($employees as $emp): ?>
                        <td class="p-3 text-center">
                            <input type="checkbox" 
                                   name="skills[<?= $emp['id_users'] ?>][]" 
                                   value="<?= $service['id_services'] ?>"
                                   class="w-4 h-4 accent-gold-500">
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <button type="submit" class="mt-4 bg-gold-500 text-black px-4 py-2 rounded font-bold">
        Enregistrer les affectations
    </button>
</form>