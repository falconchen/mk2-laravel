const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants: {
        extend: {
            backgroundColor: ['active'],
        }
    },
    content: [
        './app/**/*.php',
        './resources/**/*.html',
        './resources/**/*.js',
        './resources/**/*.jsx',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.twig',
    ],
    /**
    保留未使用的类名,参考：
    https://github.com/tailwindlabs/tailwindcss/discussions/6557
    https://tailwindcss.com/docs/content-configuration#safelisting-classes
    **/
    // safelist: [
    // {
    //   pattern: /./,
    // //   variants: ['lg', 'hover', 'focus', 'lg:hover'], //上面的pattern不会包含带 : 的类，但打开这条会内存不足，fuck
    // },

    // ],

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
