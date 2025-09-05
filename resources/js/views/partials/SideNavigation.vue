<template>
    <aside class="body__sidebar sidebar">
        <nav class="sidebar__menu">
            <router-link to="/" class="sidebar__menu-item"
                :class="{ 'sidebar__menu-item--active': $route.path === '/' }">Dashboard</router-link>
            <router-link to="/tickets" class="sidebar__menu-item"
                :class="{ 'sidebar__menu-item--active': $route.path === '/tickets' }">Tickets</router-link>
            <router-link to="/ticket/new" class="sidebar__menu-item"
                :class="{ 'sidebar__menu-item--active': $route.path === '/ticket/new' }">Create New</router-link>
        </nav>
    </aside>
</template>