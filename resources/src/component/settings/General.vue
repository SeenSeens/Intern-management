<script setup>

</script>
<template>
	<div class="flex-1 flex flex-col gap-6 pb-12">
	    <!-- Form Card: General Settings -->
	    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
	      <div class="p-6 border-b border-slate-200">
	        <h3 class="text-lg font-bold text-slate-900">Nhận dạng tổ chức</h3>
	        <p class="text-sm text-slate-500">Thông tin cơ bản về tổ chức của bạn</p>
	      </div>
	      <div class="p-6 space-y-6">
	        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
	          <div class="flex flex-col gap-2">
	            <label class="text-sm font-semibold text-slate-700">Tên tổ chức</label>
	            <input class="rounded-lg border-slate-200 bg-white text-slate-900 focus:ring-primary focus:border-primary text-sm p-2.5" type="text" value="Global Tech Solutions"/>
	          </div>
	          <div class="flex flex-col gap-2">
	            <label class="text-sm font-semibold text-slate-700">Email của tổ chức</label>
	            <input class="rounded-lg border-slate-200 bg-white text-slate-900 focus:ring-primary focus:border-primary text-sm p-2.5" type="email" value="admin@globaltech.com"/>
	          </div>
	        </div>
	        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
	          <div class="flex flex-col gap-2">
	            <label class="text-sm font-semibold text-slate-700">Ngôn ngữ hệ thống</label>
	            <select class="rounded-lg border-slate-200 bg-white text-slate-900 focus:ring-primary focus:border-primary text-sm p-2.5">
	              <option value="en">English (US)</option>
	              <option value="es">Spanish</option>
	              <option value="fr">French</option>
	              <option value="de">German</option>
	            </select>
	          </div>
	          <div class="flex flex-col gap-2">
	            <label class="text-sm font-semibold text-slate-700">Múi giờ</label>
	            <select class="rounded-lg border-slate-200 bg-white text-slate-900 focus:ring-primary focus:border-primary text-sm p-2.5">
	              <option value="utc">UTC (Coordinated Universal Time)</option>
	              <option value="pst">(GMT-08:00) Pacific Time</option>
	              <option selected="" value="est">(GMT-05:00) Eastern Time</option>
	              <option value="cet">(GMT+01:00) Central European Time</option>
	            </select>
	          </div>
	        </div>
	      </div>
	    </div>
	    <!-- Theme Customization Section -->
	    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
	      <div class="p-6 border-b border-slate-200">
	        <h3 class="text-lg font-bold text-slate-900">Appearance</h3>
	        <p class="text-sm text-slate-500">Tùy chỉnh giao diện ứng dụng cho người dùng của bạn.</p>
	      </div>
	      <div class="p-6">
	        <p class="text-sm font-semibold text-slate-700 mb-4">Theme Mode</p>
	        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
	          <label class="cursor-pointer">
	            <input checked="" class="peer sr-only" name="theme" type="radio" value="light"/>
	            <div class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 border-slate-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
	              <div class="h-16 w-full rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center">
	                <span class="material-symbols-outlined text-yellow-500 text-3xl">light_mode</span>
	              </div>
	              <span class="text-sm font-medium text-slate-900">Light Mode</span>
	            </div>
	          </label>
	          <label class="cursor-pointer">
	            <input class="peer sr-only" name="theme" type="radio" value="dark"/>
	            <div class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 border-slate-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
	              <div class="h-16 w-full rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center">
	                <span class="material-symbols-outlined text-blue-400 text-3xl">dark_mode</span>
	              </div>
	              <span class="text-sm font-medium text-slate-900">Dark Mode</span>
	            </div>
	          </label>
	          <label class="cursor-pointer">
	            <input class="peer sr-only" name="theme" type="radio" value="system"/>
	            <div class="flex flex-col items-center gap-3 p-4 rounded-xl border-2 border-slate-100 peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
	              <div class="h-16 w-full rounded-lg bg-gradient-to-r from-slate-50 to-slate-800 border border-slate-200 flex items-center justify-center">
	                <span class="material-symbols-outlined text-slate-400 text-3xl">desktop_windows</span>
	              </div>
	              <span class="text-sm font-medium text-slate-900">System Default</span>
	            </div>
	          </label>
	        </div>
	      </div>
	    </div>
	    <!-- Footer / Save Actions -->
	    <div class="flex items-center justify-between bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
	      <div class="flex flex-col">
	        <p class="text-sm text-slate-500">Các thay đổi chưa được lưu sẽ bị mất.</p>
	      </div>
	      <div class="flex gap-3">
	        <button class="px-6 py-2.5 rounded-lg border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-50">
	        Loại bỏ
	        </button>
	        <button class="px-8 py-2.5 rounded-lg bg-primary text-white font-bold text-sm hover:bg-primary/90 shadow-md shadow-primary/20">
	        Lưu thay đổi
	        </button>
	      </div>
	    </div>
	  </div>
</template>
<style scoped>

</style>
