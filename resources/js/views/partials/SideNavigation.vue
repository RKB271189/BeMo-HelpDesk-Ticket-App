<template>
    <aside class="body__sidebar sidebar">
        <nav class="sidebar__menu">
            <router-link to="/" class="sidebar__menu-item sidebar__menu-item--active">Dashboard</router-link>
            <router-link to="/tickets" class="sidebar__menu-item">Tickets</router-link>
            <router-link to="/ticket/new" class="sidebar__menu-item">Create New</router-link>
        </nav>
    </aside>
</template>