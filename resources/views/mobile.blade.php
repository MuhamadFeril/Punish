<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Mobile View - Punish Sistem</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Include Tailwind CSS compiled by Vite & Vue JS App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #020617; /* Slate 950 */
            overflow: hidden;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>
<body class="overflow-hidden">

    <!-- Vue App Target Element with Data Attributes -->
    <div id="vue-app" 
         data-user-name="{{ auth()->check() ? auth()->user()->name : 'Demo Karyawan' }}"
         data-user-role="{{ auth()->check() ? auth()->user()->role : 'guest' }}"
         data-user-avatar="{{ auth()->check() && auth()->user()->profile_photo_url ? auth()->user()->profile_photo_url : '' }}"
         data-csrf-token="{{ csrf_token() }}"
         data-logout-url="{{ route('logout') }}"
         data-dashboard-url="{{ route('dashboard') }}">
    </div>

</body>
</html>
