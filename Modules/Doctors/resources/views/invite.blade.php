<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Registration – Ogechi HMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #F1F5F9; }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        
        <div class="p-8 text-center bg-slate-50 border-b border-slate-100">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                <x-fas-tachometer-alt class="w-8 h-8 text-white" />
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Complete Registration</h1>
            <p class="text-sm text-slate-500 mt-2">Welcome, <span class="font-bold text-slate-700">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</span>!</p>
        </div>

        <form method="POST" action="{{ route('doctor.invite.store', $invite->token) }}" class="p-8 space-y-5">
            @csrf
            
            @if($errors->any())
                <div class="p-4 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Email Address</label>
                <div class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 text-sm">
                    {{ $invite->email }}
                </div>
                <p class="text-[10px] text-slate-400 mt-1">This email will be used for your account login.</p>
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Set Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-colors">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 px-4 text-white font-bold rounded-xl shadow-lg transition-transform transform hover:-translate-y-0.5" style="background:linear-gradient(135deg,#0B5ED7,#1D4ED8);">
                    Set Password & Login
                </button>
            </div>
        </form>
    </div>

</body>
</html>
