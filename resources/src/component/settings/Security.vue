<script setup>

</script>

<template>
  <div class="flex-1 flex flex-col gap-6 pb-12">
    <!-- Change Password Section -->
    <div class="rounded-lg border border-slate-200 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border border-slate-200 bg-white">
        <h3 class="text-base font-semibold text-on-surface">Change Password</h3>
        <p class="text-xs text-on-surface-variant">Ensure your account is using a long, random password to stay secure.</p>
      </div>
      <div class="p-6">
        <form class="space-y-4 max-w-2xl">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Current Password</label>
            <input class="w-full px-4 py-2.5 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="••••••••" type="password"/>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
              <input class="w-full px-4 py-2.5 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="••••••••" type="password"/>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirm New Password</label>
              <input class="w-full px-4 py-2.5 bg-surface-container-low border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" placeholder="••••••••" type="password"/>
            </div>
          </div>
          <div class="pt-2 flex justify-end">
            <button class="bg-primary text-white px-6 py-2.5 rounded-lg font-semibold text-sm shadow-md hover:bg-blue-700 transition-all active:scale-95" type="submit">Update Password</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Two-Factor Authentication Section -->
    <div class="rounded-lg border border-slate-200 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 bg-white flex items-center justify-between">
        <div>
          <h3 class="text-base font-semibold text-on-surface">Two-Factor Authentication (2FA)</h3>
          <p class="text-xs text-on-surface-variant">Add an extra layer of security to your account by requiring more than just a password.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-error-container text-on-error-container">Disabled</span>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="md:col-span-2 space-y-4">
            <div class="flex items-start gap-4 p-4 rounded-lg bg-surface-container-low border border-slate-200">
              <div class="p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-primary">smartphone</span>
              </div>
              <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-1">Authenticator App</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Use an app like Google Authenticator or 1Password to generate secure 2FA codes.</p>
              </div>
              <button class="ml-auto text-primary text-xs font-bold uppercase tracking-widest hover:underline">Enable</button>
            </div>
            <div class="flex items-start gap-4 p-4 rounded-lg bg-surface-container-low border border-slate-200">
              <div class="p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-primary">sms</span>
              </div>
              <div>
                <h4 class="text-sm font-semibold text-slate-900 mb-1">SMS Authentication</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Receive a verification code via text message to your mobile phone.</p>
              </div>
              <button class="ml-auto text-primary text-xs font-bold uppercase tracking-widest hover:underline">Setup</button>
            </div>
          </div>
          <div class="bg-primary-container p-6 rounded-lg flex flex-col items-center justify-center text-center">
            <div class="w-16 h-16 bg-white rounded-xl shadow-sm mb-4 flex items-center justify-center">
              <span class="material-symbols-outlined text-3xl text-primary">qr_code_2</span>
            </div>
            <h5 class="text-sm font-bold text-primary mb-2">Ready to secure?</h5>
            <p class="text-[11px] text-primary/80 mb-4 px-2">Click below to start the 2FA setup wizard and generate backup codes.</p>
            <button class="w-full py-2 bg-primary text-white rounded-lg text-xs font-bold shadow-md hover:bg-blue-700 transition-all">Begin Setup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Session Management Section -->
    <div class="rounded-lg border border-slate-200 shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 bg-white">
        <h3 class="text-base font-semibold text-on-surface">Active Sessions</h3>
        <p class="text-xs text-on-surface-variant">Manage and log out your active sessions on other browsers and devices.</p>
      </div>
      <div class="divide-y divide-outline">
        <!-- Session Item -->
        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
          <div class="flex items-center gap-4">
            <div class="text-slate-400">
              <span class="material-symbols-outlined text-2xl">desktop_windows</span>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-slate-900">Chrome on macOS</span>
                <span class="px-1.5 py-0.5 rounded bg-green-100 text-green-700 text-[10px] font-bold uppercase">This Device</span>
              </div>
              <p class="text-xs text-slate-500">Ho Chi Minh City, Vietnam • IP: 115.79.44.120</p>
            </div>
          </div>
          <button class="text-xs font-bold text-slate-400 cursor-not-allowed">Active</button>
        </div>
        <!-- Session Item -->
        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
          <div class="flex items-center gap-4">
            <div class="text-slate-400">
              <span class="material-symbols-outlined text-2xl">smartphone</span>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-slate-900">Safari on iPhone 15</span>
              </div>
              <p class="text-xs text-slate-500">Da Nang, Vietnam • Last active: 2 hours ago</p>
            </div>
          </div>
          <button class="text-xs font-bold text-error hover:underline transition-all">Sign Out</button>
        </div>
      </div>
      <div class="px-6 py-4 bg-surface-container-low border-t border-slate-200 flex justify-end">
        <button class="text-xs font-bold text-secondary uppercase tracking-widest hover:text-slate-900 transition-colors">Sign Out All Other Sessions</button>
      </div>
    </div>
    <!-- Danger Zone -->
    <div class="bg-red-50/30 rounded-lg border border-red-100 overflow-hidden">
      <div class="p-6 flex items-center justify-between">
        <div class="flex items-start gap-4">
          <div class="p-2 bg-red-100 rounded-lg text-red-600">
            <span class="material-symbols-outlined">delete_forever</span>
          </div>
          <div>
            <h3 class="text-sm font-bold text-red-900">Delete Account</h3>
            <p class="text-xs text-red-700/70">Once you delete your account, there is no going back. Please be certain.</p>
          </div>
        </div>
        <button class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition-all duration-200">Deactivate Account</button>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
