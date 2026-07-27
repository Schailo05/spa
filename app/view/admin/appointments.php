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
        <?php $flash = get_flash(); ?>
        <?php if (!empty($flash)): ?>
            <div class="max-w-7xl mx-auto mb-6 px-4 sm:px-0">
                <div class="rounded-2xl border px-5 py-4 shadow-sm text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-100' : 'bg-rose-500/10 border-rose-500/20 text-rose-100' ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                </div>
            </div>
        <?php endif; ?>
        
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
                            <!-- COLONNE : Praticien attribué -->
                            <th class="py-4 px-6">Praticien Assigné</th>
                            <th class="py-4 px-6 text-center">Statut</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-800/60 text-sm">
                        <?php if(!empty($appointments)): ?>
                            <?php foreach($appointments as $app): ?>
                                <?php 
                                    // 1. Client : Récupération sécurisée du nom & prénom
                                    $clientFirstName = $app['client_firstname'] ?? $app['first_name'] ?? '';
                                    $clientLastName  = $app['client_lastname'] ?? $app['last_name'] ?? '';
                                    $clientFullName  = trim($clientFirstName . ' ' . $clientLastName);
                                    $clientEmail     = $app['email'] ?? '';

                                    // 2. Praticien : Récupération sécurisée
                                    $empFirstName    = $app['employee_firstname'] ?? '';
                                    $empLastName     = $app['employee_lastname'] ?? '';
                                    $empFullName     = trim($empFirstName . ' ' . $empLastName);

                                    // 3. Prestation & Détails
                                    $serviceName     = $app['service_name'] ?? $app['name'] ?? 'Prestation inconnue';
                                    $duration        = $app['duration'] ?? 0;
                                    $price           = $app['price'] ?? 0;
                                    $appointmentDate = isset($app['appointment_date']) ? date('d/m/Y à H:i', strtotime($app['appointment_date'])) : 'Date non définie';
                                    $status          = strtolower($app['status'] ?? '');
                                    $idAppointment   = $app['id_appointments'] ?? '';
                                ?>
                                <tr class="hover:bg-zinc-800/30 transition duration-150">
                                    
                                    <!-- Date -->
                                    <td class="py-4 px-6 text-white font-medium whitespace-nowrap text-xs">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gold-400">📅</span>
                                            <span class="font-light tracking-wide"><?= htmlspecialchars($appointmentDate) ?></span>
                                        </div>
                                    </td>
                                    
                                    <!-- Client -->
                                    <td class="py-4 px-6">
                                        <span class="block text-white font-medium text-sm">
                                            <?= htmlspecialchars(!empty($clientFullName) ? $clientFullName : 'Client Anonyme') ?>
                                        </span>
                                        <span class="text-xs text-zinc-400 font-mono text-[11px] font-light">
                                            <?= htmlspecialchars($clientEmail) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Prestation -->
                                    <td class="py-4 px-6">
                                        <span class="block text-gold-300 font-serif font-normal text-lg tracking-wide">
                                            <?= htmlspecialchars($serviceName) ?>
                                        </span>
                                        <span class="text-xs text-zinc-400 font-light">
                                            ⏱️ <?= htmlspecialchars((string)$duration) ?> min &nbsp;|&nbsp; 
                                            <strong class="text-gold-metallic font-semibold"><?= htmlspecialchars((string)$price) ?> $</strong>
                                        </span>
                                    </td>

                                    <!-- Praticien attribué -->
                                    <td class="py-4 px-6">
                                        <form action="index.php?action=assign_employee" method="POST" class="flex items-center gap-1.5">
                                            <input type="hidden" name="id_appointment" value="<?= htmlspecialchars((string)($app['id_appointments'] ?? '')) ?>">
        <?php echo csrf_input_field(); ?>
                                            <select name="id_employee" 
                                                    class="bg-zinc-950 text-zinc-200 border border-zinc-800 rounded-lg px-2 py-1 text-xs focus:outline-none focus:border-gold-500 transition duration-200">
                                                <option value="">-- Non assigné --</option>
                                                <?php if (!empty($employees)): ?>
                                                    <?php foreach ($employees as $emp): ?>
                                                        <?php 
                                                            $empId   = $emp['id_users'] ?? '';
                                                            $empName = trim(($emp['first_name'] ?? '') . ' ' . ($emp['last_name'] ?? ''));
                                                            $isSelected = (isset($app['id_employee']) && $app['id_employee'] == $empId) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= htmlspecialchars((string)$empId) ?>" <?= $isSelected ?>>
                                                            🧑‍⚕️ <?= htmlspecialchars($empName) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>

                                            <button type="submit"
                                                    class="bg-gold-metallic text-zinc-950 font-semibold px-2.5 py-1 rounded-lg text-xs hover:opacity-90 active:scale-95 transition duration-150">
                                                OK
                                            </button>
                                        </form>
                                    </td>
                                    
                                    <!-- Statut Badge -->
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <?php if($status === 'confirme' || $status === 'confirmé'): ?>
                                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full text-[11px] font-medium">Confirmé</span>
                                        <?php elseif($status === 'annule' || $status === 'annulé'): ?>
                                            <span class="bg-rose-500/10 text-rose-400 border border-rose-500/20 px-3 py-1 rounded-full text-[11px] font-medium">Annulé</span>
                                        <?php else: ?>
                                            <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1 rounded-full text-[11px] font-medium">En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Actions rapides -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <?php if($status !== 'confirme' && $status !== 'confirmé'): ?>
                                                <a href="index.php?action=admin_appointments&change_status=confirme&id=<?= $idAppointment ?>" 
                                                   class="text-xs bg-gold-metallic hover:opacity-95 text-zinc-950 font-semibold px-3.5 py-1.5 rounded-xl transition duration-200 shadow-md active:scale-95">
                                                    Accepter
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if($status !== 'annule' && $status !== 'annulé'): ?>
                                                <a href="index.php?action=admin_appointments&change_status=annule&id=<?= $idAppointment ?>" 
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
                                <td colspan="6" class="py-10 text-center text-zinc-500 italic font-light">Aucun rendez-vous planifié pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
   
</body>
</html>