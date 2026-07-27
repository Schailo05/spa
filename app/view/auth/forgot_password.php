<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Mon SPA</title>
    <script src="public/js/tailwind.js"></script>
</head>
<body class="h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">

<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-md border border-slate-100">
    <div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">Mot de passe oublié</h2>
        <p class="mt-2 text-center text-sm text-slate-500">
            Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg text-sm text-red-700">
            <p class="font-medium"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <form class="mt-6 space-y-6" action="index.php?action=forgot_password" method="POST">
        <?php echo csrf_input_field(); ?>
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Adresse email</label>
            <input type="email" name="email" id="email" required
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500"
                   placeholder="exemple@domaine.com">
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 cursor-pointer">
                Envoyer le lien de réinitialisation
            </button>
        </div>
    </form>

    <div class="text-center pt-2 border-t border-slate-100">
        <p class="text-xs text-slate-500">
            Retour à la <a href="index.php?action=login" class="text-slate-900 underline">connexion</a>.
        </p>
    </div>
</div>

</body>
</html>
