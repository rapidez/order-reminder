<script>
import { GraphQLError } from 'Vendor/rapidez/core/resources/js/fetch'
import { mask, refreshMask } from 'Vendor/rapidez/core/resources/js/stores/useMask'
import InteractWithUser from 'Vendor/rapidez/core/resources/js/components/User/mixins/InteractWithUser'

export default {
    mixins: [InteractWithUser],
    render() {},

    methods: {
        addFromSearchParams() {
            const skus = Turbo.navigator.location.searchParams.get('skus') ? Turbo.navigator.location.searchParams.get('skus').split(',') : null
            if (skus) {
                console.log(skus);
                this.multipleAddToCart(skus)
                Turbo.navigator.location.searchParams.delete('skus')
                Turbo.navigator.history.replace(Turbo.navigator.location)
            }
        },
        async multipleAddToCart(skus) {
            console.log('multipleAddToCart')

            if (!mask.value) {
                await refreshMask()
            }

            if (skus) {
                try {
                    const cartItems = skus.map(sku => ({
                        sku: sku,
                        quantity: 1
                    }));

                    let response = await window.magentoGraphQL(
                        `mutation (
                            $cartId: String!,
                            $cartItems: [CartItemInput!]!
                        ) {
                            addProductsToCart(cartId: $cartId, cartItems: $cartItems) {
                                cart { ${config.queries.cart} }
                                user_errors {
                                    code
                                    message
                                }
                            }
                        }`,
                        {
                            cartId: mask.value,
                            cartItems: cartItems
                        }
                    )
                    if (response.data.addProductsToCart.user_errors.length > 0) {
                        response.data.addProductsToCart.user_errors.forEach(error => {
                            Notify(error.message, 'error')
                        })
                    } else {
                        await this.updateCart({}, response)
                        Notify(window.config.translations.order_reminder.added, 'success');
                    }
                } catch (error) {
                    Notify(error.message, 'error')
                }
            }
        }
    },
    mounted() {
        this.addFromSearchParams()
    },
}
</script>
