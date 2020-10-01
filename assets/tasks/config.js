const files = [
    '**', // All

    /**
     * Exclude directories
     */
    '!.git/**',
    '!.sass-cache/**',
    '!.tscache/**',
    '!_others',
    '!node_modules/**',
    '!backups/**',
    '!bower/**',
    '!future-inclusions/**',
    '!assets/css/src/**',
    '!assets/img/src/**',
    '!assets/js/src/**',
    '!assets/sass/**',
    '!assets/tasks/**',
    '!assets/ts/**',
    '!**/test*/**',

    /**
     * Exclude files
     */
    '!codecept',
    '!.gitattributes',
    '!.gitignore',
    '!snippets.md',
    '!bower.json',
    '!Gruntfile.js',
    '!Gulpfile.js',
    '!package.json',
    '!package-lock.json',
    '!**/c3.php',
    '!**/infection.*',
    '!**/*.bat',
    '!**/*.cmd',
    '!**/*.dist',
    '!**/*.lock',
    '!**/*.neon',
    '!**/*.phar',
    '!**/*.yml',
    '!**/*.zip',
    '!**/*.xml',
    '!**/*.map',
];

module.exports = {
    files
};