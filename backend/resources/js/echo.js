import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`, // or use session data
        }
    }
});

// Subscribe to the user's private channel
window.Echo.private('user.' + userId)
    .listen('ShiftAssignedEvent', (event) => {
        console.log('Shift Assigned:', event);  // This will log the event data
    });
