import tailwindcss from '@tailwindcss/vite';
import legacy from '@vitejs/plugin-legacy';
import { glob } from 'glob';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import manifestSRI from 'vite-plugin-manifest-sri';

/**
 * Get Files from a directory
 * @param {string} query
 * @returns array
 */
function GetFilesArray(query) {
    return glob.sync(query);
}

// JS Files
const pageJsFiles = GetFilesArray('resources/js/*.js');

// CSS Files
const pageCssFiles = GetFilesArray('resources/css/*.css');

// Libs Files
const LibsJsFiles = GetFilesArray('resources/libs/**/*.js');

// CSS Libs Files
const LibsCssFiles = GetFilesArray('resources/libs/**/*.css');

// SCSS files
const FontsScssFiles = GetFilesArray('resources/libs/fonts/!(_)*.scss');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...pageJsFiles,
                ...pageCssFiles,
                ...LibsJsFiles,
                ...LibsCssFiles,
                ...FontsScssFiles,
            ],
            refresh: true,
        }),
        tailwindcss(),
        legacy({
            renderLegacyChunks: true,
            polyfillNames: ['es.promise', 'es.array.from']
        }),
        manifestSRI(),
    ],
    optimizeDeps: {
        esbuildOptions: {
            define: {
                global: 'globalThis',
            },
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.indexOf('node_modules') !== -1) {
                        const basic = id.toString().split('node_modules/')[1];
                        const sub1 = basic.split('/')[0];
                        if (sub1 !== '.pnpm') {
                            return sub1.toString();
                        }
                        const name2 = basic.split('/')[1];
                        return name2.split('@')[name2[0] === '@' ? 1 : 0].toString();
                    }
                },
            },
        },
    },
});
