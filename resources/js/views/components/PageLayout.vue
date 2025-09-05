<template>
    <div class="layout">
        <Header />
        <div class="layout__body body">
            <SideNavigation />
            <main class="body__content content">
                <slot name="page_content" />
            </main>
        </div>
    </div>
</template>
<script>
import Header from '../partials/Header.vue';
import SideNavigation from '../partials/SideNavigation.vue';
export default {
    components: {
        Header,
        SideNavigation
    }
}
</script>
