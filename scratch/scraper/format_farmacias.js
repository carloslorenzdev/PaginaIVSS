const fs = require('fs');
const data = JSON.parse(fs.readFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_exact.json', 'utf8'));

let output = 'const farmaciasData = {\n';

for (let [estado, text] of Object.entries(data.farmacias)) {
    // Normalise newlines
    text = text.replace(/\r/g, '').trim();
    let lines = text.split(/\n\s*\n/).map(s => s.trim()).filter(s => s.length > 5 && !s.includes('Volver a Farmacias'));
    
    // Some lines might just be single \n
    if(lines.length === 1 && lines[0].split('\n').length >= 3) {
        lines = text.split('\n\n').map(s => s.trim()).filter(s => s.length > 5);
        if(lines.length === 1) {
            lines = text.split('\n').map(s => s.trim()).filter(s => s.length > 5);
            // In this case, we group by 3s or parse them
        }
    }
    
    let centros = [];
    
    for (let lineGroup of lines) {
        let l = lineGroup.split('\n').map(x=>x.trim()).filter(x=>x.length>0);
        if (l.length >= 3) {
            centros.push(`                { nombre: "${l[0].replace(/"/g, '\\"')}", direccion: "${l[1].replace(/"/g, '\\"')}", telefono: "${l[l.length-1].replace(/"/g, '\\"')}" }`);
        } else if (l.length === 2) {
             centros.push(`                { nombre: "${l[0].replace(/"/g, '\\"')}", direccion: "${l[1].replace(/"/g, '\\"')}", telefono: "" }`);
        } else if (l.length > 3) {
            centros.push(`                { nombre: "${l[0].replace(/"/g, '\\"')}", direccion: "${l.slice(1, l.length-1).join(', ').replace(/"/g, '\\"')}", telefono: "${l[l.length-1].replace(/"/g, '\\"')}" }`);
        }
    }
    
    if (centros.length === 0) {
        // Fallback for weirdly formatted
        let l = text.split('\n').map(x=>x.trim()).filter(x=>x.length>0);
        for(let i=0; i<l.length; i+=3) {
             if(l[i] && l[i+1] && l[i+2]) {
                  centros.push(`                { nombre: "${l[i].replace(/"/g, '\\"')}", direccion: "${l[i+1].replace(/"/g, '\\"')}", telefono: "${l[i+2].replace(/"/g, '\\"')}" }`);
             }
        }
    }
    
    output += `            "${estado}": [\n${centros.join(',\n')}\n            ],\n`;
}

output += '};\n';
fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/formatted_farmacias.txt', output);
