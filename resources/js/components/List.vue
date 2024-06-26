<script>
    export default {
         props: {
            limit: {
                type: Number,
                default: null
            },
         },
        render() {
            return this.$scopedSlots.default(this)
        },
        data() {
            return {
                orderReminders: {},
                loading: false
            }
        },
        methods: {
            async getOrderReminders() {
                this.loading = true
                const url = this.limit ? `order-reminders?limit=${this.limit}` : 'order-reminders';
                await window.rapidezAPI('get', url).then(response => {
                    this.orderReminders = response.orderReminders.sort((a, b) => Date.parse(a.reminder_date) - Date.parse(b.reminder_date))
                }).finally(() => {
                    this.loading = false
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
