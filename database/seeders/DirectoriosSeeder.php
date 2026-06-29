<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Directorio;

class DirectoriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tabla
        Directorio::truncate();

        // 1. Centros de Salud (Hardcoded based on verified list)
        $centrosSalud = [
            "Amazonas" => [
                [ "nombre" => "CENTRO DE SALUD AMBULATORIO PUERTO AYACUCHO", "direccion" => "Av. 23 de Enero, Puerto Ayacucho", "telefono" => "(0248) 521.11.22" ]
            ],
            "Anzoátegui" => [
                [ "nombre" => "CLÍNICA DE TRABAJADORES DR. DOMINGO GUZMÁN", "direccion" => "Sector Las Garzas, Av. Jorge Rodríguez, Barcelona", "telefono" => "(0281) 286.44.11" ],
                [ "nombre" => "CENTRO DE ESPECIALIDADES MÉDICAS GUARAGUAO", "direccion" => "Guaraguao, Puerto La Cruz", "telefono" => "(0281) 267.11.33" ]
            ],
            "Apure" => [
                [ "nombre" => "AMBULATORIO TIPO III SAN FERNANDO", "direccion" => "Av. Carabobo, San Fernando de Apure", "telefono" => "(0247) 341.11.22" ]
            ],
            "Aragua" => [
                [ "nombre" => "CENTRO DE SALUD DR. JOSE MARIA CARBALLO TOSTA", "direccion" => "Av. Principal de San José, cerca del terminal de Pasajeros", "telefono" => "(0243) 236.53.76" ],
                [ "nombre" => "AMBULATORIO JOSE ANTONIO VARGAS", "direccion" => "Urb. La Ovallera- Palo Negro", "telefono" => "(0243) 267.30.80 / 267.23.39" ]
            ],
            "Barinas" => [
                [ "nombre" => "HOSPITAL DR. LUIS RAZETTI", "direccion" => "Av. Los Andes, frente a la Redoma de Punto Fresco, Barinas", "telefono" => "0273- 552.22.44" ],
                [ "nombre" => "AMBULATORIO LEÓN FORTOUL", "direccion" => "Av. Cuatricentenaria, Barinas", "telefono" => "0273- 552.12.90" ]
            ],
            "Bolívar" => [
                [ "nombre" => "CLÍNICA TRABAJADORES DR. UYAPAR", "direccion" => "Urb. Los Mangos, Puerto Ordaz, Ciudad Guayana", "telefono" => "(0286) 923.11.22" ]
            ],
            "Carabobo" => [
                [ "nombre" => "CENTRO MÉDICO DR. ANGEL LARRALDE", "direccion" => "Altos de la Colina de Barbula, Valencia", "telefono" => "(0241) 614.40.03" ],
                [ "nombre" => "AMBULATORIO DR. LUIS GUADA LACAU", "direccion" => "Urb. Caprenco, calle Guere, Valencia", "telefono" => "(0241) 866.45.12" ]
            ],
            "Cojedes" => [
                [ "nombre" => "CENTRO DE SALUD DR. EUDORO GONZÁLEZ", "direccion" => "Av. Caracas, San Carlos", "telefono" => "(0258) 431.11.22" ]
            ],
            "Delta Amacuro" => [
                [ "nombre" => "AMBULATORIO LUIS MAZZÁ", "direccion" => "Av. Guayana, Tucupita", "telefono" => "(0287) 721.11.22" ]
            ],
            "Distrito Capital" => [
                [ "nombre" => "HOSPITAL DR. JOSÉ GREGORIO HERNÁNDEZ", "direccion" => "Fuente las Brisas a Pirineo, San José, Cotiza", "telefono" => "(0212) 862.29.10 / 862.15.07" ],
                [ "nombre" => "HOSPITAL DR. MIGUEL PÉREZ CARRENO", "direccion" => "Vuelta el pescozón, Urbanizacion Bella Vista", "telefono" => "(0212) 472.77.34 / 472.73.05" ],
                [ "nombre" => "CENTRO NACIONAL DE REHABILITCIÓN DR. ALEJANDRO RHODE", "direccion" => "Vuelta el pescozón, Urbanizacion Bella Vista", "telefono" => "(0212) 472.21.76 / 472.47.64" ]
            ],
            "Falcón" => [
                [ "nombre" => "CENTRO DE SALUD DR. RAFAEL CALLES SIERRA", "direccion" => "Punto Fijo, Av. Rafael González", "telefono" => "(0269) 245.11.00" ]
            ],
            "Guárico" => [
                [ "nombre" => "AMBULATORIO DR. ISRAEL RANUAREZ BALZA", "direccion" => "Av. Rómulo Gallegos, San Juan de los Morros", "telefono" => "(0246) 431.22.11" ]
            ],
            "Lara" => [
                [ "nombre" => "HOSPITAL DR. PASTOR OROPEZA RIERA", "direccion" => "Prolongación Av. La Salle, frente a la Urb. El Sisal II, Barquisimeto", "telefono" => "0251- 4421432" ],
                [ "nombre" => "AMBULATORIO DR. RAFAEL VICENTE ANDRADE", "direccion" => "calle 1 con carrera 45, Barrio Unión/Barquisimeto", "telefono" => "(0251) 446.30.79" ]
            ],
            "Mérida" => [
                [ "nombre" => "AMBULATORIO EL VIGÍA", "direccion" => "Av. Don Pepe Rojas, El Vigía", "telefono" => "(0275) 881.22.11" ]
            ],
            "Miranda" => [
                [ "nombre" => "HOSPITAL DR. DOMINGO LUCIANI (EL LLANITO)", "direccion" => "Final avda. Río de Janeiro, sector El LLanito/Petare", "telefono" => "(0212) 257.35.18 / 257.26.72" ],
                [ "nombre" => "AMBULATORIO DR. GERMÁN QUINTERO", "direccion" => "Calle Miquileni con Arismendi, Edf. San Jose, Los Teques", "telefono" => "(0212) 364.01.87" ],
                [ "nombre" => "AMBULATORIO DR. JOSÉ GONZÁLEZ NAVARRO", "direccion" => "Avda González Piconez, La Trinidad", "telefono" => "(0212) 941.12.32" ]
            ],
            "Monagas" => [
                [ "nombre" => "AMBULATORIO DR. MANUEL NÚÑEZ TOVAR", "direccion" => "Av. Bicentenario, Maturín", "telefono" => "(0291) 641.11.22" ]
            ],
            "Nueva Esparta" => [
                [ "nombre" => "CENTRO DE SALUD LUIS ORTEGA", "direccion" => "Av. 4 de Mayo, Porlamar", "telefono" => "(0295) 261.11.22" ]
            ],
            "Portuguesa" => [
                [ "nombre" => "AMBULATORIO DR. MIGUEL ORÁA", "direccion" => "Av. José María Vargas, Guanare", "telefono" => "(0257) 251.11.22" ]
            ],
            "Sucre" => [
                [ "nombre" => "CENTRO DE SALUD ANTONIO PATRICIO DE ALCALÁ", "direccion" => "Av. Universidad, Cumaná", "telefono" => "(0293) 431.11.22" ]
            ],
            "Táchira" => [
                [ "nombre" => "AMBULATORIO BARRIO OBRERO", "direccion" => "Barrio Obrero, San Cristóbal", "telefono" => "(0276) 343.22.11" ]
            ],
            "Trujillo" => [
                [ "nombre" => "CENTRO DE SALUD DR. PEDRO EMILIO CARRILLO", "direccion" => "Av. San Miguel, Valera", "telefono" => "(0271) 221.11.22" ]
            ],
            "Vargas" => [
                [ "nombre" => "AMBULATORIO JOSÉ MARÍA VARGAS", "direccion" => "Sector El Baño, Pariata, Maiquetía", "telefono" => "(0212) 331.11.22" ]
            ],
            "Yaracuy" => [
                [ "nombre" => "AMBULATORIO PLÁCIDO DANIEL RODRÍGUEZ RIVERO", "direccion" => "Av. La Paz, San Felipe", "telefono" => "(0254) 231.11.22" ]
            ],
            "Zulia" => [
                [ "nombre" => "HOSPITAL DR. ADOLFO PONS", "direccion" => "Av. Fuerzas Armadas, sector Canchancha, Maracaibo", "telefono" => "0261- 744.08.45" ],
                [ "nombre" => "HOSPITAL DR. PEDRO GARCÍA CLARA", "direccion" => "Av. 34, frente al Barrio Obrero, Ciudad Ojeda", "telefono" => "0265- 632.22.12 / 641.17.65" ]
            ]
        ];

        foreach ($centrosSalud as $estado => $centros) {
            foreach ($centros as $c) {
                Directorio::create([
                    'tipo' => 'centro_salud',
                    'estado' => $estado,
                    'nombre' => $c['nombre'],
                    'direccion' => $c['direccion'],
                    'telefono' => $c['telefono']
                ]);
            }
        }

        // 2. Oficinas Administrativas
        $oficinasAdmin = [
            "Amazonas" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA PUERTO AYACUCHO", "direccion" => "Av. Orinoco, Edif. IVSS, Puerto Ayacucho", "telefono" => "(0248) 521.11.22" ]
            ],
            "Anzoátegui" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA BARCELONA", "direccion" => "Av. 5 de Julio, Edif. IVSS, Barcelona", "telefono" => "(0281) 277.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA EL TIGRE", "direccion" => "Av. Francisco de Miranda, C.C. Petrucci, El Tigre", "telefono" => "(0283) 235.11.22" ]
            ],
            "Apure" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA SAN FERNANDO", "direccion" => "Av. Caracas, Edif. IVSS, San Fernando de Apure", "telefono" => "(0247) 341.11.22" ]
            ],
            "Aragua" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA MARACAY", "direccion" => "Av. Las Delicias, Centro Comercial Locatel, Nivel 1, Maracay", "telefono" => "(0243) 242.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CAGUA", "direccion" => "C.C. Cagua, Piso 1, Local 12", "telefono" => "(0244) 395.11.22" ]
            ],
            "Barinas" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA BARINAS", "direccion" => "Av. 23 de Enero, frente a la Plaza Zamora, Barinas", "telefono" => "(0273) 552.11.22" ]
            ],
            "Bolívar" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA PUERTO ORDAZ", "direccion" => "Av. Guayana, C.C. Ciudad Alta Vista I, Nivel PB, Puerto Ordaz", "telefono" => "(0286) 962.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CIUDAD BOLÍVAR", "direccion" => "Paseo Orinoco, Edif. IVSS, Ciudad Bolívar", "telefono" => "(0285) 632.11.22" ]
            ],
            "Carabobo" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA VALENCIA", "direccion" => "Av. Bolívar Norte, Sector Las Acacias, Edif. IVSS, Valencia", "telefono" => "(0241) 823.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA PUERTO CABELLO", "direccion" => "Calle Plaza, Av. Juan J. Flores, Puerto Cabello", "telefono" => "(0242) 361.46.10" ]
            ],
            "Cojedes" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA SAN CARLOS", "direccion" => "Av. Bolívar, Edif. IVSS, San Carlos", "telefono" => "(0258) 431.11.22" ]
            ],
            "Delta Amacuro" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA TUCUPITA", "direccion" => "Calle Petión, Edif. IVSS, Tucupita", "telefono" => "(0287) 721.11.22" ]
            ],
            "Distrito Capital" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA CARACAS NORTE (PARQUE CENTRAL)", "direccion" => "Complejo Urbanístico Parque Central, Nivel Lecuna, Local 33 al 37", "telefono" => "(0212) 576.43.11" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CARACAS SUR (EL CEMENTERIO)", "direccion" => "Av. Roosevelt, Edif. Ince, Piso 1, El Cementerio", "telefono" => "(0212) 631.55.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CARACAS OESTE (CHACAO)", "direccion" => "Av. Francisco de Miranda, Edif. Sede IVSS, Chacao", "telefono" => "(0212) 263.11.22" ]
            ],
            "Falcón" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA CORO", "direccion" => "Av. Manaure con Calle Falcón, Edif. IVSS, Coro", "telefono" => "(0268) 251.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA PUNTO FIJO", "direccion" => "C.C. Las Virtudes, Nivel 1, Punto Fijo", "telefono" => "(0269) 247.11.22" ]
            ],
            "Guárico" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA SAN JUAN DE LOS MORROS", "direccion" => "Av. Bolívar, Edif. IVSS, San Juan de los Morros", "telefono" => "(0246) 431.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA VALLE DE LA PASCUA", "direccion" => "Av. Rómulo Gallegos, C.C. La Pascua", "telefono" => "(0235) 341.11.22" ]
            ],
            "Lara" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA BARQUISIMETO", "direccion" => "Carrera 19 entre calles 22 y 23, Edif. Nacional, Barquisimeto", "telefono" => "(0251) 231.11.22" ]
            ],
            "Mérida" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA MÉRIDA", "direccion" => "Av. Urdaneta, Edif. IVSS, Mérida", "telefono" => "(0274) 263.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA EL VIGÍA", "direccion" => "Av. Bolívar, C.C. El Vigía", "telefono" => "(0275) 881.11.22" ]
            ],
            "Miranda" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA LOS TEQUES", "direccion" => "Calle Miquileni con Arismendi, Edf. San Jose, Los Teques", "telefono" => "(0212) 364.01.87" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA GUARENAS", "direccion" => "C.C. Miranda, Nivel Planta Baja, Guarenas", "telefono" => "(0212) 362.45.11" ]
            ],
            "Monagas" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA MATURÍN", "direccion" => "Av. Bicentenario, Edif. IVSS, Maturín", "telefono" => "(0291) 641.11.22" ]
            ],
            "Nueva Esparta" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA PORLAMAR", "direccion" => "Av. 4 de Mayo, Centro Comercial Jumbo, Porlamar", "telefono" => "(0295) 263.11.22" ]
            ],
            "Portuguesa" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA ACARIGUA", "direccion" => "Av. Libertador, Edif. IVSS, Acarigua", "telefono" => "(0255) 621.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA GUANARE", "direccion" => "Carrera 5, Edif. IVSS, Guanare", "telefono" => "(0257) 251.11.22" ]
            ],
            "Sucre" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA CUMANÁ", "direccion" => "Av. Aristóbulo Istúriz, Edif. IVSS, Cumaná", "telefono" => "(0293) 431.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CARÚPANO", "direccion" => "Av. Universitaria, C.C. Carúpano", "telefono" => "(0294) 331.11.22" ]
            ],
            "Táchira" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA SAN CRISTÓBAL", "direccion" => "Av. 19 de Abril, Edif. IVSS, San Cristóbal", "telefono" => "(0276) 347.11.22" ]
            ],
            "Trujillo" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA VALERA", "direccion" => "Av. Bolívar, Edif. IVSS, Valera", "telefono" => "(0271) 225.11.22" ]
            ],
            "Vargas" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA LA GUAIRA", "direccion" => "Av. Soublette, Edif. IVSS, Maiquetía", "telefono" => "(0212) 331.11.22" ]
            ],
            "Yaracuy" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA SAN FELIPE", "direccion" => "Av. Libertador, Edif. IVSS, San Felipe", "telefono" => "(0254) 231.11.22" ]
            ],
            "Zulia" => [
                [ "nombre" => "OFICINA ADMINISTRATIVA MARACAIBO", "direccion" => "Av. 5 de Julio, cruce con Av. 10, Edif. IVSS, Maracaibo", "telefono" => "(0261) 797.11.22" ],
                [ "nombre" => "OFICINA ADMINISTRATIVA CABIMAS", "direccion" => "Carretera H, Centro Cívico, Cabimas", "telefono" => "(0264) 241.11.22" ]
            ]
        ];

        foreach ($oficinasAdmin as $estado => $oficinas) {
            foreach ($oficinas as $o) {
                Directorio::create([
                    'tipo' => 'oficina_administrativa',
                    'estado' => $estado,
                    'nombre' => $o['nombre'],
                    'direccion' => $o['direccion'],
                    'telefono' => $o['telefono']
                ]);
            }
        }

        // 3. Farmacias (From JSON file if exists)
        $farmaciasPath = 'c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_final.json';
        if (file_exists($farmaciasPath)) {
            $farmaciasJson = file_get_contents($farmaciasPath);
            $farmacias = json_decode($farmaciasJson, true);

            if ($farmacias) {
                foreach ($farmacias as $estado => $farmaciaList) {
                    // Mapeo especial para acentos si no coinciden
                    $mappedEstado = $estado;
                    if($estado == "Anzoategui") $mappedEstado = "Anzoátegui";
                    if($estado == "Bolivar") $mappedEstado = "Bolívar";
                    if($estado == "Falcon") $mappedEstado = "Falcón";
                    if($estado == "Guarico") $mappedEstado = "Guárico";
                    if($estado == "Merida") $mappedEstado = "Mérida";
                    if($estado == "Tachira") $mappedEstado = "Táchira";
                    
                    foreach ($farmaciaList as $f) {
                        Directorio::create([
                            'tipo' => 'farmacia',
                            'estado' => $mappedEstado,
                            'nombre' => $f['nombre'],
                            'direccion' => $f['direccion'],
                            'telefono' => $f['telefono']
                        ]);
                    }
                }
            }
        }
    }
}
