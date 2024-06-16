import { defineConfig } from 'vitepress'

let year = new Date().getFullYear();

const title = 'Cart'
const description = 'Simplifying Shopping Cart Management for Laravel'
const url = 'https://realrashid.github.io/cart/'
const image = `https://api.placid.app/u/2wagk?hl=Cart&img=https://realrashid.github.io/cart&subline=Simplifying%20Shopping%20Cart%20Management%20for%20Laravel`
const twitter = 'rashidali05'
const github = 'https://github.com/realrashid/cart'
const linkedin = 'https://linkedin.com/in/realrashid'

export default defineConfig({
    lang: 'en-US',
    title,
	description,
    ignoreDeadLinks: true,
    base: '/cart/',
    lastUpdated: true,
    cleanUrls: true,
    appearance: 'dark',
    markdown: {
        defaultHighlightLang: 'php',
        theme: {
            dark: 'material-theme-palenight',
            light: 'github-light',
        },
    },

    head: [
        ['link', { rel: 'icon', type: 'image/svg+xml', href: '/logo.svg' }],
		['meta', { property: 'og:type', content: 'website' }],
		['meta', { property: 'og:title', content: title }],
		['meta', { property: 'og:image', content: image }],
		['meta', { property: 'og:url', content: url }],
		['meta', { property: 'og:description', content: description }],
		['meta', { name: 'twitter:card', content: 'summary_large_image' }],
		['meta', { name: 'twitter:image', content: image }],
		['meta', { name: 'twitter:site', content: `@${twitter}` }],
		['meta', { name: 'twitter:title', content: title }],
		['meta', { name: 'twitter:description', content: description }],
		['meta', { name: 'theme-color', content: '#064e3b' }],
        [
            'script',
            { async: '', src: 'https://www.googletagmanager.com/gtag/js?id=G-KBKGCY1PJH' }
        ],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-KBKGCY1PJH');`
        ]

    ],

    themeConfig: {

        logo: { src: '/logo-mini.svg', width: 24, height: 24 },

        nav: [
            { text: 'Get Started', link: '/guide/introduction' },
            { text: 'Installation', link: '/guide/installation' },
            { text: 'Demo App', link: '/demo/demo' },
        ],

        sidebar: [
            {
                text: 'Guide',
                collapsed: false,
                items: [
                    { text: 'Introduction', link: '/guide/introduction' },
                    { text: 'Installation', link: '/guide/installation' },
                    { text: 'Configuration', link: '/guide/configuration' },
                ]
            },
            {
                text: 'Usage',
                collapsed: false,
                items: [
                    { text: 'Usage', link: '/usage/usage' },
                    { text: 'Cart Instance', link: '/usage/instance' },
                    { text: 'Adding Item To Cart', link: '/usage/add' },
                    { text: 'Adding Items To Cart', link: '/usage/add-multiple' },
                    { text: 'Associate Model with Cart Item', link: '/usage/associate' },
                    { text: 'Get All Cart Items', link: '/usage/get-all' },
                    { text: 'Update Item Details', link: '/usage/update-details' },
                    { text: 'Update Quantity', link: '/usage/update-quantity' },
                    { text: 'Update Item Name', link: '/usage/update-name' },
                    { text: 'Update Item Price', link: '/usage/update-price' },
                    { text: 'Update Item Options', link: '/usage/update-options' },
                    { text: 'Remove Item from Cart', link: '/usage/remove' },
                    { text: 'Clear Cart', link: '/usage/clear' },
                    { text: 'Cart Subtotal', link: '/usage/subtotal' },
                    { text: 'Cart Tax', link: '/usage/tax' },
                    { text: 'Cart Total', link: '/usage/total' },
                    { text: 'Count Cart', link: '/usage/count' },
                    { text: 'Empty Cart', link: '/usage/empty' },
                ]
            },
            {
                text: 'Example',
                collapsed: false,
                items: [
                    { text: 'Add to Cart', link: '/example/add-to-cart' },
                    { text: 'Show Cart Items', link: '/example/show-cart-items' },
                    { text: 'Update Item Quantity', link: '/example/update-item' },
                    { text: 'Remove Cart Item', link: '/example/remove-item' },
                    { text: 'Clear Cart', link: '/example/clear-cart' },
                ]
            },
            {
                text: 'Demo App',
                collapsed: false,
                items: [
                    { text: 'Demo App', link: '/demo/demo' },
                    { text: 'Get Started', link: '/demo/get-started' },
                ]
            },
        ],

        editLink: {
            pattern: `${github}/edit/main/docs/:path`,
            text: 'Suggest changes to this page',
        },

        socialLinks: [
			{ icon: 'twitter', link: `https://twitter.com/${twitter}` },
			{ icon: 'github', link: `${github}` },
		],

        footer: {
            message: '<p align="center"> <b>Made with ❤️ from Pakistan</b> </p> Released under the <a href="https://github.com/realrashid/cart/blob/main/LICENSE">MIT License</a>.',
            copyright: `Copyright © ${year} <a href="https://github.com/realrashid">Rashid Ali</a>`
        },

        search: {
            provider: 'local'
        },
    }
})
