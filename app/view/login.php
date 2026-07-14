<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Votre SPA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion à votre espace</h2>

        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=login" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                <input type="email" name="email" id="email" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition text-gray-700"
                       placeholder="exemple@domaine.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" required 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition text-gray-700"
                       placeholder="••••••••">
            </div>

            <button type="submit" 
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2.5 px-4 rounded-lg transition shadow-sm hover:shadow duration-150">
                Se connecter
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">
            Pas encore de compte ? 
            <a href="index.php?action=register" class="text-teal-600 hover:underline font-medium">Inscrivez-vous</a>
        </p>
    </div>

</body>
</html>