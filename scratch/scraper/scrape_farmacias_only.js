const { chromium } = require('playwright');
const fs = require('fs');

const estados = [
    "Amazonas", "Anzoategui", "Apure", "Aragua", "Barinas", "Bolivar",
    "Carabobo", "Cojedes", "Delta-Amacuro", "Distrito-Capital", "Falcon",
    "Guarico", "Lara", "Merida", "Miranda", "Monagas", "Nueva-Esparta",
    "Portuguesa", "Sucre", "Tachira", "Trujillo", "Vargas", "Yaracuy", "Zulia"
];

(async () => {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    const data = { farmacias: {} };

    for (const estado of estados) {
        try {
            await page.goto(`http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-${estado}`, { waitUntil: 'domcontentloaded', timeout: 8000 });
            
            // Extract the whole body text
            const text = await page.evaluate(() => document.body.innerText);
            
            // Extract the part after "Estado X" and before "Volver a Farmacias"
            let targetHeader = `Localizacion Farmacias IVSS: Estado ${estado.replace('-', ' ')}`;
            if (!text.includes(targetHeader)) {
                targetHeader = `Localización Farmacias IVSS: Estado ${estado.replace('-', ' ')}`;
            }
            
            const parts = text.split(targetHeader);
            if (parts.length > 2) {
                let relevantText = parts[2].split('Volver a Farmacias')[0];
                data.farmacias[estado.replace('-', ' ')] = relevantText.trim();
            } else if (parts.length > 1) {
                let relevantText = parts[1].split('Volver a Farmacias')[0];
                data.farmacias[estado.replace('-', ' ')] = relevantText.trim();
            } else {
                data.farmacias[estado.replace('-', ' ')] = "No se encontro la cabecera";
            }
            console.log(`✅ Farmacias ${estado} extraido`);
        } catch(e) { 
            console.log(`❌ Farmacias ${estado} error: ${e.message.split('\n')[0]}`); 
        }
    }
    
    fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_raw.json', JSON.stringify(data, null, 2));
    await browser.close();
})();
