const fs = require('fs');

const raw1 = JSON.parse(fs.readFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_raw.json'));
const combined = {};

for(const e in raw1.farmacias) {
    if(raw1.farmacias[e] && raw1.farmacias[e].length > 40 && !raw1.farmacias[e].includes('No se encontro')) {
        let text = raw1.farmacias[e].replace(/\r/g, '').trim();
        let lines = text.split(/\n\s*\n/).map(s => s.trim()).filter(s => s.length > 5 && !s.includes('Volver a Farmacias'));
        
        let centros = [];
        for (let lineGroup of lines) {
            let l = lineGroup.split('\n').map(x=>x.trim()).filter(x=>x.length>0);
            if (l.length >= 3) {
                centros.push({ nombre: l[0], direccion: l.slice(1, l.length-1).join(', '), telefono: l[l.length-1] });
            } else if (l.length === 2) {
                 centros.push({ nombre: l[0], direccion: l[1], telefono: "No disponible" });
            }
        }
        
        if (centros.length === 0) {
            let l = text.split('\n').map(x=>x.trim()).filter(x=>x.length>0);
            for(let i=0; i<l.length; i+=3) {
                 if(l[i] && l[i+1]) {
                      centros.push({ nombre: l[i], direccion: l[i+1], telefono: l[i+2] || "No disponible" });
                 }
            }
        }
        combined[e] = centros;
    }
}

fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_final.json', JSON.stringify(combined, null, 2));
