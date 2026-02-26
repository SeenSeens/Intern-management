const { createApp } = Vue
const { createRouter, createWebHashHistory } = VueRouter

// Pages
const Dashboard = {
    template: `<h1 class="text-2xl font-bold">Bảng tin</h1>`
}

const Members = {
    template: `<h1 class="text-2xl font-bold">Thành viên</h1>`
}

const Project = {
    template: `<h1 class="text-2xl font-bold">Dự án</h1>`
}

// Router
const routes = [
    { path: '/', component: Dashboard },
    { path: '/members', component: Members },
    { path: '/project', component: Project },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
})

// App Layout
const app = createApp({
    template: `
        <div class="flex h-screen">

            <aside class="w-64 bg-white border-r p-4">
                <router-link to="/" class="block p-2" active-class="text-blue-500">Bảng tin</router-link>
                <router-link to="/members" class="block p-2" active-class="text-blue-500">Thành viên</router-link>
                <router-link to="/project" class="block p-2" active-class="text-blue-500">Dự án</router-link>
            </aside>

            <main class="flex-1 p-8">
                <router-view></router-view>
            </main>

        </div>
    `
})

app.use(router)
app.mount('#app')