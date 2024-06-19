<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Demande de Compte</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans text-gray-800">
  <div class="max-w-lg mx-auto my-10 p-6 bg-white border border-gray-300 rounded-lg shadow-lg">
    <p class="text-lg mb-4">Bonjour Mr le directeur,</p>
    <p class="mb-4">Je suis un <span class="font-semibold">{{ $details['role'] }}</span> dans l'universite d'Abdelmalek
      Essadi, je souhaite demander un compte pour accéder au système. Voici mes détails :</p>
    <ul class="list-none pl-0 mb-4">
      @foreach ($details as $key => $val)
        <li class="py-2 border-b border-gray-200"><strong>{{ ucfirst($key) }}:</strong> {{ $val }}</li>
      @endforeach
    </ul>
    <p class="mb-4">J'apprécierais que vous puissiez configurer mon compte dès que possible.</p>
    <p>Merci,</p>
    <p class="font-semibold">{{ $details['name'] }}</p>
  </div>
</body>

</html>
