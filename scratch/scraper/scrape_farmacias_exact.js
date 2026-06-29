const { chromium } = require('playwright');
const fs = require('fs');

const urls = [
  "http://www.ivss.gov.ve/contenido/-Localizacion-Farmacias-IVSS--Estado-Sucre",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Miranda",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado----Anzoategui",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Apure",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Aragua",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Barinas",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Bolivar",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Carabobo",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Cojedes",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Falcon",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Guarico",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Lara",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias--IVSS:-Estado--Merida",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Nueva-Esparta",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Portuguesa",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Tachira",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Trujillo",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:--Estado-Monagas",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Yaracuy",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Vargas",
  "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-Zulia"
];

(async () => {
    const browser = await chromium.launch({ headless: true });
    const page = await browser.newPage();
    const data = { farmacias: {} };

    for (const url of urls) {
        try {
            await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 8000 });
            let text = await page.evaluate(() => document.body.innerText);
            
            let estadoMatch = url.match(/Estado-+(.+)$/i);
            if(!estadoMatch) estadoMatch = url.match(/Estado--(.+)$/i);
            if(!estadoMatch) estadoMatch = url.match(/Estado-(.+)$/i);
            let estado = estadoMatch ? estadoMatch[1].replace(/-/g, ' ') : url;
            if(estado == "Nueva Esparta") estado = "Nueva Esparta";
            
            // Extract the part after the header and before "Volver a Farmacias"
            let targetHeader = `Farmacias IVSS:? Estado`;
            let regex = new RegExp(`(?:Localizaci[oó]n )?Farmacias IVSS:? Estado[^\n]*\n`, 'i');
            
            let parts = text.split(regex);
            if (parts.length > 1) {
                let relevantText = parts[1].split(/Volver a Farmacias|Convocatoria a Concurso/i)[0];
                data.farmacias[estado] = relevantText.trim();
            } else {
                data.farmacias[estado] = "No se encontro la cabecera";
            }
            console.log(`✅ ${estado}`);
        } catch(e) { 
            console.log(`❌ ${url} error: ${e.message.split('\n')[0]}`); 
        }
    }
    
    fs.writeFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_exact.json', JSON.stringify(data, null, 2));
    await browser.close();
})();
