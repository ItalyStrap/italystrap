/**
 * Writes the package.json version into the theme headers, run by `npm version`.
 */
import { readFileSync, writeFileSync } from 'node:fs';

const version = process.env.npm_package_version;

if ( ! version ) {
	throw new Error( 'Run it through `npm version <version>`.' );
}

const headers = {
	'style.css': /^(\s*\*\s*Version:\s*).*$/m,
	'readme.txt': /^(Stable tag:\s*).*$/m,
};

for ( const [ file, pattern ] of Object.entries( headers ) ) {
	const content = readFileSync( file, 'utf8' );

	if ( ! pattern.test( content ) ) {
		throw new Error( `No version header found in ${ file }.` );
	}

	writeFileSync( file, content.replace( pattern, `$1${ version }` ) );
}
