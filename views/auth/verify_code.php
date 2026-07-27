<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification OTP - Mon SPA</title>
    <script src="public/js/tailwind.js"></script>
</head>
<body class="h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">

<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-md border border-slate-100">
    
    <div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Vérification par email
        </h2>
        <p class="mt-2 text-center text-sm text-slate-500">
            Un code de validation à 6 chiffres a été envoyé à votre adresse email.
        </p>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg text-sm text-red-700">
            <p class="font-medium"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>
    
    <form class="mt-6 space-y-6" action="index.php?action=verify_code" method="POST">
        
        <div>
            <label for="otp_code" class="block text-sm font-medium text-slate-700 mb-2 text-center">
                Entrez votre code à 6 chiffres
            </label>
            <input type="text" id="otp_code" name="otp_code" required maxlength="6" pattern="[0-9]{6}"
                   class="w-full text-center tracking-widest text-2xl font-bold px-3 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition duration-150"
                   placeholder="000000">
        </div>

        <div>
            <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 cursor-pointer">
                Vérifier le code
            </button>
        </div>
    </form>

    <div class="text-center pt-2 border-t border-slate-100">
        <p class="text-xs text-slate-500">
            Le code expire dans 15 minutes.
        </p>
    </div>
</div>

</body>
</html>