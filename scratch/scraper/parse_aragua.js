const fs = require('fs');

function processFile(inFile, outFile) {
    let html = '';
    try { html = fs.readFileSync(inFile, 'utf16le'); } 
    catch(e) { html = fs.readFileSync(inFile, 'utf8'); }

    // Convert encoding artifacts
    html = html.replace(/\0/g, '');

    const stripped = html.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '')
                         .replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '')
                         .replace(/<[^>]+>/g, '\n')
                         .replace(/\n\s*\n/g, '\n')
                         .split('\n')
                         .map(l => l.trim())
                         .filter(l => l.length > 5);

    fs.writeFileSync(outFile, stripped.slice(0, 100).join('\n'));
}

processFile('c:/laragon/www/PaginaIVSS/scratch/scraper/aragua.html', 'c:/laragon/www/PaginaIVSS/scratch/scraper/aragua.txt');
processFile('c:/laragon/www/PaginaIVSS/scratch/scraper/c_aragua.html', 'c:/laragon/www/PaginaIVSS/scratch/scraper/c_aragua.txt');
processFile('c:/laragon/www/PaginaIVSS/scratch/scraper/o_aragua.html', 'c:/laragon/www/PaginaIVSS/scratch/scraper/o_aragua.txt');
