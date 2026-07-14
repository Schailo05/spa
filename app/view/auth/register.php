<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Mon SPA</title>
    <script src="public/js/tailwind.js"></script>
</head>
<body class="h-full flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-black">

<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-md border border-slate-100">
    
    <div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Créer un compte
        </h2>
        <p class="mt-2 text-center text-sm text-slate-500">
            Rejoignez l'expérience bien-être de notre SPA
        </p>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg text-sm text-red-700">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-medium"><?= htmlspecialchars($error) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <form class="mt-6 space-y-5" action="index.php?action=register" method="POST">
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-slate-700 mb-1">Prénom</label>
                <input type="text" id="first_name" name="first_name" required 
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 text-sm transition duration-150"
                       placeholder="Jean">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-slate-700 mb-1">Nom</label>
                <input type="text" id="last_name" name="last_name" required 
                       class="w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 text-sm transition duration-150"
                       placeholder="Dupont">
            </div>
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Téléphone</label>
            <input type="tel" id="phone" name="phone" required 
                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 text-sm transition duration-150"
                   placeholder="+33 6 12 34 56 78">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Adresse Email</label>
            <input type="email" id="email" name="email" required 
                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 text-sm transition duration-150"
                   placeholder="vous@exemple.com">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Mot de passe</label>
            <input type="password" id="password" name="password" minlength="8" required 
                   class="w-full px-3 py-2.5 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 text-sm transition duration-150">
            <span class="text-xs text-slate-400 mt-1 block">8 caractères minimum obligatoires</span>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 cursor-pointer">
                Créer mon compte
            </button>
        </div>
    </form>

    <div class="text-center pt-2 border-t border-slate-100">
        <p class="text-sm text-slate-600">
            Vous avez déjà un compte ? 
            <a href="index.php?action=login" class="font-medium text-slate-900 hover:text-slate-700 underline underline-offset-4 transition duration-150">
                Se connecter
            </a>
        </p>
    </div>
</div>

</body>
</html>