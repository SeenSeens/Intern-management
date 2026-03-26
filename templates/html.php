<!DOCTYPE html>

<html class="light" lang="en"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - InternHub</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <!-- Logo/Branding -->
    <div class="flex flex-col items-center mb-8">
        <div class="bg-primary p-3 rounded-xl shadow-lg shadow-primary/20 mb-4">
            <span class="material-symbols-outlined text-white text-3xl">hub</span>
        </div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">InternHub</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Management Portal Access</p>
    </div>
    <!-- Login Card -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8">
            <form action="#" class="space-y-6" method="POST">
                <!-- Email Field -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="email">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </div>
                        <input class="block w-full pl-10 pr-3 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all sm:text-sm" id="email" name="email" placeholder="name@company.com" required="" type="email"/>
                    </div>
                </div>
                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="password">
                            Password
                        </label>
                        <a class="text-sm font-medium text-primary hover:text-primary/80 transition-colors" href="#">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </div>
                        <input class="block w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all sm:text-sm" id="password" name="password" placeholder="••••••••" required="" type="password"/>
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200" type="button">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </button>
                    </div>
                </div>
                <!-- Remember Me -->
                <div class="flex items-center">
                    <input class="h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 dark:border-slate-700 rounded transition-colors bg-white dark:bg-slate-800" id="remember-me" name="remember-me" type="checkbox"/>
                    <label class="ml-2 block text-sm text-slate-600 dark:text-slate-400" for="remember-me">
                        Keep me logged in
                    </label>
                </div>
                <!-- Login Button -->
                <button class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all" type="submit">
                    Sign In
                </button>
            </form>
            <!-- Divider -->
            <div class="mt-8 relative">
                <div aria-hidden="true" class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-slate-900 text-slate-500">New to InternHub?</span>
                </div>
            </div>
            <!-- Footer Text -->
            <div class="mt-6 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Contact your administrator to
                    <a class="font-medium text-primary hover:text-primary/80" href="#">request access</a>
                </p>
            </div>
        </div>
    </div>
    <!-- System Status/Footer -->
    <div class="mt-8 flex flex-col items-center space-y-4">
        <div class="flex items-center space-x-2 text-xs text-slate-400">
            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
            <span>System status: Operational</span>
        </div>
        <div class="flex space-x-4 text-xs font-medium text-slate-400">
            <a class="hover:text-slate-600 dark:hover:text-slate-200 transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-slate-600 dark:hover:text-slate-200 transition-colors" href="#">Terms of Service</a>
            <a class="hover:text-slate-600 dark:hover:text-slate-200 transition-colors" href="#">Support</a>
        </div>
    </div>
</div>
</body></html>