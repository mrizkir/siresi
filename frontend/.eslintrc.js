module.exports = {
  root: true,
  env: {
    node: true
  },
  'extends': [
    'plugin:vue/essential',
    'plugin:prettier/recommended',
    'eslint:recommended',
  ],
  parserOptions: {
    parser: 'babel-eslint',
  },
  rules: {
    'prettier/prettier': [
      'warn',
      {
        singleQuote: true,
        useTabs:false,
        semi: false,
        trailingComma: 'es5',
        vueIndentScriptAndStyle: true,
      }
    ],    
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off'
  }
}
