<script>
    export default {
        render() {
            return this.$scopedSlots.default(this)
        },
        data() {
            return {
                orderReminders: {}
            }
        },
        methods: {
            async getOrderReminders() {
                await window.rapidezAPI('get', 'order-reminders').then(response => {
                    this.orderReminders = response.orderReminders.sort((a, b) => Date.parse(a.reminder_date) - Date.parse(b.reminder_date))
                });
            }
        },
        created() {
            window.app.$on('refreshOrderReminders', () => {
                this.getOrderReminders()
            })
        },
        mounted() {
            window.app.$emit('refreshOrderReminders')
        }
    }
</script>
