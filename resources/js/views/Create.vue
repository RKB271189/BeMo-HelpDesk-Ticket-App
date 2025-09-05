<template>
    <PageLayout>
        <template #page_content>
            <form class="ticket-form">
                <div class="ticket-form__group">
                    <label for="subject" class="ticket-form__label">Subject</label>
                    <input type="text" id="subject" class="ticket-form__input" placeholder="Enter ticket subject" />
                </div>
                <div class="ticket-form__group ticket-form__group--textarea">
                    <label for="body" class="ticket-form__label">Body</label>
                    <span class="ticket-form__charcount" id="body-count">0 / 500</span>
                    <textarea id="body" class="ticket-form__textarea" placeholder="Enter ticket details..."
                        maxlength="500"></textarea>
                </div>
                <button type="submit" class="button button--primary">
                    Submit
                </button>
            </form>
        </template>
    </PageLayout>
</template>

<script>
import PageLayout from './components/PageLayout.vue';
export default {
    components: {
        PageLayout
    }
};
</script>