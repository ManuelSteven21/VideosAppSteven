<template>
    <div class="notifications">
        <h2 class="font-bold text-lg mb-4">Notificacions</h2>
        <ul class="space-y-2">
            <li v-for="(notification, index) in notifications" :key="index" class="bg-white p-4 rounded shadow">
                <p class="text-gray-800 font-semibold">📽️ Nou vídeo: {{ notification.data.title }}</p>
                <p class="text-sm text-gray-500">📅 Publicat: {{ notification.data.published_at }}</p>
                <a :href="notification.data.url" class="text-red-600 text-sm underline">Veure</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: []
        };
    },
    mounted() {
        console.log("📦 Component Notifications muntat");

        // Carregar notificacions existents de la base de dades
        axios.get('/api/notifications').then(response => {
            this.notifications = response.data;
        });

        // Afegir les noves per temps real
        window.Echo.channel('videos')
            .listen('.video.created', (e) => {
                console.log('🔔 Rebut vídeo:', e);
                this.notifications.unshift({
                    data: {
                        title: e.video.title,
                        published_at: e.video.formatted_published_at,
                        url: `/videos/${e.video.id}`
                    }
                });
            });
    }
};
</script>

<style scoped>
.notifications {
    background: #f3f4f6;
    padding: 1rem;
    border-radius: 8px;
    max-width: 600px;
}
</style>
