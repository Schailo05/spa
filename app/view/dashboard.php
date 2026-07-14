<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Espace - SPA</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-xl shadow">
        <h1 class="text-3xl font-bold text-teal-700">
            Bonjour, <?= htmlspecialchars($_SESSION['user']['first_name']) ?> ! 👋
        </h1>
        <p class="text-gray-600 mt-2">Bienvenue sur votre espace personnel du SPA.</p>
        
        <div class="mt-6 p-4 bg-teal-50 rounded-lg text-sm text-teal-900">
            <strong>Votre profil :</strong><br>
            Email : <?= htmlspecialchars($_SESSION['user']['email']) ?><br>
            Rôle : <?= htmlspecialchars($_SESSION['user']['role']) ?>
        </div>
        <div class="mt-6 text-center">
    <a href="index.php?action=logout" 
       class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 shadow-sm text-sm">
        Se déconnecter 🚪
    </a>
</div>
    </div>
</body>
</html>