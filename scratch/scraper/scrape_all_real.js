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
    const data = { farmacias: {}, centros: {}, oficinas: {} };

    for (const estado of estados) {
        // Farmacias
        try {
            await page.goto(`http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-${estado}`, { waitUntil: 'domcontentloaded', timeout: 5000 });
            const text = await page.evaluate(() => document.body.innerText);
            data.farmacias[estado] = text.split(`Localizacion Farmacias IVSS: Estado ${estado.replace('-', ' ')}`)[2] || text.split(`Localización Farmacias IVSS: Estado ${estado.replace('-', ' ')}`)[2] || text.substring(0, 500);
            console.log(`Farmacias ${estado} done`);
        } catch(e) { console.log(`Farmacias ${estado} fail`); }
    }
    
    fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/all_data.json', JSON.stringify(data, null, 2));
    await browser.close();
})();
