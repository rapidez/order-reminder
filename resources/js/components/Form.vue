<script>
export default {
        render() {
            return this.$scopedSlots.default(this)
        },
        props: {
            productSkus: {
                type: Array,
                required: false
            },
            orderReminder: {
                type: [Object,Boolean],
                required: false,
                default: false
            },
            defaultTimespan: {
                type: Number,
                required: false,
                default: 1
            }
        },
        data() {
            return {
                show: false,
                variables: {
                    email: this.$root.guestEmail,
                    timespan: 1,
                    products: []
                }
            }
        },
        methods: {
            toggleForm() {
                this.show = !this.show
            },
            submitForm() {
                window.rapidezAPI(
                    this.orderReminder ? 'put' : 'post',
                    'order-reminders' + (this.orderReminder ? '/' + this.orderReminder.id : ''),
                    {
                        email: this.variables.email,
                        timespan: this.variables.timespan,
                        products: this.variables.products
                    }
                ).then(response => {
                    this.toggleForm()
                    if (this.orderReminder) {
                        Notify(window.config.translations.order_reminder.update
                            .replace('%1', `${response.orderReminder.timespan} ${window.config.translations.order_reminder.week[+(response.orderReminder.timespan !== 1)]}`)
                            .replace('%2', new Date(response.orderReminder.reminder_date)
                                .toLocaleDateString(window.navigator.language,
                                    { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }))
                        , 'success')
                        window.app.$emit('refreshOrderReminders')
                    } else {
                        Notify(window.config.translations.order_reminder.add, 'success')
                    }

                    if ('dataLayer' in window) {
                        window.dataLayer.push({
                            event: 'order_reminder',
                            reminder: this.variables
                        })
                    }
                    this.$el.dispatchEvent(
                        new CustomEvent('submitOrderReminder', {
                            bubbles: true
                        })
                    )
                }).catch(response => {
                    this.toggleForm()
                    if (response?.response?.status === 403) {
                        Notify(window.config.translations.order_reminder.unauthorized, 'error')
                    } else {
                        Notify(window.config.translations.order_reminder.error, 'error')
                    }
                })
            },
            submitDelete() {
                if (confirm(window.config.translations.order_reminder.confirm_delete)) {
                    window.rapidezAPI(
                        'delete',
                        `order-reminders/${ this.orderReminder.id }`,
                        {}
                    ).then(() => {
                        this.toggleForm()
                        Notify(window.config.translations.order_reminder.delete, 'success')
                        window.app.$emit('refreshOrderReminders')
                        this.$el.dispatchEvent(
                            new CustomEvent('deleteOrderReminder', {
                                bubbles: true
                            })
                        )
                    })
                }
            }
        },
        watch: {
            productSkus: function(newVal, oldVal) {
                if (!window.app.$data.loading) {
                    this.variables.products = this.productSkus
                }
            }
        },
        mounted() {
            if (this.orderReminder) {
                this.variables.email = this.orderReminder.email
                this.variables.timespan = this.orderReminder.timespan
                this.variables.products = Object.values(this.orderReminder.products).map(item => item.sku)
            } else if (this.productSkus && this.productSkus.length === 1) {
                this.variables.products.push(this.productSkus[0])
            }

            if (!this.orderReminder && this.productSkus.length >= 1) {
                this.variables.timespan = this.defaultTimespan
            }
        }
    }
</script>
