import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import { terser } from 'rollup-plugin-terser';
import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss';
import pkg from './package.json';

const production = !process.env.ROLLUP_WATCH;

export default [
  // UMD build
  {
    input: 'assets/js/index.js',
    output: {
      name: 'CSSAnimationBuilder',
      file: pkg.unpkg,
      format: 'umd',
      sourcemap: true
    },
    plugins: [
      resolve({
        browser: true,
        preferBuiltins: false
      }),
      commonjs(),
      babel({
        babelHelpers: 'bundled',
        exclude: 'node_modules/**',
        presets: [
          ['@babel/preset-env', {
            targets: {
              browsers: ['> 1%', 'last 2 versions']
            }
          }]
        ]
      }),
      postcss({
        extract: true,
        minimize: production,
        sourceMap: true
      }),
      production && terser()
    ]
  },
  // ES module build
  {
    input: 'assets/js/index.js',
    output: {
      file: pkg.module,
      format: 'es',
      sourcemap: true
    },
    plugins: [
      resolve(),
      commonjs(),
      babel({
        babelHelpers: 'bundled',
        exclude: 'node_modules/**',
        presets: [
          ['@babel/preset-env', {
            targets: {
              browsers: ['> 1%', 'last 2 versions']
            }
          }]
        ]
      }),
      postcss({
        extract: false,
        inject: false
      })
    ]
  },
  // CommonJS build
  {
    input: 'assets/js/index.js',
    output: {
      file: pkg.main,
      format: 'cjs',
      sourcemap: true
    },
    plugins: [
      resolve(),
      commonjs(),
      babel({
        babelHelpers: 'bundled',
        exclude: 'node_modules/**',
        presets: [
          ['@babel/preset-env', {
            targets: {
              node: '12'
            }
          }]
        ]
      }),
      postcss({
        extract: false,
        inject: false
      })
    ]
  }
];
