const { chromium } = require('playwright');
const fs = require('fs');

const estados = [
    'Amazonas', 'Anzoategui', 'Apure', 'Aragua', 'Barinas', 'Bolivar', 'Carabobo', 'Cojedes', 
    'Delta-Amacuro', 'Distrito-Capital', 'Falcon', 'Guarico', 'Lara', 'Merida', 'Miranda', 
    'Monagas', 'Nueva-Esparta', 'Portuguesa', 'Sucre', 'Tachira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'
];

async function run() {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    const results = { farmacias: {}, centros: {}, oficinas: {} };

    for (const estado of estados) {
        console.log(`Scraping Farmacias: ${estado}...`);
        try {
            const url = estado === 'Distrito-Capital' 
                ? 'http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital'
                : `http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-${estado}`;
            await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 10000 });
            const content = await page.locator('.contenido').innerText();
            if (!content.includes('compromiso patrio')) results.farmacias[estado] = content;
        } catch (e) { console.error(e); }

        console.log(`Scraping Centros: ${estado}...`);
        try {
            const url = estado === 'Distrito-Capital' 
                ? 'http://www.ivss.gov.ve/contenido/Centros-de-Salud-IVSS:-Distrito-Capital'
                : `http://www.ivss.gov.ve/contenido/Centros-de-Salud-IVSS:-Estado-${estado}`;
            await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 10000 });
            const content = await page.locator('.contenido').innerText();
            if (!content.includes('compromiso patrio')) results.centros[estado] = content;
        } catch (e) { console.error(e); }

        console.log(`Scraping Oficinas: ${estado}...`);
        try {
            const url = estado === 'Distrito-Capital' 
                ? 'http://www.ivss.gov.ve/contenido/Oficinas-Administrativas:-Distrito-Capital'
                : `http://www.ivss.gov.ve/contenido/Oficinas-Administrativas:-Estado-${estado}`;
            await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 10000 });
            const content = await page.locator('.contenido').innerText();
            if (!content.includes('compromiso patrio')) results.oficinas[estado] = content;
        } catch (e) { console.error(e); }
    }

    fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/data.json', JSON.stringify(results, null, 2));
    await browser.close();
    console.log("Scraping complete!");
}

run();
